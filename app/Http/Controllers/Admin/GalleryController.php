<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Gallery as ThisModel;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use stdClass;

class GalleryController extends Controller
{
    protected $view = 'admin.galleries';
    protected $route = 'galleries';

    public function index()
    {
        return view($this->view . '.index');
    }

    // Hàm lấy data cho bảng list
    public function searchData(Request $request)
    {
        $objects = ThisModel::searchByFilter($request);
        return Datatables::of($objects)
            ->editColumn('updated_by', function ($object) {
                return $object->user_update->name ?? '';
            })
            ->editColumn('created_by', function ($object) {
                return $object->user_update->name ?? '';
            })
            ->editColumn('updated_at', function ($object) {
                return formatDate($object->updated_at);
            })
            ->editColumn('link', function ($object) {
                return '<a href="' . $object->link . '">' . $object->link . '</a>';
            })
            ->addColumn('image', function ($object) {
                return '<img class="thumbnail img-preview" src="' . ($object->image ? $object->image->path : '') . '">';
            })
            ->addColumn('action', function ($object) {
                $result = '';
                $result .= '<a href="javascript:void(0)" title="Sửa" class="btn btn-sm btn-primary edit"><i class="fas fa-pencil-alt"></i></a> ';
                $result .= '<a href="' . route($this->route . '.delete', $object->id) . '" title="Xóa" class="btn btn-sm btn-danger confirm"><i class="fas fa-times"></i></a>';
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['link', 'action', 'image'])
            ->make(true);
    }

    public function create()
    {
        return view($this->view . '.create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'image' => 'required|file|mimes:jpg,jpeg,png,gif|max:10240',
            ]
        );

        $json = new stdClass();

        if ($validate->fails()) {
            $json->success = false;
            $json->errors = $validate->errors();
            $json->message = "Thao tác thất bại!";
            return Response::json($json);
        }

        DB::beginTransaction();
        try {
            $object = new ThisModel();

            $object->title = $request->title;
            $object->link = $request->link;
            $object->save();

            if ($request->image) {
                FileHelper::uploadFile($request->image, 'galleries', $object->id, ThisModel::class, 'image', 99);
            }

            DB::commit();
            $json->success = true;
            $json->message = "Thao tác thành công!";
            $json->data = $object;
            return Response::json($json);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $object = ThisModel::findOrFail($id);
        if (!$object->canview()) return view('not_found');
        $object = ThisModel::getDataForShow($id);
        return view($this->view . '.show', compact('object'));
    }

    public function update(Request $request, $id)
    {

        $validate = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'image' => 'nullable|file|mimes:jpg,jpeg,png|max:10240',
            ]
        );
        $json = new stdClass();

        if ($validate->fails()) {
            $json->success = false;
            $json->errors = $validate->errors();
            $json->message = "Thao tác thất bại!";
            return Response::json($json);
        }

        DB::beginTransaction();
        try {
            $object = ThisModel::findOrFail($id);
            $object->title = $request->title;
            $object->link = $request->link;
            $object->save();

            if ($request->image) {

                if ($object->image) {
                    FileHelper::forceDeleteFiles($object->image->id, $object->id, ThisModel::class, 'image');
                }

                FileHelper::uploadFile($request->image, 'galleries', $object->id, ThisModel::class, 'image', 99);
            }

            DB::commit();
            $json->success = true;
            $json->message = "Thao tác thành công!";
            $json->data = $object;
            return Response::json($json);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        $object = ThisModel::findOrFail($id);
        if (!$object->canDelete()) {
            $message = array(
                "message" => "Không thể xóa!",
                "alert-type" => "warning"
            );
        } else {
            if (isset($object->image)) {
                FileHelper::forceDeleteFiles($object->image->id, $object->id, ThisModel::class, 'image');
            }
            $object->delete();
            $message = array(
                "message" => "Thao tác thành công!",
                "alert-type" => "success"
            );
        }


        return redirect()->route($this->route . '.index')->with($message);
    }

    public function getDataForEdit($id)
    {
        $json = new stdclass();
        $json->success = true;
        $json->data = ThisModel::getDataForEdit($id);
        return Response::json($json);
    }
}
