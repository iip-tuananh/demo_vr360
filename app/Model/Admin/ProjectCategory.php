<?php

namespace App\Model\Admin;
use Auth;
use App\Model\BaseModel;
use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;
use DB;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class ProjectCategory extends BaseModel
{

    use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $table = 'project_categories';

    public CONST HOAT_DONG = 1;
    public CONST HUY = 0;

    public CONST STATUSES = [
        [
            'id' => self::HOAT_DONG,
            'name' => 'Hoạt động',
            'type' => 'success'
        ],
        [
            'id' => self::HUY,
            'name' => 'Hủy',
            'type' => 'danger'
        ],
    ];

    public static function getAll()
    {
        return self::orderby('sort_order')->get();
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('sort_order','asc');
    }

    public function getChilds()
    {
        return self::with(['image'])->where('parent_id', $this->id)->orderBy('sort_order','asc')->get();
    }

    public function getParent()
    {
        return self::with(['image'])->where('id', $this->parent_id)->first() ? self::where('id', $this->parent_id)->first() : null;
    }

    public function parentSlug()
    {
        return self::where('id', $this->parent_id)->first() ? self::where('id', $this->parent_id)->first()->slug : null;
    }

    public function image()
    {
        return $this->morphOne(File::class, 'model');
    }

    public function projects()
    {
        return $this->hasMany('App\Model\Admin\Project','category_id','id')->orderBy('created_at','desc');
    }

    public function canEdit()
    {
        return $this->created_by == Auth::guard('admin')->user()->id;
    }

    public function canView()
    {
        return $this->status == 1 || $this->created_by == Auth::guard('admin')->user()->id;
    }

    public function canDelete ()
    {
        return Auth::guard('admin')->user()->id == $this->created_by && $this->projects->count() == 0 && $this->getChilds()->isEmpty();
    }

    public static function getForSelect() {
        $all = self::select(['id', 'name','sort_order','level'])
            ->orderBy('sort_order', 'asc')
            ->get()->toArray();
        $result = [];
        $result = array_map(function ($value) {
            if($value['level'] == 1) {
                $value['name'] = ' |-- '. $value['name'];
            }
            if($value['level'] == 2) {
                $value['name'] = ' |-- |-- '. $value['name'];
            }
            if($value['level'] == 3) {
                $value['name'] = ' |-- |-- |-- '. $value['name'];
            }
            if($value['level'] == 4) {
                $value['name'] = ' |-- |-- |-- | --'. $value['name'];
            }
            return $value;
        }, $all);
        return $result;
    }

    public static function getAllForEdit($id) {
        $all = self::where('id','<>',$id)
            ->where('parent_id','<>',$id)
            ->select(['id', 'name','sort_order','level'])
            ->orderBy('sort_order', 'asc')
            ->get()->toArray();
        $result = [];
        $result = array_map(function ($value) {
            if($value['level'] == 1) {
                $value['name'] = ' |-- '. $value['name'];
            }
            if($value['level'] == 2) {
                $value['name'] = ' |-- |-- '. $value['name'];
            }
            if($value['level'] == 3) {
                $value['name'] = ' |-- |-- |-- '. $value['name'];
            }
            if($value['level'] == 4) {
                $value['name'] = ' |-- |-- |-- | --'. $value['name'];
            }
            return $value;
        }, $all);
        return $result;
    }

    public static function getDataForEdit($id) {
        return self::where('id', $id)
            ->with([
                'image'
            ])
            ->firstOrFail();
    }

    public static function getDataForShow($id)
    {
        return self::where('id', $id)
        ->with([
            'image'
        ])
            ->firstOrFail();
    }

}
