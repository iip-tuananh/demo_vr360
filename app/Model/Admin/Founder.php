<?php

namespace App\Model\Admin;
use Auth;
use App\Model\BaseModel;
use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;
use DB;
use App\Model\Common\Notification;

class Founder extends BaseModel
{
    public function canEdit()
    {
        return Auth::guard('admin')->user()->id = $this->create_by;
    }

    public function canDelete()
    {
        return true;
    }

    public function image()
    {
        return $this->morphOne(File::class, 'model')->where('custom_field', 'image');
    }

    public static function searchByFilter($request) {
        $result = self::query();

        if (!empty($request->name)) {
            $result = $result->where('name', 'like', '%'.$request->name.'%');
        }

        $result = $result->orderBy('created_at','desc')->get();
        return $result;
    }

    public static function getForSelect() {
        return self::where('status', 1)
            ->select(['id', 'name'])
            ->orderBy('name', 'ASC')
            ->get();
    }

    public static function getDataForEdit($id) {
        return self::where('id', $id)
            ->with(['image'])
            ->firstOrFail();
    }

    public static function getDataForShow($id) {
        return self::where('id', $id)
            ->with(['image'])
            ->firstOrFail();
    }

}
