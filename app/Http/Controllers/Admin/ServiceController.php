<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Service as ThisModel;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Validator;
use \stdClass;
use Response;
use DB;

class ServiceController extends Controller
{
	protected $view = 'admin.services';
	protected $route = 'services';

	public function index()
	{
		return view($this->view.'.index');
	}

	// Hàm lấy data cho bảng list
    public function searchData(Request $request)
    {
		$objects = ThisModel::searchByFilter($request);

        return Datatables::of($objects)
			->editColumn('name', function ($object) {
				return '<a href = "'.route('services.edit',$object->id).'" title = "Xem chi tiết">'.$object->name.'</a>';
			})
			->editColumn('price', function ($object) {
				return formatCurrency($object->price);
			})
			->editColumn('base_price', function ($object) {
				return formatCurrency($object->base_price);
			})
			->editColumn('service_type', function ($object) {
				return $object->serviceType ? $object->serviceType->name : '';
			})
			->editColumn('created_at', function ($object) {
				return Carbon::parse($object->created_at)->format("d/m/Y");
			})
			->editColumn('created_by', function ($object) {
				return $object->user_create->name ? $object->user_create->name : '';
			})
			->editColumn('updated_by', function ($object) {
				return $object->user_update->name ? $object->user_update->name : '';
			})
            ->editColumn('image', function ($object) {
                return '<img style ="max-width:45px !important" src="' . ($object->image->path ?? '') . '"/>';
            })
			->addColumn('action', function ($object) {
                $result = '<div class="btn-group btn-action">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class = "fa fa-cog"></i>
                </button>
                <div class="dropdown-menu">';
                $result = $result . ' <a href="'. route($this->route.'.edit', $object->id) .'" title="sửa" class="dropdown-item"><i class="fa fa-angle-right"></i>Sửa</a>';
                if ($object->canDelete()) {
                    $result = $result . ' <a href="' . route($this->route.'.delete', $object->id) . '" title="xóa" class="dropdown-item confirm"><i class="fa fa-angle-right"></i>Xóa</a>';
                }
                $result = $result . '</div></div>';
                return $result;
			})

			->addIndexColumn()
			->rawColumns(['name','action', 'image'])
			->make(true);
    }

	public function create()
	{
		return view($this->view.'.create');
	}

	public function store(Request $request)
	{
		$validate = Validator::make(
			$request->all(),
			[
				'name' => 'required|unique:services,name',
                // 'service_type_id' => 'required|exists:service_types,id',
				'status' => 'required|in:0,1',
				'description' => 'nullable|max:255',
				'content' => 'required',
                // 'base_price' => 'required|integer',
                // 'price' => 'nullable|integer|max:'.$request->base_price,
				'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2000'
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
			$object->name = $request->name;
			// $object->service_type_id = $request->service_type_id;
			$object->description = $request->description;
			$object->content = $request->content;
			// $object->base_price = $request->base_price;
			// $object->price = $request->price;
			// $object->time = $request->time;
			$object->status = $request->status;
			$object->save();

            if ($request->image) {
                FileHelper::uploadFile($request->image, 'services', $object->id, ThisModel::class, 'image', 99);
            }
            $object->syncGalleries($request->galleries);

			DB::commit();
			$json->success = true;
			$json->message = "Thao tác thành công!";
			return Response::json($json);
		} catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
	}

	public function edit(Request $request,$id)
	{
		$object = ThisModel::getDataForEdit($id);
		return view($this->view.'.edit', compact('object'));
	}

	public function update(Request $request, $id)
	{

		$validate = Validator::make(
			$request->all(),
			[
				'name' => 'required|unique:services,name,'.$id,
                // 'service_type_id' => 'required|exists:service_types,id',
				'status' => 'required|in:0,1',
				'description' => 'nullable|max:255',
				'content' => 'required',
                // 'base_price' => 'required|integer',
                // 'price' => 'nullable|integer|max:'.$request->base_price,
				'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2000'
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

			$object->name = $request->name;
			// $object->service_type_id = $request->service_type_id;
			$object->description = $request->description;
			$object->content = $request->content;
			// $object->base_price = $request->base_price;
			// $object->price = $request->price;
			// $object->time = $request->time;
			$object->status = $request->status;
			$object->save();

			if ($request->image) {
                if ($object->image) {
                    FileHelper::forceDeleteFiles($object->image->id, $object->id, ThisModel::class, 'image');
                }
				FileHelper::uploadFile($request->image, 'services', $object->id, ThisModel::class, 'image', 99);
			}

			$object->syncGalleries($request->galleries);

			DB::commit();
			$json->success = true;
			$json->message = "Thao tác thành công!";
			return Response::json($json);
		} catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception($e);
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
            if ($object->image) {
                FileHelper::forceDeleteFiles($object->image->id, $object->id, ThisModel::class, 'image');
            }
			$object->delete();
			$message = array(
				"message" => "Thao tác thành công!",
				"alert-type" => "success"
			);
		}


        return redirect()->route($this->route.'.index')->with($message);
	}

	public function getData(Request $request, $id) {
        $json = new stdclass();
        $json->success = true;
        $json->data = ThisModel::getDataForEdit($id);
        return Response::json($json);
	}
}
