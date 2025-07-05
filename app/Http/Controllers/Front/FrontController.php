<?php

namespace App\Http\Controllers\Front;

use App\Helpers\FileHelper;
use App\Http\Traits\ResponseTrait;
use App\Model\Admin\Block;
use App\Model\Admin\Category;
use App\Model\Admin\CategorySpecial;
use App\Model\Admin\Product;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use Response;
use App\Http\Controllers\Controller;
use App\Model\Admin\Banner;
use App\Model\Admin\Config;
use App\Model\Admin\Contact;
use App\Model\Admin\Founder;
use App\Model\Admin\Gallery;
use App\Model\Admin\Order;
use App\Model\Admin\OrderDetail;
use App\Model\Admin\Partner;
use App\Model\Admin\Policy;
use App\Model\Admin\Post;
use App\Model\Admin\PostCategory;
use App\Model\Admin\ProductRate;
use App\Model\Admin\Project;
use App\Model\Admin\ProjectCategory;
use App\Model\Admin\Review;
use App\Model\Admin\Service;
use App\Model\Admin\Voucher;
use App\Model\Common\User;
use DB;
use Mail;
use SluggableScopeHelpers;

class FrontController extends Controller
{
    use ResponseTrait;

    public $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function homePage() {
        return view('site.home');
    }

    public function demoVr360() {
        return view('site.demo-vr360.vr360');
    }

    // ajax load product home page
    public function loadProductHomePage(Request $request)
    {
        $category = CategorySpecial::findBySlug($request->handle);
        $products = $category->products()->with([
            'image', 'galleries',
            'product_rates' => function($q) {
                $q->where('status', 2);
            }
            ])->where('status', 1)->limit(10)->orderBy('created_at', 'desc')->get();
        $html = '';
        foreach ($products as $product) {
            $html .= view('site.partials.item_product', compact('product', 'category'))->render();
        }

        return Response::json([
            'html' => $html,
        ]);
    }

    // ajax get product quick view
    public function getProductQuickView(Request $request)
    {
        // $product = Product::findBySlug($request->handle);
        $product = Product::with([
            'product_rates' => function($q) {
                $q->where('status', 2);
            }
        ])->where('id', $request->product_id)->first();
        $html = view('site.partials.quick_view_product', compact('product'))->render();

        return Response::json([
            'html' => $html,
        ]);

    }

    public function showProductDetail($slug) {
        try {
            $categories = Category::getAllCategory();
            $product = Product::query()->with([
                'image',
                'galleries' => function ($q) {
                    $q->select(['id', 'product_id', 'sort'])
                        ->with(['image'])
                        ->orderBy('sort', 'ASC');
                },
            ])->where('slug', $slug)->first();
            $attributes = [];
            foreach ($product->attributeValues as $attribute) {
                if(!isset($attributes[$attribute->id])) {
                    $attributes[$attribute->id] = [
                        'name' => $attribute->name,
                        'values' => [$attribute->pivot->value]
                    ];
                } else {
                    $attributes[$attribute->id]['values'][] = $attribute->pivot->value;
                }
            }
            $product->attributes = $attributes;

            // sản phẩm tương tự
            $productsRelated = $product->category->products()->with([
                'product_rates' => function($q) {
                    $q->where('status', 2);
                }
            ])->whereNotIn('id', [$product->id])->orderBy('created_at', 'desc')->get();

            $bestSellerProducts = Product::query()->with([
                'product_rates' => function($q) {
                    $q->where('status', 2);
                }
            ])->where('status', 1)->inRandomOrder()->limit(6)->get();

            $category = Category::query()->where('id', $product->cate_id)->first();

            $arr_product_rate_images = [];
            foreach ($product->product_rates as $rate) {
                foreach ($rate->images as $image) {
                    $arr_product_rate_images[] = $image->path;
                }
            }

            $canReview = false;
            if(\Auth::guard('client')->check()) {
                $existsOrder = OrderDetail::where('product_id', $product->id)
                ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
                ->where('orders.customer_email', \Auth::guard('client')->user()->email)
                ->where('orders.status', Order::THANH_CONG)->exists();
                if($existsOrder) {
                    $canReview = true;
                }
            }
            // $isProductFlashsale = $product->category_specials()->where('type', 10)->where('show_home_page', 1)->where('order_number', 1)->first();
            // $dateFlashsale = $isProductFlashsale ? $isProductFlashsale->to_date : null;
            // $vouchers = Voucher::query()->where('status', 1)->where('quantity', '>', 0)->where('to_date', '>=', now())->orderBy('created_at', 'desc')->get();
            // $data['smallBanners'] = Banner::with(['image'])->where('position', 2)->orderBy('id', 'desc')->limit(3)->get();
            // $data['partners'] = Partner::with(['image'])->get();

            $newBlogs = Post::with(['image'])->where(['status'=>1])
            ->orderBy('id','DESC')
            ->select(['id','name','slug', 'created_at'])
            ->limit(6)->get();

            return view('site.products.product_detail', compact('categories', 'product', 'productsRelated', 'category', 'arr_product_rate_images', 'bestSellerProducts', 'canReview', 'newBlogs'));
        }catch (\Exception $exception) {
            return view('site.errors');
            Log::error($exception);
        }
    }


    public function showProductCategory(Request $request, $categorySlug = null)
    {
        $categories = Category::parent()->with('products')->orderBy('sort_order')->get();
        $category = Category::with(['childs'])->where('slug', $categorySlug)->first();
        $sort = $request->get('sort') ?: 'lasted';
        if($category) {
            $category_parent_id = $category->parent ? $category->parent->id : null;
            $arr_category_id = array_merge($category->childs->pluck('id')->toArray(), [$category->id, $category_parent_id]);
            if ($category->childs) {
                foreach ($category->childs as $child) {
                    $arr_category_id = array_merge($arr_category_id, $child->childs->pluck('id')->toArray());
                }
            }

            $products = Product::with([
                'product_rates' => function($q) {
                    $q->where('status', 2);
                }
            ])->where('status', 1)->whereIn('cate_id', $arr_category_id)->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $category = CategorySpecial::findBySlug($categorySlug);
            $products = $category->products()->with([
                'product_rates' => function($q) {
                    $q->where('status', 2);
                }
            ])->where('status', 1)->orderBy('created_at', 'desc')->paginate(20);
        }

        $title = $category->name;
        $short_des = $category->short_des;
        $title_sub = $category->name;
        $smallBanners = Banner::with(['image'])->where('position', 2)->orderBy('id', 'desc')->limit(3)->get();
        $partners = Partner::with(['image'])->get();

        $categorySpecial = CategorySpecial::query()->with(['products' => function($q) {$q->where('status', 1)->limit(5);}])
            ->has('products')
            ->where('type',10)
            ->where('show_home_page', 1)
            ->orderBy('order_number')->get();

        // $vouchers = Voucher::query()->where('status', 1)->where('quantity', '>', 0)->where('to_date', '>=', now())->orderBy('created_at', 'desc')->get();
        if(! $category) {
            return view('site.errors');
        }

        return view('site.products.product_category', compact('categories', 'category', 'sort', 'categorySpecial', 'products', 'title', 'short_des', 'title_sub', 'smallBanners', 'partners'));
    }

    public function loadMoreProduct(Request $request)
    {
        $category = Category::query()->find($request->cate_id);

        $products = Product::query()->where('status', 1);

        if ($sort = $request->get('sort')) {
            if ($sort == 'lasted') {
                $products->orderBy('created_at', 'desc');
            } else if ($sort == 'priceAsc') {
                $products->orderBy('price', 'asc');
            } else if ($sort == 'priceDesc') {
                $products->orderBy('price', 'desc');
            }
        } else {
             $products->orderBy('created_at', 'desc');
        }

        $product_all_ids = $category->products()->pluck('id')->toArray();

        if( $request->product_ids_load_more) {
            $products->whereIn('id', array_diff($product_all_ids, $request->product_ids_load_more));
        }

        $products = $products->where('cate_id', $category->id)->limit(1)->get();

        // mảng product id
        $product_ids = $products->pluck('id')->toArray();

        $html = '';

        $product_ids_ = array_merge($request->product_ids_load_more ?? [], $product_ids);

        $hasProductsNextPage = false;

        if($product_ids && Product::query()->whereNotIn('id', $product_ids_)->count()) $hasProductsNextPage = true;

        foreach ($products as $product) {
            $html .= view( 'site.partials.card_product', compact('product', 'category'))->render();
        }


        return Response::json([
            'html' => $html,
            'product_ids' => $product_ids,
            'hasProductsNextPage' => $hasProductsNextPage,
        ]);

    }


    // Giới thiệu
    public function aboutUs()
    {
        $policies = Policy::query()->where('status', true)->latest()->get();
        $config = Config::query()->get()->first();
        $partners = Partner::with(['image'])->get();
        $founders = Founder::query()->with(['image'])->orderBy('id', 'desc')->select(['id', 'name', 'position', 'description', 'link_facebook', 'link_instagram', 'link_website', 'link_twitter', 'phone', 'email', 'zalo'])->get();
        $content = $config->introduction;
        $title = 'Về chúng tôi';
        $description = $config->web_des;
        return view('site.about_us', compact('content', 'policies', 'title', 'description', 'partners', 'founders'));
    }

    // Đăng ký cộng tác viên
    public function connectUs()
    {
        return view('site.connect_register');
    }

    // Liên hệ
    public function contactUs()
    {
        return view('site.contact_us');
    }

    public function postContact(Request $request)
    {
        $rule  =  [
            'your_name' => 'required',
            'your_phone'  => 'required|regex:/^(0)[0-9]{9,11}$/',
            'your_email'  => 'required|email|max:255'
        ];

        $validate = Validator::make(
            $request->all(),
            $rule,
            [
                'your_name.required' => 'Vui lòng nhập họ tên',
                'your_phone.required' => 'Vui lòng nhập số điện thoại',
                'your_phone.regex' => 'Số điện thoại không đúng định dạng',
                'your_email.required' => 'Vui lòng nhập email',
            ]
        );

        if ($validate->fails()) {
            return $this->responseErrors('Gửi yêu cầu thất bại!', $validate->errors());
        }

        $contact = new Contact();
        $contact->user_name = $request->your_name;
        $contact->email = $request->your_email;
        $contact->phone_number = $request->your_phone;
        $contact->content = $request->your_message;
        $contact->location = $request->your_location ?? null;
        $contact->save();

        return $this->responseSuccess('Gửi yêu cầu thành công!');
    }

    // Blogs
    public function listBlog(Request $request, $slug)
    {
        $category = PostCategory::where('slug', $slug)->first();
        $data['blogs'] = Post::with(['image'])->where(['status'=>1,'cate_id'=>$category->id])
            ->orderBy('id','DESC')
            ->select(['id','name','intro','created_at','slug','cate_id'])
            ->paginate(15);

        $data['cate_title'] = $category->name;
        $data['postCategories'] = PostCategory::with([
            'posts' => function ($query){
                $query->where(['status'=>1])->get();
            }
        ])->where(['parent_id' => 0, 'show_home_page' => 1])->latest()->get();
        $data['newBlogs'] = Post::with(['image'])->where(['status'=>1])
            ->orderBy('id','DESC')
            ->select(['id','name','slug', 'created_at'])
            ->limit(6)->get();

        $data['productCategories'] = Category::query()->with([
            'childs' => function ($query) {
                $query->with(['childs']);
            }
        ])
        ->where(['type' => 1, 'parent_id' => 0])
        ->orderBy('sort_order')
        ->get();
        $data['services'] = Service::query()->where('status', true)->latest()->get();
        return view('site.blogs.list', $data);
    }

    public function indexBlog(Request $request)
    {
        $data['blogs'] = Post::with(['image', 'category'])->where(['status'=>1])
            ->orderBy('id','DESC')
            ->select(['id','name','intro','created_at','slug', 'cate_id'])
            ->paginate(6);

        $data['cate_title'] = 'Tin tức';
        $data['categories'] = PostCategory::with([
            'posts' => function ($query){
                $query->where(['status'=>1])->get();
            }
        ])->where(['parent_id' => 0, 'show_home_page' => 1])->latest()->get();
        $data['newBlogs'] = Post::with(['image'])->where(['status'=>1])
            ->orderBy('id','DESC')
            ->select(['id','name','slug', 'created_at'])
            ->limit(6)->get();

        $data['services'] = Service::query()->where('status', true)->latest()->get();
        return view('site.blogs.list', $data);
    }

    public function detailBlog(Request $request, $slug)
    {
        $blog = Post::with(['image', 'user_create'])->where('slug', $slug)->first();
        $category = PostCategory::where('id', $blog->cate_id)->first();
        $data['other_blogs'] = Post::with(['image'])->where(['status'=>1,'cate_id'=>$blog->cate_id])
        ->where('id', '!=', $blog->id)
        ->select(['id','name','intro','created_at','slug', 'cate_id'])
        ->limit(16)->inRandomOrder()->get();
        $data['blog_title'] = $blog->name;
        $data['blog_des'] = $blog->intro;
        $data['postCategories'] = PostCategory::with([
            'posts' => function ($query){
                $query->where(['status'=>1])->get();
            }
        ])->where(['parent_id' => 0, 'show_home_page' => 1])->latest()->get();
        $data['productCategories'] = Category::query()->with([
            'childs' => function ($query) {
                $query->with(['childs']);
            }
        ])
        ->where(['type' => 1, 'parent_id' => 0])
        ->orderBy('sort_order')
        ->get();
        $data['newBlogs'] = Post::with(['image'])->where(['status'=>1])
        ->orderBy('id','DESC')
        ->select(['id','name','slug', 'created_at'])
        ->limit(6)->get();
        $data['blog'] = $blog;
        $data['blog_slug'] = $blog->slug;
        $data['cate_title'] = $category->name;
        $data['category'] = $category;

        $data['services'] = Service::query()->where('status', true)->latest()->get();

        return view('site.blogs.detail', $data);
    }

    // Tìm kiếm
    public function autoSearchComplete(Request $request)
    {
        if (isset($request->keyword)) {
            $products = Product::with(['image'])->where('name','LIKE','%'.$request->keyword.'%')->where('status', 1)->orderBy('id','DESC')->limit(10)->get();
            $view = view("site.partials.ajax_search_results",compact('products'))->render();
        } else {
            $view = '';
        }

        return Response::json([
            'html'=>$view
        ]);
    }

    public function resetData() {
        \Illuminate\Support\Facades\DB::table('orders')->truncate();
        \Illuminate\Support\Facades\DB::table('contacts')->truncate();
    }

    // laster buy products
    public function lasterBuyProducts() {
        $product = \DB::table('products')
        ->where('status', 1)
        ->leftJoin('files', function($join) {
            $join->on('files.model_id', '=', 'products.id')
            ->where('files.custom_field', 'image')->where('files.model_type', Product::class);
        })
        ->inRandomOrder()->first(['products.id', 'products.name', 'products.slug', 'files.path']);
        return Response::json([
            'product' => $product,
        ]);
    }

    // review
    public function submitReview(Request $request) {
        $rule  =  [
            'name' => 'required',
            'email'  => 'required|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'phone'  => 'required|regex:/^(0)[0-9]{9,11}$/',
            'rating' => 'required|numeric|min:1|max:5',
            'title' => 'required',
            'galleries' => 'required|array|min:1|max:5',
            'galleries.*.image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'desc' => 'required',
            'product_id' => 'required|exists:products,id',
        ];

        $validate = Validator::make(
            $request->all(),
            $rule,
            [
                'name.required' => 'Vui lòng nhập họ tên',
                'phone.required' => 'Vui lòng nhập số điện thoại',
                'phone.regex' => 'Số điện thoại không đúng định dạng',
                'email.required' => 'Vui lòng nhập email',
                'email.regex' => 'Email không đúng định dạng',
                'rating.required' => 'Vui lòng đánh giá sản phẩm',
                'rating.numeric' => 'Đánh giá không hợp lệ',
                'rating.min' => 'Đánh giá không hợp lệ',
                'rating.max' => 'Đánh giá không hợp lệ',
                'title.required' => 'Vui lòng nhập tiêu đề',
                'galleries.required' => 'Vui lòng chọn ít nhất 1 hình ảnh',
                'galleries.array' => 'Dữ liệu không hợp lệ',
                'galleries.min' => 'Vui lòng chọn ít nhất 1 hình ảnh',
                'galleries.max' => 'Vui lòng chọn tối đa 5 hình ảnh',
                'desc.required' => 'Vui lòng nhập nội dung đánh giá',
                'galleries.*.image.image' => 'Vui lòng chọn file hình ảnh',
                'galleries.*.image.mimes' => 'File không hợp lệ',
                'galleries.*.image.max' => 'File không được lớn hơn 5MB',
                'product_id.required' => 'Sản phẩm không hợp lệ',
                'product_id.exists' => 'Sản phẩm không hợp lệ',
            ]
        );


        if ($validate->fails()) {
            return $this->responseErrors('Gửi yêu cầu thất bại!', $validate->errors());
        }

        $store_data = [
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'rating' => $request->rating,
            'title' => $request->title,
            'desc' => $request->desc,
        ];

		DB::beginTransaction();
		try {
			$object = new ProductRate();
			$object->fill($store_data);
			$object->save();

            $galleries = $request->galleries;
			foreach ($galleries as $gallery) {
                if (isset($gallery['image'])) {
                    $file = $gallery['image'];
                    FileHelper::uploadFile($file, 'product_rate', $object->id, ProductRate::class, 'image', 1);
                }
            }

			DB::commit();
			return $this->responseSuccess('Gửi đánh giá thành công!');
		} catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    // Tìm kiếm trang list product
    public function search(Request $request) {
        $query = Product::query()->where('status', 1);
        if (!empty($request->keyword)) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        if (!empty($request->tag)) {
            $query->whereHas('tags', function ($query) use ($request) {
                $query->where('name', $request->tag);
            });
        }
        $categories = Category::query()->get();
        $vouchers = Voucher::query()->where('status', 1)->where('quantity', '>', 0)->where('to_date', '>=', now())->orderBy('created_at', 'desc')->get();
        $products = $query->paginate(20);
        $title = 'Tìm kiếm';
        $short_des = 'Kết quả tìm kiếm';
        $title_sub = 'Tìm thấy '.count($products).' kết quả phù hợp';
        $smallBanners = Banner::with(['image'])->where('position', 2)->orderBy('id', 'desc')->limit(3)->get();
        $partners = Partner::with(['image'])->get();
        return view('site.products.product_category', compact('products', 'title', 'short_des', 'title_sub', 'categories', 'vouchers', 'smallBanners', 'partners'));
    }

    // Chính sách
    public function policyDetail($slug) {
        $policy = Policy::where('slug', $slug)->first();
        $policies = Policy::query()->where('status', true)->latest()->get();
        $title = $policy->title;
        $content = $policy->content;
        $description = $policy->title;
        return view('site.about_us', compact('content', 'title', 'policies', 'description'));
    }

    public function serviceDetail($slug)
    {
        $service = Service::where('slug', $slug)->first();
        $services = Service::query()->where('status', true)->latest()->get();
        $title = $service->name;
        $content = $service->content;
        $description = $service->description;
        $newBlogs = Post::with(['image'])->where(['status'=>1])
        ->orderBy('id','DESC')
        ->select(['id','name','slug', 'created_at'])
        ->limit(6)->get();
        return view('site.services.service_detail', compact('content', 'title', 'services', 'description', 'service', 'newBlogs'));
    }

    public function showCategoryProject($slug) {
        $category = ProjectCategory::where('slug', $slug)->first();
        $projects = Project::with(['image', 'category'])->where('category_id', $category->id)->paginate(15);
        $title = $category->name;
        $description = $category->intro;
        return view('site.projects.project_category', compact('projects', 'title', 'description'));
    }

    public function showProjectDetail($slug) {
        $project = Project::with(['image', 'category', 'galleries'])->where('slug', $slug)->first();
        $title = $project->title;
        $description = $project->short_des;
        return view('site.projects.project_detail', compact('project', 'title', 'description'));
    }
}
