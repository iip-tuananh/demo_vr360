<?php

namespace App\Model\Admin;

use App\Helpers\FileHelper;
use App\Model\BaseModel;
use App\Model\Common\File;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use DB;

class Project extends BaseModel
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $table = 'projects';
    protected $fillable = ['id', 'created_by', 'updated_by', 'title', 'address', 'short_des', 'des', 'category_id', 'show_home_page'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function image()
    {
        return $this->morphOne(File::class, 'model')->where('custom_field', 'image');
    }

    public function galleries()
    {
        return $this->hasMany(ProjectGallery::class, 'project_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id', 'id');
    }

    public function canEdit()
    {
        return Auth::guard('admin')->user()->id = $this->create_by;
    }

    public function canDelete()
    {
        return true;
    }

    public static function searchByFilter($request)
    {
        $result = self::query()->with(['image', 'galleries']);

        if (!empty($request->name)) {
            $result = $result->where('name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->email)) {
            $result = $result->where('email', 'like', '%' . $request->email . '%');
        }

        $result = $result->orderBy('created_at', 'desc')->get();

        return $result;
    }

    public static function getForSelect()
    {
        return self::select(['id', 'name'])
            ->orderBy('name', 'ASC')
            ->get();
    }

    public static function getDataForEdit($id)
    {
        return self::query()->with([
            'image',
            'galleries' => function ($q) {
                    $q->select(['id', 'project_id', 'sort'])
                        ->with(['image'])
                        ->orderBy('sort', 'ASC');
                },
        ])
            ->where('id', $id)
            ->firstOrFail();
    }

    public static function getDataForShow($id)
    {
        return self::where('id', $id)
            ->firstOrFail();
    }

    public function syncGalleries($galleries)
    {
        if ($galleries) {
            $exist_ids = [];
            foreach ($galleries as $g) {
                if (isset($g['id'])) array_push($exist_ids, $g['id']);
            }

            $deleted = ProjectGallery::where('project_id', $this->id)->whereNotIn('id', $exist_ids)->get();
            foreach ($deleted as $item) {
                if ($item->image) {
                    FileHelper::forceDeleteFiles($item->image->id, $this->id, ProjectGallery::class, null);
                    $item->image->removeFromDB();
                }
                $item->removeFromDB();
            }

            for ($i = 0; $i < count($galleries); $i++) {
                $g = $galleries[$i];

                if (isset($g['id'])) $gallery = ProjectGallery::find($g['id']);
                else $gallery = new ProjectGallery();

                $gallery->project_id = $this->id;
                $gallery->sort = $i;
                $gallery->save();

                if (isset($g['image'])) {
                    if ($gallery->image) $gallery->image->removeFromDB();
                    $file = $g['image'];
                    FileHelper::uploadFile($file, 'project_gallery', $gallery->id, ProjectGallery::class, null, 99);
                }
            }
        } else {
            $galleries = $this->galleries;
            foreach ($galleries as $gallery) {
                if ($gallery->image) {
                    FileHelper::forceDeleteFiles($gallery->image->id, $this->id, ProjectGallery::class, null);
                    $gallery->image->removeFromDB();
                }
                $gallery->removeFromDB();
            }
        }
    }
}
