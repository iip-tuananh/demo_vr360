<?php

use App\Model\Common\User;
Route::get('/dang-nhap', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::group(['prefix' => 'admin'], function () {
    Route::get('dang-xuat','Auth\LoginController@logout')->name('logout');
    Route::get('/login-page',function() {
        return view('layouts.login');
    });
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/', function () {
        if(!Auth::guard('admin')->guest()) {
            return redirect()->route('dash');
        } else {
            return redirect()->route('login');
        }
    })->name('index');

    Route::middleware('auth:admin')->group(function () {
        // Cấu hình chung
        Route::group(['prefix' => 'configs', 'middleware' => 'checkPermission:Cập nhật cấu hình'], function () {
            Route::get('/', 'Admin\ConfigController@edit')->name('Config.edit')->middleware('checkPermission:Cập nhật cấu hình');
            Route::post('/update', 'Admin\ConfigController@update')->name('Config.update')->middleware('checkPermission:Cập nhật cấu hình');
        });

        // Menu Catalog
        Route::group(['prefix' => 'categories'], function() {
            Route::get('/create', 'Admin\CategoryController@create')->name('Category.create');
            Route::post('/', 'Admin\CategoryController@store')->name('Category.store');
            Route::post('/{id}/update', 'Admin\CategoryController@update')->name('Category.update');
            Route::get('/{id}/edit', 'Admin\CategoryController@edit')->name('Category.edit');
            Route::get('/{id}/delete', 'Admin\CategoryController@delete')->name('Category.delete');
            Route::get('/', 'Admin\CategoryController@index')->name('Category.index');
            Route::get('/searchData', 'Admin\CategoryController@searchData')->name('Category.searchData');
            Route::post('/nested-sort', 'Admin\CategoryController@nestedSort')->name('Category.nestedSort');
            Route::get('/{id}/getDataForEdit', 'Admin\CategoryController@getDataForEdit')->name('Category.get.data.edit');
            Route::post('add-to-home-page', 'Admin\CategoryController@addToHomePage')->name('Category.add.homepage');
            Route::get('/get-parent', 'Admin\CategoryController@getParentCategory')->name('Category.get.parent');
        });

        Route::group(['prefix' => 'products'], function () {
            Route::get('/', 'Admin\ProductController@index')->name('Product.index');
            Route::get('/create', 'Admin\ProductController@create')->name('Product.create')->middleware('checkPermission:Thêm hàng hóa');
            Route::post('/', 'Admin\ProductController@store')->name('Product.store')->middleware('checkPermission:Thêm hàng hóa');
            Route::post('/{id}/update', 'Admin\ProductController@update')->name('Product.update')->middleware('checkPermission:Sửa hàng hóa');
            Route::get('/{id}/edit', 'Admin\ProductController@edit')->name('Product.edit')->middleware('checkPermission:Sửa hàng hóa');
            Route::get('/{id}/delete', 'Admin\ProductController@delete')->name('Product.delete')->middleware('checkPermission:Xóa hàng hóa');
            Route::get('/searchData', 'Admin\ProductController@searchData')->name('Product.searchData');
            Route::get('/filterDataForBill', 'Admin\ProductController@filterDataForBill')->name('Product.filterDataForBill');
            Route::get('/{id}/getData', 'Admin\ProductController@getData')->name('Product.getData');
            Route::get('/exportExcel','Admin\ProductController@exportExcel')->name('Product.exportExcel')->middleware('checkPermission:Xuất excel sản phẩm');
            Route::get('/exportPDF','Admin\ProductController@exportPDF')->name('Product.exportPDF')->middleware('checkPermission:Xuất pdf sản phẩm');
            Route::post('/add-category-special', 'Admin\ProductController@addToCategorySpecial')->name('Product.add.category.special');

            Route::get('/act-delete', 'Admin\ProductController@actDelete')->name('products.delete.multi');
            Route::post('/{id}/deleteFile', 'Admin\ProductController@deleteFile')->name('products.deleteFile');
        });

        // Đánh giá sản phẩm
        Route::group(['prefix' => 'product-rates'], function () {
            Route::get('/', 'Admin\ProductRateController@index')->name('product_rates.index');
            Route::get('/searchData', 'Admin\ProductRateController@searchData')->name('product_rates.searchData');
            Route::get('/{id}/show', 'Admin\ProductRateController@show')->name('product_rates.show');
            Route::post('/update-status', 'Admin\ProductRateController@updateStatus')->name('product_rates.update.status');
            Route::get('/{id}/getDataForEdit', 'Admin\ProductRateController@getDataForEdit')->name('product_rates.getDataForEdit');
        });

        Route::group(['prefix' => 'post-categories'], function() {
            Route::get('/create', 'Admin\PostCategoryController@create')->name('PostCategory.create');
            Route::post('/', 'Admin\PostCategoryController@store')->name('PostCategory.store');
            Route::post('/{id}/update', 'Admin\PostCategoryController@update')->name('PostCategory.update');
            Route::get('/{id}/edit', 'Admin\PostCategoryController@edit')->name('PostCategory.edit');
            Route::get('/{id}/getDataForEdit', 'Admin\PostCategoryController@getDataForEdit');
            Route::get('/{id}/delete', 'Admin\PostCategoryController@delete')->name('PostCategory.delete');
            Route::get('/', 'Admin\PostCategoryController@index')->name('PostCategory.index');
            Route::get('/searchData', 'Admin\PostCategoryController@searchData')->name('PostCategory.searchData');
            Route::post('/nested-sort', 'Admin\PostCategoryController@nestedSort')->name('PostCategory.nestedSort');
            Route::post('/add-home-page', 'Admin\PostCategoryController@addToHomepage')->name('PostCategory.add.home.page');
        });

        // danh mục liên hệ
        Route::group(['prefix' => 'contacts'], function () {
            Route::get('/', 'Admin\ContactController@index')->name('contacts.index');
            Route::get('/searchData', 'Admin\ContactController@searchData')->name('contacts.searchData');
            Route::get('/{id}/detail', 'Admin\ContactController@getContactDetail')->name('contacts.detail');
            Route::get('/{id}/delete', 'Admin\ContactController@delete')->name('contacts.delete');
        });

        Route::group(['prefix' => 'apply-recruitments'], function () {
            Route::get('/', 'Admin\ApplyRecruitmentsController@index')->name('apply-recruitments.index');
            Route::get('/searchData', 'Admin\ApplyRecruitmentsController@searchData')->name('apply-recruitments.searchData');
            Route::get('/{id}/detail', 'Admin\ApplyRecruitmentsController@getDetail')->name('apply-recruitments.detail');
            Route::get('/{id}/delete', 'Admin\ApplyRecruitmentsController@delete')->name('apply-recruitments.delete');
        });

        Route::group(['prefix' => 'showrooms'], function () {
            Route::get('/', 'Admin\ShowroomController@index')->name('showrooms.index');
            Route::get('/searchData', 'Admin\ShowroomController@searchData')->name('showrooms.searchData');
            Route::get('/{id}/show', 'Admin\ShowroomController@show')->name('showrooms.show');
            Route::get('/create', 'Admin\ShowroomController@create')->name('showrooms.create');
            Route::post('/', 'Admin\ShowroomController@store')->name('showrooms.store');
            Route::post('/{id}/update', 'Admin\ShowroomController@update')->name('showrooms.update');
            Route::post('/updateOrderShowroom', 'Admin\ShowroomController@updateOrderShowroom')->name('showrooms.updateOrderShowroom');
            Route::get('/{id}/delete', 'Admin\ShowroomController@delete')->name('showrooms.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ShowroomController@getDataForEdit')->name('showrooms.getDataForEdit');
        });

        Route::group(['prefix' => 'e-brochure'], function () {
            Route::get('/', 'Admin\EBrochureController@index')->name('e-brochure.index');
            Route::get('/searchData', 'Admin\EBrochureController@searchData')->name('e-brochure.searchData');
            Route::get('/{id}/show', 'Admin\EBrochureController@show')->name('e-brochure.show');
            Route::get('/create', 'Admin\EBrochureController@create')->name('e-brochure.create');
            Route::post('/', 'Admin\EBrochureController@store')->name('e-brochure.store');
            Route::post('/{id}/update', 'Admin\EBrochureController@update')->name('e-brochure.update');
            Route::post('/updateOrderShowroom', 'Admin\EBrochureController@updateOrderShowroom')->name('e-brochure.updateOrderShowroom');
            Route::get('/{id}/delete', 'Admin\EBrochureController@delete')->name('e-brochure.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\EBrochureController@getDataForEdit')->name('e-brochure.getDataForEdit');
        });

        // Bài viết
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', 'Admin\PostController@index')->name('Post.index');
            Route::get('/searchData', 'Admin\PostController@searchData')->name('Post.searchData');
            Route::get('/{id}/show', 'Admin\PostController@show')->name('Post.show');
            Route::get('/{id}/getData', 'Admin\PostController@getData')->name('Post.getData');
            Route::get('/create', 'Admin\PostController@create')->name('Post.create')->middleware('checkPermission:Thêm bài viết');
            Route::post('/', 'Admin\PostController@store')->name('Post.store')->middleware('checkPermission:Thêm bài viết');
            Route::post('/{id}/update', 'Admin\PostController@update')->name('Post.update')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/edit', 'Admin\PostController@edit')->name('Post.edit')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/delete', 'Admin\PostController@delete')->name('Post.delete')->middleware('checkPermission:Xóa bài viết');
            Route::get('/exportExcel','Admin\PostController@exportExcel')->name('Post.exportExcel');
            Route::post('/add-to-category-special','Admin\PostController@addToCategorySpecial')->name('Post.add.category.special');
        });

        // HTML Block
        Route::group(['prefix' => 'blocks'], function () {
            Route::get('/', 'Admin\BlockController@index')->name('Block.index');
            Route::get('/searchData', 'Admin\BlockController@searchData')->name('Block.searchData');
            Route::get('/{id}/show', 'Admin\BlockController@show')->name('Block.show');
            Route::get('/create', 'Admin\BlockController@create')->name('Block.create');
            Route::post('/', 'Admin\BlockController@store')->name('Block.store');
            Route::post('/{id}/update', 'Admin\BlockController@update')->name('Block.update');
            Route::get('/{id}/edit', 'Admin\BlockController@edit')->name('Block.edit');
            Route::get('/{id}/delete', 'Admin\BlockController@delete')->name('Block.delete');
            Route::get('/exportExcel','Admin\BlockController@exportExcel')->name('Block.exportExcel');
        });

        // Customer Review
        Route::group(['prefix' => 'reviews'], function () {
            Route::get('/', 'Admin\ReviewController@index')->name('Review.index');
            Route::get('/searchData', 'Admin\ReviewController@searchData')->name('Review.searchData');
            Route::get('/{id}/show', 'Admin\ReviewController@show')->name('Review.show');
            Route::get('/create', 'Admin\ReviewController@create')->name('Review.create');
            Route::post('/', 'Admin\ReviewController@store')->name('Review.store');
            Route::post('/{id}/update', 'Admin\ReviewController@update')->name('Review.update');
            Route::get('/{id}/delete', 'Admin\ReviewController@delete')->name('Review.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ReviewController@getDataForEdit');
            Route::get('/exportExcel','Admin\ReviewController@exportExcel')->name('Review.exportExcel');
        });

        // Founder
        Route::group(['prefix' => 'founders'], function () {
            Route::get('/', 'Admin\FounderController@index')->name('Founder.index');
            Route::get('/searchData', 'Admin\FounderController@searchData')->name('Founder.searchData');
            Route::get('/{id}/show', 'Admin\FounderController@show')->name('Founder.show');
            Route::get('/create', 'Admin\FounderController@create')->name('Founder.create');
            Route::post('/', 'Admin\FounderController@store')->name('Founder.store');
            Route::post('/{id}/update', 'Admin\FounderController@update')->name('Founder.update');
            Route::get('/{id}/delete', 'Admin\FounderController@delete')->name('Founder.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\FounderController@getDataForEdit');
        });

        // Manufacturers (hãng sản xuất)
        Route::group(['prefix' => 'manufacturers'], function () {
            Route::get('/', 'Admin\ManufacturerController@index')->name('manufacturers.index');
            Route::get('/searchData', 'Admin\ManufacturerController@searchData')->name('manufacturers.searchData');
            Route::get('/{id}/show', 'Admin\ManufacturerController@show')->name('Review.show');
            Route::get('/create', 'Admin\ManufacturerController@create')->name('manufacturers.create');
            Route::post('/', 'Admin\ManufacturerController@store')->name('manufacturers.store');
            Route::post('/{id}/update', 'Admin\ManufacturerController@update')->name('manufacturers.update');
            Route::get('/{id}/delete', 'Admin\ManufacturerController@delete')->name('manufacturers.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ManufacturerController@getDataForEdit');
            Route::get('/exportExcel','Admin\ManufacturerController@exportExcel')->name('manufacturers.exportExcel');

            Route::get('/act-delete', 'Admin\ManufacturerController@actDelete')->name('manufacturers.delete.multi');
            Route::get('/check-act-delete', 'Admin\ManufacturerController@checkActDelete')->name('manufacturers.check.delete.multi');
        });

        // Origins (xuất xứ)
        Route::group(['prefix' => 'origins'], function () {
            Route::get('/', 'Admin\OriginController@index')->name('origins.index');
            Route::get('/searchData', 'Admin\OriginController@searchData')->name('origins.searchData');
            Route::get('/{id}/show', 'Admin\OriginController@show')->name('origins.show');
            Route::get('/create', 'Admin\OriginController@create')->name('origins.create');
            Route::post('/', 'Admin\OriginController@store')->name('origins.store');
            Route::post('/{id}/update', 'Admin\OriginController@update')->name('origins.update');
            Route::get('/{id}/delete', 'Admin\OriginController@delete')->name('origins.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\OriginController@getDataForEdit');
            Route::get('/exportExcel','Admin\OriginController@exportExcel')->name('origins.exportExcel');
        });

        // Danh mục dự án
        Route::group(['prefix' => 'project-categories'], function() {
            Route::get('/create', 'Admin\ProjectCategoryController@create')->name('ProjectCategory.create');
            Route::post('/', 'Admin\ProjectCategoryController@store')->name('ProjectCategory.store');
            Route::post('/{id}/update', 'Admin\ProjectCategoryController@update')->name('ProjectCategory.update');
            Route::get('/{id}/edit', 'Admin\ProjectCategoryController@edit')->name('ProjectCategory.edit');
            Route::get('/{id}/getDataForEdit', 'Admin\ProjectCategoryController@getDataForEdit');
            Route::get('/{id}/delete', 'Admin\ProjectCategoryController@delete')->name('ProjectCategory.delete');
            Route::get('/', 'Admin\ProjectCategoryController@index')->name('ProjectCategory.index');
            Route::get('/searchData', 'Admin\ProjectCategoryController@searchData')->name('ProjectCategory.searchData');
            Route::post('/nested-sort', 'Admin\ProjectCategoryController@nestedSort')->name('ProjectCategory.nestedSort');
            Route::post('/add-home-page', 'Admin\ProjectCategoryController@addToHomepage')->name('ProjectCategory.add.home.page');
        });

        // Dự án
        Route::group(['prefix' => 'projects'], function () {
            Route::get('/', 'Admin\ProjectController@index')->name('Project.index');
            Route::get('/searchData', 'Admin\ProjectController@searchData')->name('Project.searchData');
            Route::get('/{id}/show', 'Admin\ProjectController@show')->name('Project.show');
            Route::get('/{id}/getData', 'Admin\ProjectController@getData')->name('Project.getData');
            Route::get('/create', 'Admin\ProjectController@create')->name('Project.create')->middleware('checkPermission:Thêm bài viết');
            Route::post('/', 'Admin\ProjectController@store')->name('Project.store')->middleware('checkPermission:Thêm bài viết');
            Route::post('/{id}/update', 'Admin\ProjectController@update')->name('Project.update')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/edit', 'Admin\ProjectController@edit')->name('Project.edit')->middleware('checkPermission:Sửa bài viết');
            Route::get('/{id}/delete', 'Admin\ProjectController@delete')->name('Project.delete')->middleware('checkPermission:Xóa bài viết');
            Route::get('/exportExcel','Admin\ProjectController@exportExcel')->name('Project.exportExcel');
            Route::post('/add-to-category-special','Admin\ProjectController@addToCategorySpecial')->name('Project.add.category.special');
        });

        Route::group(['prefix' => 'recruitment'], function () {
            Route::get('/', 'Admin\RecruitmentController@index')->name('recruitments.index');
            Route::get('/searchData', 'Admin\RecruitmentController@searchData')->name('recruitments.searchData');
            Route::get('/{id}/show', 'Admin\RecruitmentController@show')->name('recruitments.show');
            Route::get('/{id}/getData', 'Admin\RecruitmentController@getData')->name('recruitments.getData');
            Route::get('/create', 'Admin\RecruitmentController@create')->name('recruitments.create');
            Route::post('/', 'Admin\RecruitmentController@store')->name('recruitments.store');
            Route::post('/{id}/update', 'Admin\RecruitmentController@update')->name('recruitments.update');
            Route::get('/{id}/edit', 'Admin\RecruitmentController@edit')->name('recruitments.edit');
            Route::get('/{id}/delete', 'Admin\RecruitmentController@delete')->name('recruitments.delete');
            Route::get('/exportExcel','Admin\RecruitmentController@exportExcel')->name('recruitments.exportExcel');
            Route::post('/add-to-category-special','Admin\RecruitmentController@addToCategorySpecial')->name('recruitments.add.category.special');
        });

        // đối tác
        Route::group(['prefix' => 'partners'], function () {
            Route::get('/', 'Admin\PartnerController@index')->name('partners.index');
            Route::get('/searchData', 'Admin\PartnerController@searchData')->name('partners.searchData');
            Route::get('/{id}/show', 'Admin\PartnerController@show')->name('partners.show');
            Route::get('/create', 'Admin\PartnerController@create')->name('partners.create');
            Route::post('/', 'Admin\PartnerController@store')->name('partners.store');
            Route::post('/{id}/update', 'Admin\PartnerController@update')->name('partners.update');
            Route::get('/{id}/delete', 'Admin\PartnerController@delete')->name('partners.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\PartnerController@getDataForEdit');
            Route::get('/exportExcel','Admin\PartnerController@exportExcel')->name('partners.exportExcel');
        });

        // cấu hình số liệu thống kê
        Route::group(['prefix' => 'configStatistic'], function () {
            Route::get('/', 'Admin\ConfigStatisticController@index')->name('configStatistic.index');
            Route::get('/searchData', 'Admin\ConfigStatisticController@searchData')->name('configStatistic.searchData');
            Route::get('/{id}/show', 'Admin\ConfigStatisticController@show')->name('configStatistic.show');
            Route::get('/create', 'Admin\ConfigStatisticController@create')->name('configStatistic.create');
            Route::post('/', 'Admin\ConfigStatisticController@store')->name('configStatistic.store');
            Route::post('/{id}/update', 'Admin\ConfigStatisticController@update')->name('configStatistic.update');
            Route::get('/{id}/delete', 'Admin\ConfigStatisticController@delete')->name('configStatistic.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ConfigStatisticController@getDataForEdit');
            Route::get('/exportExcel','Admin\ConfigStatisticController@exportExcel')->name('configStatistic.exportExcel');
        });

        // nhân viên tư vấn
        Route::group(['prefix' => 'consultants'], function () {
            Route::get('/', 'Admin\ConsultantController@index')->name('consultants.index');
            Route::get('/searchData', 'Admin\ConsultantController@searchData')->name('consultants.searchData');
            Route::get('/{id}/show', 'Admin\ConsultantController@show')->name('consultants.show');
            Route::get('/create', 'Admin\ConsultantController@create')->name('consultants.create');
            Route::post('/', 'Admin\ConsultantController@store')->name('consultants.store');
            Route::post('/{id}/update', 'Admin\ConsultantController@update')->name('consultants.update');
            Route::get('/{id}/delete', 'Admin\ConsultantController@delete')->name('consultants.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\ConsultantController@getDataForEdit');
        });

        // Danh mục đặc biệt
        Route::group(['prefix' => 'category-special'], function () {
            Route::get('/', 'Admin\CategorySpecialController@index')->name('category_special.index');
            Route::get('/searchData', 'Admin\CategorySpecialController@searchData')->name('category_special.searchData');
            Route::get('/{id}/show', 'Admin\CategorySpecialController@show')->name('category_special.show');
            Route::get('/create', 'Admin\CategorySpecialController@create')->name('category_special.create');
            Route::post('/', 'Admin\CategorySpecialController@store')->name('category_special.store');
            Route::post('/{id}/update', 'Admin\CategorySpecialController@update')->name('category_special.update');
            Route::get('/{id}/delete', 'Admin\CategorySpecialController@delete')->name('category_special.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\CategorySpecialController@getDataForEdit');
            Route::get('/exportExcel','Admin\CategorySpecialController@exportExcel')->name('category_special.exportExcel');
        });

        // Danh mục vouchers
        Route::group(['prefix' => 'vouchers'], function () {
            Route::get('/', 'Admin\VoucherController@index')->name('vouchers.index');
            Route::get('/searchData', 'Admin\VoucherController@searchData')->name('vouchers.searchData');
            Route::get('/{id}/show', 'Admin\VoucherController@show')->name('vouchers.show');
            Route::get('/create', 'Admin\VoucherController@create')->name('vouchers.create');
            Route::post('/', 'Admin\VoucherController@store')->name('vouchers.store');
            Route::post('/{id}/update', 'Admin\VoucherController@update')->name('vouchers.update');
            Route::get('/{id}/delete', 'Admin\VoucherController@delete')->name('vouchers.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\VoucherController@getDataForEdit');
        });

        // Attributes (thuộc tính sản phẩm)
        Route::group(['prefix' => 'attributes'], function () {
            Route::get('/', 'Admin\AttributeController@index')->name('attributes.index');
            Route::get('/searchData', 'Admin\AttributeController@searchData')->name('attributes.searchData');
            Route::get('/{id}/show', 'Admin\AttributeController@show')->name('attributes.show');
            Route::get('/create', 'Admin\AttributeController@create')->name('attributes.create');
            Route::post('/', 'Admin\AttributeController@store')->name('attributes.store');
            Route::post('/{id}/update', 'Admin\AttributeController@update')->name('attributes.update');
            Route::get('/{id}/delete', 'Admin\AttributeController@delete')->name('attributes.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\AttributeController@getDataForEdit');
            Route::get('/exportExcel','Admin\AttributeController@exportExcel')->name('attributes.exportExcel');
        });

        // ql đơn hàng
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', 'Admin\OrderController@index')->name('orders.index');
            Route::get('/searchData', 'Admin\OrderController@searchData')->name('orders.searchData');
            Route::get('/{id}/show', 'Admin\OrderController@show')->name('orders.show');
            Route::post('/update-status','Admin\OrderController@updateStatus')->name('orders.update.status');
            Route::get('/exportList','Admin\OrderController@exportList')->name('orders.exportList');
            Route::post('/importExcel', 'Admin\OrderController@importExcel')->name('orders.importExcel');
        });

        // banner trang chủ
        Route::group(['prefix' => 'banner'], function () {
            Route::get('/', 'Admin\BannerController@index')->name('banners.index');
            Route::get('/searchData', 'Admin\BannerController@searchData')->name('banners.searchData');
            Route::get('/{id}/show', 'Admin\BannerController@show')->name('banners.show');
            Route::get('/create', 'Admin\BannerController@create')->name('banners.create');
            Route::post('/', 'Admin\BannerController@store')->name('banners.store');
            Route::post('/{id}/update', 'Admin\BannerController@update')->name('banners.update');
            Route::get('/{id}/delete', 'Admin\BannerController@delete')->name('banners.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\BannerController@getDataForEdit')->name('banners.getDataForEdit');
        });

        // tags
        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'Admin\TagController@index')->name('tags.index');
            Route::get('/searchData', 'Admin\TagController@searchData')->name('tags.searchData');
            Route::post('', 'Admin\TagController@store')->name('tags.store');
            Route::get('/{id}/getDataForEdit/', 'Admin\TagController@getDataForEdit')->name('tags.edit');
            Route::put('/{id}/update', 'Admin\TagController@update')->name('tags.update');
            Route::get('/{id}/delete', 'Admin\TagController@delete')->name('tags.delete');
        });

        // quản lý cửa hàng
        Route::group(['prefix' => 'stores'], function () {
            Route::get('/', 'Admin\StoreController@index')->name('stores.index');
            Route::get('/searchData', 'Admin\StoreController@searchData')->name('stores.searchData');
            Route::get('/{id}/show', 'Admin\StoreController@show')->name('stores.show');
            Route::get('/{id}/edit', 'Admin\StoreController@edit')->name('stores.edit');
            Route::get('/create', 'Admin\StoreController@create')->name('stores.create');
            Route::post('/', 'Admin\StoreController@store')->name('stores.store');
            Route::post('/{id}/update', 'Admin\StoreController@update')->name('stores.update');
            Route::get('/{id}/delete', 'Admin\StoreController@delete')->name('stores.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\StoreController@getDataForEdit');
        });

        // quản lý chính sách
        Route::group(['prefix' => 'policies'], function () {
            Route::get('/', 'Admin\PolicyController@index')->name('policies.index');
            Route::get('/searchData', 'Admin\PolicyController@searchData')->name('policies.searchData');
            Route::get('/{id}/show', 'Admin\PolicyController@show')->name('policies.show');
            Route::get('/{id}/edit', 'Admin\PolicyController@edit')->name('policies.edit');
            Route::get('/create', 'Admin\PolicyController@create')->name('policies.create');
            Route::post('/', 'Admin\PolicyController@store')->name('policies.store');
            Route::post('/{id}/update', 'Admin\PolicyController@update')->name('policies.update');
            Route::get('/{id}/delete', 'Admin\PolicyController@delete')->name('policies.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\PolicyController@getDataForEdit');
        });

        // Service Types
        Route::group(['prefix' => 'service-types'], function () {
            Route::get('/', 'Admin\ServiceTypeController@index')->name('service_types.index');
            Route::get('/searchData', 'Admin\ServiceTypeController@searchData')->name('service_types.searchData');
            Route::post('/', 'Admin\ServiceTypeController@store')->name('service_types.store');
            Route::get('/{id}/edit', 'Admin\ServiceTypeController@edit')->name('service_types.edit');
            Route::post('/{id}/update', 'Admin\ServiceTypeController@update')->name('service_types.update');
            Route::get('/{id}/delete', 'Admin\ServiceTypeController@delete')->name('service_types.delete');
        });

        // service
        Route::group(['prefix' => 'services'], function () {
            Route::get('/', 'Admin\ServiceController@index')->name('services.index');
            Route::get('/create', 'Admin\ServiceController@create')->name('services.create');
            Route::get('/searchData', 'Admin\ServiceController@searchData')->name('services.searchData');
            Route::post('/', 'Admin\ServiceController@store')->name('services.store');
            Route::get('/{id}/edit', 'Admin\ServiceController@edit')->name('services.edit');
            Route::post('/{id}/update', 'Admin\ServiceController@update')->name('services.update');
            Route::get('/{id}/delete', 'Admin\ServiceController@delete')->name('services.delete');
        });

        // gallery
        Route::group(['prefix' => 'galleries'], function () {
            Route::get('/', 'Admin\GalleryController@index')->name('galleries.index');
            Route::get('/searchData', 'Admin\GalleryController@searchData')->name('galleries.searchData');
            Route::get('/create', 'Admin\GalleryController@create')->name('galleries.create');
            Route::post('/', 'Admin\GalleryController@store')->name('galleries.store');
            Route::post('/{id}/update', 'Admin\GalleryController@update')->name('galleries.update');
            Route::get('/{id}/delete', 'Admin\GalleryController@delete')->name('galleries.delete');
            Route::get('/{id}/getDataForEdit', 'Admin\GalleryController@getDataForEdit');
        });

        Route::group(['prefix' => 'common'], function () {
            Route::get('/dashboard', 'Common\DashboardController@index')->name('dash');

            Route::get('/{id}/checkprint','G7\BillController@checkPrint');

            // Role Uptek
            Route::group(['prefix' => 'roles', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::QUAN_TRI_VIEN], function () {
                Route::get('/create', 'Common\RoleController@create')->name('Role.create')->middleware('checkPermission:Quản lý chức vụ');
                Route::post('/', 'Common\RoleController@store')->name('Role.store')->middleware('checkPermission:Quản lý chức vụ');
                Route::get('/', 'Common\RoleController@index')->name('Role.index');
                Route::get('/{id}/edit', 'Common\RoleController@edit')->name('Role.edit')->middleware('checkPermission:Quản lý chức vụ');
                Route::get('/{id}/delete', 'Common\RoleController@delete')->name('Role.delete')->middleware('checkPermission:Quản lý chức vụ');
                Route::post('/{id}/update', 'Common\RoleController@update')->name('Role.update')->middleware('checkPermission:Quản lý chức vụ');
                Route::get('/searchData', 'Common\RoleController@searchData')->name('Role.searchData');
            });

            Route::group(['prefix' => 'users', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::QUAN_TRI_VIEN], function () {
                Route::get('/create', 'Common\UserController@create')->name('User.create');
                Route::post('/', 'Common\UserController@store')->name('User.store');
                Route::get('/', 'Common\UserController@index')->name('User.index');
                Route::get('/{id}/edit', 'Common\UserController@edit')->name('User.edit');
                Route::get('/{id}/delete', 'Common\UserController@delete')->name('User.delete');
                Route::post('/{id}/update', 'Common\UserController@update')->name('User.update');
                Route::get('/searchData', 'Common\UserController@searchData')->name('User.searchData');
                Route::get('/exportExcel','Common\UserController@exportExcel')->name('User.exportExcel');
                Route::get('/exportPdf','Common\UserController@exportPDF')->name('User.exportPDF');
            });


            Route::group(['prefix' => 'notifications'], function () {
                Route::get('/', 'Common\NotificationsController@index')->name('Notification.index');
                Route::get('/{id}/read', 'Common\NotificationsController@read')->name('Notification.read');
                Route::get('/searchData', 'Common\NotificationsController@searchData')->name('Notification.searchData');
            });

            Route::group(['prefix' => 'reports', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::QUAN_TRI_VIEN], function () {
                Route::get('/promoReport', 'Common\ReportController@promoReport')->name('Report.promoReport')->middleware('checkPermission:Xem báo cáo khuyến mãi chiết khấu');
                Route::get('/promoReportSearchData', 'Common\ReportController@promoReportSearchData')->name('Report.promoReportSearchData');
                Route::get('/promoReportPrint', 'Common\ReportController@promoReportPrint')->name('Report.promoReportPrint');
                Route::get('/promoProductReport', 'Common\ReportController@promoProductReport')->name('Report.promoProductReport')->middleware('checkPermission:Xem báo cáo khuyến mãi theo hàng hóa');
                Route::get('/promoProductReportSearchData', 'Common\ReportController@promoProductReportSearchData')->name('Report.promoProductReportSearchData');
                Route::get('/promoProductReportPrint', 'Common\ReportController@promoProductReportPrint')->name('Report.promoProductReportPrint');
                Route::get('/customerSaleReport', 'Common\ReportController@customerSaleReport')->name('Report.customerSaleReport')->middleware('checkPermission:Xem báo cáo kinh doanh theo khách hàng');;
                Route::get('/customerSaleReportSearchData', 'Common\ReportController@customerSaleReportSearchData')->name('Report.customerSaleReportSearchData');
                Route::get('/customerSaleReportPrint', 'Common\ReportController@customerSaleReportPrint')->name('Report.customerSaleReportPrint');

                Route::get('/revenueReport', 'Common\ReportController@revenueReport')->name('Report.revenueReport');
                Route::get('/revenueReportSearchData', 'Common\ReportController@revenueReportSearchData')->name('Report.revenueReportSearchData');
                Route::post('/revenueReportSettlementUser', 'Common\ReportController@revenueReportSettlementUser')->name('Report.revenueReportSettlementUser');
                Route::get('/revenueReportPrint', 'Common\ReportController@revenueReportPrint')->name('Report.revenueReportPrint');
            });

            // Danh mục đơn vị
            Route::group(['prefix' => 'units', 'middleware' => 'checkType:'.User::QUAN_TRI_VIEN], function () {
                Route::get('/create', 'Common\UnitController@create')->name('Unit.create')->middleware('checkPermission:Thêm mới đơn vị');
                Route::post('/{id}/update', 'Common\UnitController@update')->name('Unit.update')->middleware('checkPermission:Cập nhật đơn vị');
                Route::post('/', 'Common\UnitController@store')->name('Unit.store')->middleware('checkPermission:Thêm mới đơn vị');
                Route::get('/', 'Common\UnitController@index')->name('Unit.index');
                Route::get('/{id}/edit', 'Common\UnitController@edit')->name('Unit.edit')->middleware('checkPermission:Cập nhật đơn vị tính');
                Route::get('/{id}/delete', 'Common\UnitController@delete')->name('Unit.delete')->middleware('checkPermission:Xóa đơn vị tính');
                Route::get('/searchData', 'Common\UnitController@searchData')->name('Unit.searchData');
                Route::get('/exportExcel','Common\UnitController@exportExcel')->name('Unit.exportExcel');
            });

            // Khách hàng
            Route::group(['prefix' => 'customers'], function () {
                Route::get('/create', 'Common\CustomerController@create')->name('Customer.create')->middleware('checkPermission:Thêm mới khách hàng');
                Route::post('/', 'Common\CustomerController@store')->name('Customer.store')->middleware('checkPermission:Thêm mới khách hàng');
                Route::get('/', 'Common\CustomerController@index')->name('Customer.index');
                Route::get('/{id}/edit', 'Common\CustomerController@edit')->name('Customer.edit')->middleware('checkPermission:Cập nhật khách hàng');
                Route::get('/{id}/delete', 'Common\CustomerController@delete')->name('Customer.delete')->middleware('checkPermission:Xóa khách hàng');
                Route::post('/{id}/update', 'Common\CustomerController@update')->name('Customer.update')->middleware('checkPermission:Cập nhật khách hàng');
                Route::get('/{id}/getDataForShow', 'Common\CustomerController@getDataForShow')->name('Customer.getDataForShow');
                Route::get('/{id}/getPoints', 'Common\CustomerController@getPoints')->name('Customer.getPoints');
                Route::get('/searchData', 'Common\CustomerController@searchData')->name('Customer.searchData');
                Route::get('/exportExcel','Common\CustomerController@exportExcel')->name('Customer.exportExcel');
                Route::get('/exportPDF','Common\CustomerController@exportPDF')->name('Customer.exportPDF');
            });

        });

        Route::group(['prefix' => 'uptek', 'middleware' => 'checkType:'.User::QUAN_TRI_VIEN.','.User::SUPER_ADMIN], function () {
            // Service
            Route::group(['prefix' => 'services'], function () {
                Route::get('/create', 'Uptek\ServiceController@create')->name('Service.create')->middleware('checkPermission:Thêm dịch vụ');
                Route::post('/', 'Uptek\ServiceController@store')->name('Service.store')->middleware('checkPermission:Thêm dịch vụ');
                Route::get('/{id}/edit', 'Uptek\ServiceController@edit')->name('Service.edit')->middleware('checkPermission:Sửa dịch vụ');
                Route::post('/{id}/update', 'Uptek\ServiceController@update')->name('Service.update')->middleware('checkPermission:Sửa dịch vụ');
                Route::get('/{id}/delete', 'Uptek\ServiceController@delete')->name('Service.delete')->middleware('checkPermission:Xóa dịch vụ');
            });

            // Cấu hình tích điểm
            Route::group(['prefix' => 'accumulate-point', 'middleware' => 'checkPermission:Cấu hình tích điểm'], function () {
                Route::get('config', 'Uptek\AccumulatePointController@edit')->name('AccumulatePoint.edit');
                Route::post('/update', 'Uptek\AccumulatePointController@update')->name('AccumulatePoint.update');
            });

            //  Cấu hình level khách hàng
            Route::group(['prefix' => 'customer-levels', 'middleware' => 'checkPermission:Cấu hình level khách hàng'], function () {
                Route::get('/', 'Uptek\CustomerLevelController@index')->name('CustomerLevel.index');
                Route::get('/create', 'Uptek\CustomerLevelController@create')->name('CustomerLevel.create');
                Route::post('/{id}/update', 'Uptek\CustomerLevelController@update')->name('CustomerLevel.update');
                Route::post('/', 'Uptek\CustomerLevelController@store')->name('CustomerLevel.store');
                Route::get('/{id}/getDataForEdit', 'Uptek\CustomerLevelController@getDataForEdit');
                Route::get('/{id}/delete', 'Uptek\CustomerLevelController@delete')->name('CustomerLevel.delete');
                Route::get('/exportExcel','Uptek\CustomerLevelController@exportExcel')->name('CustomerLevel.exportExcel');

            });


            Route::group(['prefix' => 'print-templates', 'middleware' => 'checkPermission:Cấu hình mẫu in'], function () {
                Route::post('/{id}/update', 'Uptek\PrintTemplateController@update')->name('PrintTemplate.update');
                Route::get('/', 'Uptek\PrintTemplateController@index')->name('PrintTemplate.index');
                Route::get('/{id}/edit', 'Uptek\PrintTemplateController@edit')->name('PrintTemplate.edit');
                Route::get('/searchData', 'Uptek\PrintTemplateController@searchData')->name('PrintTemplate.searchData');
            });
            // Danh mục tài sản cố định
            Route::group(['prefix' => 'fixed-assets'], function () {
                Route::get('/create', 'Uptek\FixedAssetController@create')->name('FixedAsset.create')->middleware('checkPermission:Thêm tài sản cố định');
                Route::post('/', 'Uptek\FixedAssetController@store')->name('FixedAsset.store')->middleware('checkPermission:Thêm tài sản cố định');
                Route::post('/{id}/update', 'Uptek\FixedAssetController@update')->name('FixedAsset.update')->middleware('checkPermission:Sửa tài sản cố định');
                Route::get('/{id}/edit', 'Uptek\FixedAssetController@edit')->name('FixedAsset.edit')->middleware('checkPermission:Sửa tài sản cố định');
                Route::get('/{id}/delete', 'Uptek\FixedAssetController@delete')->name('FixedAsset.delete')->middleware('checkPermission:Xóa tài sản cố định');
                Route::get('/', 'Uptek\FixedAssetController@index')->name('FixedAsset.index');
                Route::get('/exportExcel','Uptek\FixedAssetController@exportExcel')->name('FixedAsset.exportExcel');
            });

        });

        Route::group(['prefix' => 'g7'], function () {
            // Hồ sơ nhân viên G7
            Route::group(['prefix' => 'g7-employees'], function () {
                Route::get('/create', 'G7\G7EmployeeController@create')->name('G7Employee.create')->middleware('checkPermission:Thêm hồ sơ nhân viên');
                Route::post('/{id}/update', 'G7\G7EmployeeController@update')->name('G7Employee.update')->middleware('checkPermission:Sửa hồ sơ nhân viên');
                Route::post('/', 'G7\G7EmployeeController@store')->name('G7Employee.store')->middleware('checkPermission:Thêm hồ sơ nhân viên');
                Route::get('/', 'G7\G7EmployeeController@index')->name('G7Employee.index');
                Route::get('/{id}/edit', 'G7\G7EmployeeController@edit')->name('G7Employee.edit')->middleware('checkPermission:Sửa hồ sơ nhân viên');
                Route::get('/{id}/delete', 'G7\G7EmployeeController@delete')->name('G7Employee.delete')->middleware('checkPermission:Xóa hồ sơ nhân viên');
                Route::get('/exportExcel','G7\G7EmployeeController@exportExcel')->name('G7Employee.exportExcel');
                Route::get('/searchData', 'G7\G7EmployeeController@searchData')->name('G7Employee.searchData');
                Route::get('/{id}/getData', 'G7\G7EmployeeController@getData')->name('G7Employee.getData');
            });
            // Tài khoản nhân viên G7
            Route::group(['prefix' => 'users'], function () {
                Route::get('/create', 'G7\G7UserController@create')->name('G7User.create')->middleware('checkPermission:Thêm mới tài khoản nhân viên G7');
                Route::post('/', 'G7\G7UserController@store')->name('G7User.store')->middleware('checkPermission:Thêm mới tài khoản nhân viên G7');
                Route::get('/', 'G7\G7UserController@index')->name('G7User.index');
                Route::get('/{id}/edit', 'G7\G7UserController@edit')->name('G7User.edit')->middleware('checkPermission:Cập nhật tài khoản nhân viên G7');
                Route::get('/{id}/delete', 'G7\G7UserController@delete')->name('G7User.delete')->middleware('checkPermission:Xóa tài khoản nhân viên G7');
                Route::post('/{id}/update', 'G7\G7UserController@update')->name('G7User.update')->middleware('checkPermission:Cập nhật tài khoản nhân viên G7');
                Route::get('/searchData', 'G7\G7UserController@searchData')->name('G7User.searchData');
            });
            // Đặt lịch
            Route::group(['prefix' => 'bookings'], function () {
                Route::get('/', 'Uptek\BookingController@index')->name('G7Booking.index');
            });
        // Nhắc lịch
            Route::group(['prefix' => 'calendar-reminders'], function () {
                Route::get('/create', 'G7\CalendarReminderController@create')->name('CalendarReminder.create')->middleware('checkPermission:Thêm nhắc lịch');
                Route::post('/{id}/update', 'G7\CalendarReminderController@update')->name('CalendarReminder.update')->middleware('checkPermission:Sửa nhắc lịch');
                Route::post('/', 'G7\CalendarReminderController@store')->name('CalendarReminder.store')->middleware('checkPermission:Thêm nhắc lịch');
                Route::get('/', 'G7\CalendarReminderController@index')->name('CalendarReminder.index');
                Route::get('/{id}/delete', 'G7\CalendarReminderController@delete')->name('CalendarReminder.delete')->middleware('checkPermission:Xóa nhắc lịch');
                Route::get('/searchData', 'G7\CalendarReminderController@searchData')->name('CalendarReminder.searchData');
                Route::get('/{id}/getDataForEdit', 'G7\CalendarReminderController@getDataForEdit')->name('CalendarReminder.getDataForEdit');
                Route::get('/{id}/conFirmed', 'G7\CalendarReminderController@conFirmed')->name('CalendarReminder.conFirmed');
                Route::get('/exportExcel','G7\CalendarReminderController@exportExcel')->name('CalendarReminder.exportExcel');
                Route::get('/exportPDF','G7\CalendarReminderController@exportPDF')->name('CalendarReminder.exportPDF');
            });
            Route::group(['prefix' => 'products'], function () {
                // Route::get('/create', 'G7\G7ProductController@create')->name('G7Product.create');
                // Route::post('/{id}/update', 'G7\G7ProductController@update')->name('G7Product.update');
                // Route::post('/', 'G7\G7ProductController@store')->name('G7Product.store');
                // Route::get('/', 'G7\G7ProductController@index')->name('G7Product.index');
                Route::get('/editPrice', 'G7\G7ProductController@editPrice')->name('G7Product.editPrice')->middleware('checkPermission:Cập nhật giá hàng hóa');
                Route::post('/updatePrice', 'G7\G7ProductController@updatePrice')->name('G7Product.updatePrice')->middleware('checkPermission:Cập nhật giá hàng hóa');
                // Route::get('/{id}/edit', 'G7\G7ProductController@edit')->name('G7Product.edit');
                // Route::get('/{id}/delete', 'G7\G7ProductController@delete')->name('G7Product.delete');
                // Route::get('/exportExcel','G7\G7ProductController@exportExcel')->name('G7Product.exportExcel');
                // Route::get('/searchData', 'G7\G7ProductController@searchData')->name('G7Product.searchData');
                // Route::get('/{id}/getData', 'G7\G7ProductController@getData')->name('G7Product.getData');
            });

            Route::group(['prefix' => 'g7_fixed_assets'], function () {
                Route::get('/create', 'G7\G7FixedAssetController@create')->name('G7FixedAsset.create')->middleware('checkPermission:Thêm tài sản cố định');
                Route::post('/{id}/update', 'G7\G7FixedAssetController@update')->name('G7FixedAsset.update')->middleware('checkPermission:Sửa tài sản cố định');
                Route::post('/', 'G7\G7FixedAssetController@store')->name('G7FixedAsset.store')->middleware('checkPermission:Thêm tài sản cố định');
                Route::get('/', 'G7\G7FixedAssetController@index')->name('G7FixedAsset.index');
                Route::get('/{id}/edit', 'G7\G7FixedAssetController@edit')->name('G7FixedAsset.edit')->middleware('checkPermission:Sửa tài sản cố định');
                Route::get('/{id}/delete', 'G7\G7FixedAssetController@delete')->name('G7FixedAsset.delete')->middleware('checkPermission:Xóa tài sản cố định');
                Route::get('/{id}/getData', 'G7\G7FixedAssetController@getData')->name('G7FixedAsset.getData');
                Route::get('/exportExcel','G7\G7FixedAssetController@exportExcel')->name('G7FixedAsset.exportExcel');
                Route::get('/searchData', 'G7\G7FixedAssetController@searchData')->name('G7FixedAsset.searchData');
                Route::get('/report', 'G7\G7FixedAssetController@report')->name('G7FixedAsset.report')->middleware('checkPermission:Xem báo cáo tài sản cố định');;
                Route::get('/searchReportData', 'G7\G7FixedAssetController@searchReportData')->name('G7FixedAsset.searchReportData');
            });

            Route::group(['prefix' => 'g7_fixed_asset_imports'], function () {
                Route::get('/create', 'G7\G7FixedAssetImportController@create')->name('G7FixedAssetImport.create')->middleware('checkPermission:Tạo phiếu nhập TSCD');
                Route::post('/{id}/update', 'G7\G7FixedAssetImportController@update')->name('G7FixedAssetImport.update')->middleware('checkPermission:Cập nhật phiếu nhập TSCD');
                Route::post('/', 'G7\G7FixedAssetImportController@store')->name('G7FixedAssetImport.store')->middleware('checkPermission:Tạo phiếu nhập TSCD');
                Route::get('/', 'G7\G7FixedAssetImportController@index')->name('G7FixedAssetImport.index');
                Route::get('/{id}/edit', 'G7\G7FixedAssetImportController@edit')->name('G7FixedAssetImport.edit')->middleware('checkPermission:Cập nhật phiếu nhập TSCD');
                Route::get('/{id}/getDataForShow', 'G7\G7FixedAssetImportController@getDataForShow')->name('G7FixedAssetImport.getDataForShow');
                Route::get('/{id}/delete', 'G7\G7FixedAssetImportController@delete')->name('G7FixedAssetImport.delete')->middleware('checkPermission:Hủy phiếu nhập TSCD');
                Route::get('/searchData', 'G7\G7FixedAssetImportController@searchData')->name('G7FixedAssetImport.searchData');
                Route::get('/{id}/print', 'G7\G7FixedAssetImportController@print')->name('G7FixedAssetImport.print');
            });

            Route::group(['prefix' => 'services'], function () {
                Route::get('/create', 'G7\G7ServiceController@create')->name('G7Service.create');
                Route::post('/{id}/update', 'G7\G7ServiceController@update')->name('G7Service.update');
                Route::post('/', 'G7\G7ServiceController@store')->name('G7Service.store');
                Route::get('/', 'G7\G7ServiceController@index')->name('G7Service.index');
                Route::get('/{id}/edit', 'G7\G7ServiceController@edit')->name('G7Service.edit');
                Route::get('/{id}/delete', 'G7\G7ServiceController@delete')->name('G7Service.delete');
                Route::get('/exportExcel','G7\G7ServiceController@exportExcel')->name('G7Service.exportExcel');
                Route::get('/searchData', 'G7\G7ServiceController@searchData')->name('G7Service.searchData');
                Route::get('/searchDataForBill', 'G7\G7ServiceController@searchDataForBill')->name('G7Service.searchDataForBill');
                Route::get('/getDataForBill', 'G7\G7ServiceController@getDataForBill')->name('G7Service.getDataForBill');
            });

            Route::group(['prefix' => 'fund-accounts'], function () {
                Route::get('/create', 'G7\FundAccountController@create')->name('FundAccount.create');
                Route::post('/{id}/update', 'G7\FundAccountController@update')->name('FundAccount.update');
                Route::post('/', 'G7\FundAccountController@store')->name('FundAccount.store');
                Route::get('/', 'G7\FundAccountController@index')->name('FundAccount.index');
                Route::get('/{id}/edit', 'G7\FundAccountController@edit')->name('FundAccount.edit');
                Route::get('/{id}/delete', 'G7\FundAccountController@delete')->name('FundAccount.delete');
                Route::get('/exportExcel','G7\FundAccountController@exportExcel')->name('FundAccount.exportExcel');
                Route::get('/searchData', 'G7\FundAccountController@searchData')->name('FundAccount.searchData');
            });

            Route::group(['prefix' => 'suppliers'], function () {
                Route::get('/create', 'G7\SupplierController@create')->name('Supplier.create')->middleware('checkPermission:Tạo nhà cung cấp');
                Route::post('/{id}/update', 'G7\SupplierController@update')->name('Supplier.update')->middleware('checkPermission:Cập nhật nhà cung cấp');
                Route::post('/', 'G7\SupplierController@store')->name('Supplier.store')->middleware('checkPermission:Tạo nhà cung cấp');
                Route::get('/', 'G7\SupplierController@index')->name('Supplier.index');
                Route::get('/{id}/edit', 'G7\SupplierController@edit')->name('Supplier.edit')->middleware('checkPermission:Cập nhật nhà cung cấp');
                Route::get('/{id}/delete', 'G7\SupplierController@delete')->name('Supplier.delete')->middleware('checkPermission:Xóa nhà cung cấp');
                Route::get('/exportExcel','G7\SupplierController@exportExcel')->name('Supplier.exportExcel');
                Route::get('/searchData', 'G7\SupplierController@searchData')->name('Supplier.searchData');
                Route::get('/{id}/getDataForEdit', 'G7\SupplierController@getDataForEdit')->name('Supplier.getDataForEdit');
                Route::get('/exportExcel','G7\SupplierController@exportExcel')->name('Supplier.exportExcel');
                Route::get('/exportPDF','G7\SupplierController@exportPDF')->name('Supplier.exportPDF');
            });

            Route::group(['prefix' => 'warehouse-imports'], function () {
                Route::get('/create', 'G7\WareHouseImportController@create')->name('WareHouseImport.create')->middleware('checkPermission:Tạo phiếu nhập kho');
                Route::post('/{id}/update', 'G7\WareHouseImportController@update')->name('WareHouseImport.update')->middleware('checkPermission:Cập nhật phiếu nhập kho');
                Route::post('/', 'G7\WareHouseImportController@store')->name('WareHouseImport.store')->middleware('checkPermission:Tạo phiếu nhập kho');
                Route::get('/', 'G7\WareHouseImportController@index')->name('WareHouseImport.index');
                Route::get('/{id}/edit', 'G7\WareHouseImportController@edit')->name('WareHouseImport.edit')->middleware('checkPermission:Cập nhật phiếu nhập kho');
                Route::get('/{id}/delete', 'G7\WareHouseImportController@delete')->name('WareHouseImport.delete')->middleware('checkPermission:Cập nhật phiếu nhập kho');
                Route::get('/exportExcel','G7\WareHouseImportController@exportExcel')->name('WareHouseImport.exportExcel');
                Route::get('/searchData', 'G7\WareHouseImportController@searchData')->name('WareHouseImport.searchData');
                Route::get('/{id}/payment', 'G7\WareHouseImportController@getDataForPay')->name('WareHouseImport.getDataForPay');
                Route::get('/{id}/show', 'G7\WareHouseImportController@getDataForShow')->name('WareHouseImport.getDataForShow');
                Route::get('/{id}/getDataBySupplier', 'G7\WareHouseImportController@getDataBySupplier')->name('WareHouseImport.getDataBySupplier');
                Route::get('/{id}/print', 'G7\WareHouseImportController@print')->name('WareHouseImport.print');
            });

            Route::group(['prefix' => 'funds'], function () {
                Route::group(['prefix' => 'payment-voucher-types'], function () {
                    Route::get('/create', 'G7\PaymentVoucherTypeController@create')->name('PaymentVoucherType.create');
                    Route::post('/{id}/update', 'G7\PaymentVoucherTypeController@update')->name('PaymentVoucherType.update');
                    Route::post('/', 'G7\PaymentVoucherTypeController@store')->name('PaymentVoucherType.store');
                    Route::get('/', 'G7\PaymentVoucherTypeController@index')->name('PaymentVoucherType.index');
                    Route::get('/{id}/edit', 'G7\PaymentVoucherTypeController@edit')->name('PaymentVoucherType.edit');
                    Route::get('/{id}/delete', 'G7\PaymentVoucherTypeController@delete')->name('PaymentVoucherType.delete');
                    Route::get('/exportExcel','G7\PaymentVoucherTypeController@exportExcel')->name('PaymentVoucherType.exportExcel');
                    Route::get('/searchData', 'G7\PaymentVoucherTypeController@searchData')->name('PaymentVoucherType.searchData');
                    Route::get('/{id}/show', 'G7\PaymentVoucherTypeController@getDataForShow')->name('PaymentVoucherType.getDataForShow');
                });

                Route::group(['prefix' => 'payment-vouchers'], function () {
                    Route::get('/create', 'G7\PaymentVoucherController@create')->name('PaymentVoucher.create')->middleware('checkPermission:Tạo phiếu chi');
                    Route::post('/', 'G7\PaymentVoucherController@store')->name('PaymentVoucher.store')->middleware('checkPermission:Tạo phiếu chi');
                    Route::get('/', 'G7\PaymentVoucherController@index')->name('PaymentVoucher.index');
                    Route::get('/{id}/delete', 'G7\PaymentVoucherController@delete')->name('PaymentVoucher.delete');
                    Route::get('/exportExcel','G7\PaymentVoucherController@exportExcel')->name('PaymentVoucher.exportExcel');
                    Route::get('/searchData', 'G7\PaymentVoucherController@searchData')->name('PaymentVoucher.searchData');
                    Route::get('/{id}/show', 'G7\PaymentVoucherController@getDataForShow')->name('PaymentVoucher.getDataForShow');
                    Route::get('{type_id}/getRecipient', 'G7\PaymentVoucherController@getRecipient')->name('PaymentVoucher.getRecipient');
                });

                Route::group(['prefix' => 'receipt-voucher-types'], function () {
                    Route::get('/create', 'G7\ReceiptVoucherTypeController@create')->name('ReceiptVoucherType.create');
                    Route::post('/{id}/update', 'G7\ReceiptVoucherTypeController@update')->name('ReceiptVoucherType.update');
                    Route::post('/', 'G7\ReceiptVoucherTypeController@store')->name('ReceiptVoucherType.store');
                    Route::get('/', 'G7\ReceiptVoucherTypeController@index')->name('ReceiptVoucherType.index');
                    Route::get('/{id}/edit', 'G7\ReceiptVoucherTypeController@edit')->name('ReceiptVoucherType.edit');
                    Route::get('/{id}/delete', 'G7\ReceiptVoucherTypeController@delete')->name('ReceiptVoucherType.delete');
                    Route::get('/exportExcel','G7\ReceiptVoucherTypeController@exportExcel')->name('ReceiptVoucherType.exportExcel');
                    Route::get('/searchData', 'G7\ReceiptVoucherTypeController@searchData')->name('ReceiptVoucherType.searchData');
                    Route::get('/{id}/getDataForShow', 'G7\ReceiptVoucherTypeController@getDataForShow')->name('ReceiptVoucherType.getDataForShow');

                });

                Route::group(['prefix' => 'receipt-vouchers'], function () {
                    Route::get('/create', 'G7\ReceiptVoucherController@create')->name('ReceiptVoucher.create')->middleware('checkPermission:Tạo phiếu thu');
                    Route::post('/', 'G7\ReceiptVoucherController@store')->name('ReceiptVoucher.store')->middleware('checkPermission:Tạo phiếu thu');
                    Route::get('/', 'G7\ReceiptVoucherController@index')->name('ReceiptVoucher.index');
                    Route::get('/{id}/delete', 'G7\ReceiptVoucherController@delete')->name('ReceiptVoucher.delete')->middleware('checkPermission:Hủy phiếu thu');
                    Route::get('/exportExcel','G7\ReceiptVoucherController@exportExcel')->name('ReceiptVoucher.exportExcel');
                    Route::get('/searchData', 'G7\ReceiptVoucherController@searchData')->name('ReceiptVoucher.searchData');
                    Route::get('/{id}/show', 'G7\ReceiptVoucherController@getDataForShow')->name('ReceiptVoucher.getDataForShow');
                    Route::get('{type_id}/get-payer', 'G7\ReceiptVoucherController@getPayer')->name('ReceiptVoucher.getPayer');
                    Route::get('/{id}/print', 'G7\ReceiptVoucherController@print')->name('ReceiptVoucher.print');
                });

                Route::group(['prefix' => 'fund-reports'], function () {
                    Route::get('/', 'G7\FundReportsController@index')->name('FundReports.index');
                });

                Route::group(['prefix' => 'business-reports'], function () {
                    Route::get('/', 'G7\BusinessReportsController@index')->name('BusinessReports.index');
                });
            });

            Route::group(['prefix' => 'bills'], function () {
                Route::get('/create', 'G7\BillController@create')->name('Bill.create')->middleware('checkPermission:Tạo hóa đơn bán hàng');
                Route::post('/{id}/update', 'G7\BillController@update')->name('Bill.update')->middleware('checkPermission:Cập nhật hóa đơn bán hàng');
                Route::post('/', 'G7\BillController@store')->name('Bill.store')->middleware('checkPermission:Tạo hóa đơn bán hàng');
                Route::get('/', 'G7\BillController@index')->name('Bill.index');
                Route::get('/searchData', 'G7\BillController@searchData')->name('Bill.searchData');
                Route::get('/{id}/edit', 'G7\BillController@edit')->name('Bill.edit')->middleware('checkPermission:Cập nhật hóa đơn bán hàng');
                Route::get('/{id}/show', 'G7\BillController@show')->name('Bill.show')->middleware('checkPermission:Xem hóa đơn bán');
                Route::get('/{id}/delete', 'G7\BillController@delete')->name('Bill.delete')->middleware('checkPermission:Hủy hóa đơn bán');
                Route::get('/{id}/getDataByCustomer', 'G7\BillController@getDataByCustomer')->name('Bill.getDataByCustomer');
                Route::get('/{id}/receipt', 'G7\BillController@getDataForReceipt')->name('Bill.getDataForReceipt');
                Route::get('/{id}/getDataForShow', 'G7\BillController@getDataForShow')->name('Bill.getDataForShow');
                Route::get('/{id}/getDataForWarehouseExport', 'G7\BillController@getDataForWarehouseExport')->name('Bill.getDataForWarehouseExport');
                Route::get('/getDataForFinalAdjust', 'G7\BillController@getDataForFinalAdjust')->name('Bill.getDataForFinalAdjust');
                Route::get('/{id}/print', 'G7\BillController@print')->name('Bill.print');
                Route::get('/{id}/getDataForReturn', 'G7\BillController@getDataForReturn')->name('Bill.getDataForReturn');
            });

            Route::group(['prefix' => 'bill_returns'], function () {
                Route::get('/create', 'G7\BillReturnController@create')->name('BillReturn.create');
                Route::post('/{id}/update', 'G7\BillReturnController@update')->name('BillReturn.update');
                Route::post('/', 'G7\BillReturnController@store')->name('BillReturn.store');
                Route::get('/', 'G7\BillReturnController@index')->name('BillReturn.index');
                Route::get('/searchData', 'G7\BillReturnController@searchData')->name('BillReturn.searchData');
                Route::get('/{id}/edit', 'G7\BillReturnController@edit')->name('BillReturn.edit');
                Route::get('/{id}/show', 'G7\BillReturnController@show')->name('BillReturn.show');
                Route::get('/{id}/delete', 'G7\BillReturnController@delete')->name('BillReturn.delete');
                Route::get('/{id}/getDataForShow', 'G7\BillReturnController@getDataForShow')->name('BillReturn.getDataForShow');
                Route::get('/{id}/print', 'G7\BillReturnController@print')->name('BillReturn.print');
            });

            Route::group(['prefix' => 'warehouse_exports'], function () {
                Route::get('/create', 'G7\WarehouseExportController@create')->name('WarehouseExport.create')->middleware('checkPermission:Tạo phiếu xuất kho');
                Route::post('/', 'G7\WarehouseExportController@store')->name('WarehouseExport.store')->middleware('checkPermission:Tạo phiếu xuất kho');
                Route::get('/', 'G7\WarehouseExportController@index')->name('WarehouseExport.index');
                Route::get('/searchData', 'G7\WarehouseExportController@searchData')->name('WarehouseExport.searchData');
                Route::get('/{id}/show', 'G7\WarehouseExportController@show')->name('WarehouseExport.show');
                Route::get('/{id}/getDataForShow', 'G7\WarehouseExportController@getDataForShow')->name('WarehouseExport.getDataForShow');
                Route::get('/{id}/print', 'G7\WarehouseExportController@print')->name('WarehouseExport.print')->middleware('checkPermission:In phiếu xuất kho');
            });

            Route::group(['prefix' => 'warehouse_reports'], function () {
                Route::get('/stockReport', 'G7\WarehouseReportController@stockReport')->name('WarehouseReport.stockReport')->middleware('checkPermission:Xem báo cáo kho');
                Route::get('/stockReportSearchData', 'G7\WarehouseReportController@stockReportSearchData')->name('WarehouseReport.stockReportSearchData');
                Route::get('/saleReport', 'G7\WarehouseReportController@saleReport')->name('WarehouseReport.saleReport')->middleware('checkPermission:Xem báo cáo bán hàng');
                Route::get('/saleReportSearchData', 'G7\WarehouseReportController@saleReportSearchData')->name('WarehouseReport.saleReportSearchData');
                Route::get('/fundReport', 'G7\WarehouseReportController@fundReport')->name('WarehouseReport.fundReport')->middleware('checkPermission:Xem báo cáo quỹ');
                Route::get('/fundReportSearchData', 'G7\WarehouseReportController@fundReportSearchData')->name('WarehouseReport.fundReportSearchData');
            });
        });

        Route::group(['prefix' => 'g7_group'], function () {

        });

        Route::group(['prefix' => 'g7_employee'], function () {

        });
    // Hãng xe
        Route::group(['prefix' => 'vehicle-manufacts', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::QUAN_TRI_VIEN], function () {
            Route::get('/create', 'Common\VehicleManufactController@create')->name('VehicleManufact.create')->middleware('checkPermission:Thêm mới hãng xe');
            Route::post('/', 'Common\VehicleManufactController@store')->name('VehicleManufact.store')->middleware('checkPermission:Thêm mới hãng xe');
            Route::get('/', 'Common\VehicleManufactController@index')->name('VehicleManufact.index');
            Route::get('/{id}/edit', 'Common\VehicleManufactController@edit')->name('VehicleManufact.edit')->middleware('checkPermission:Cập nhật hãng xe');
            Route::get('/{id}/delete', 'Common\VehicleManufactController@delete')->name('VehicleManufact.delete')->middleware('checkPermission:Xóa hãng xe');
            Route::post('/{id}/update', 'Common\VehicleManufactController@update')->name('VehicleManufact.update')->middleware('checkPermission:Cập nhật hãng xe');
            Route::get('/searchData', 'Common\VehicleManufactController@searchData')->name('VehicleManufact.searchData');
            Route::get('/exportExcel','Common\VehicleManufactController@exportExcel')->name('VehicleManufact.exportExcel');
        });
        // Loại xe
        Route::group(['prefix' => 'vehicle-types', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::QUAN_TRI_VIEN], function () {
            Route::get('/create', 'Common\VehicleTypeController@create')->name('VehicleType.create')->middleware('checkPermission:Thêm mới loại xe');
            Route::post('/', 'Common\VehicleTypeController@store')->name('VehicleType.store')->middleware('checkPermission:Thêm mới loại xe');
            Route::get('/', 'Common\VehicleTypeController@index')->name('VehicleType.index');
            Route::get('/{id}/edit', 'Common\VehicleTypeController@edit')->name('VehicleType.edit')->middleware('checkPermission:Cập nhật loại xe');
            Route::get('/{id}/delete', 'Common\VehicleTypeController@delete')->name('VehicleType.delete')->middleware('checkPermission:Xóa loại xe');
            Route::post('/{id}/update', 'Common\VehicleTypeController@update')->name('VehicleType.update')->middleware('checkPermission:Cập nhật loại xe');
            Route::get('/searchData', 'Common\VehicleTypeController@searchData')->name('VehicleType.searchData');
            Route::get('{id}/getDataForEdit', 'Common\VehicleTypeController@getDataForEdit')->name('VehicleType.getDataForEdit');
            Route::get('/exportExcel','Common\VehicleTypeController@exportExcel')->name('VehicleType.exportExcel');
            Route::get('/exportPDF','Common\VehicleTypeController@exportPDF')->name('VehicleType.exportPDF');
        });
        // Dòng xe
        Route::group(['prefix' => 'vehicle-categories', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::QUAN_TRI_VIEN], function () {
            Route::get('/create', 'Common\VehicleCategoryController@create')->name('VehicleCategory.create')->middleware('checkPermission:Thêm mới dòng xe');
            Route::post('/', 'Common\VehicleCategoryController@store')->name('VehicleCategory.store')->middleware('checkPermission:Thêm mới dòng xe');
            Route::get('/', 'Common\VehicleCategoryController@index')->name('VehicleCategory.index');
            Route::get('/{id}/edit', 'Common\VehicleCategoryController@edit')->name('VehicleCategory.edit')->middleware('checkPermission:Cập nhật dòng xe');
            Route::get('/{id}/delete', 'Common\VehicleCategoryController@delete')->name('VehicleCategory.delete')->middleware('checkPermission:Xóa dòng xe');
            Route::post('/{id}/update', 'Common\VehicleCategoryController@update')->name('VehicleCategory.update')->middleware('checkPermission:Cập nhật dòng xe');
            Route::get('/searchData', 'Common\VehicleCategoryController@searchData')->name('VehicleCategory.searchData');
            Route::get('/exportExcel','Common\VehicleCategoryController@exportExcel')->name('VehicleCategory.exportExcel');
            Route::get('/exportPDF','Common\VehicleCategoryController@exportPDF')->name('VehicleCategory.exportPDF');
        });

        // Nhóm khách hàng
        Route::group(['prefix' => 'customer-groups', 'middleware' => 'checkType:'.User::SUPER_ADMIN.','.User::QUAN_TRI_VIEN], function () {
            Route::get('/create', 'Common\CustomerGroupController@create')->name('CustomerGroup.create')->middleware('checkPermission:Thêm mới nhóm khách hàng');
            Route::post('/', 'Common\CustomerGroupController@store')->name('CustomerGroup.store')->middleware('checkPermission:Thêm mới nhóm khách hàng');
            Route::get('/', 'Common\CustomerGroupController@index')->name('CustomerGroup.index');
            Route::get('/{id}/edit', 'Common\CustomerGroupController@edit')->name('CustomerGroup.edit')->middleware('checkPermission:Cập nhật nhóm khách hàng');
            Route::get('/{id}/delete', 'Common\CustomerGroupController@delete')->name('CustomerGroup.delete')->middleware('checkPermission:Xóa nhóm khách hàng');
            Route::post('/{id}/update', 'Common\CustomerGroupController@update')->name('CustomerGroup.update')->middleware('checkPermission:Cập nhật nhóm khách hàng');
            Route::get('/searchData', 'Common\CustomerGroupController@searchData')->name('CustomerGroup.searchData');
            Route::get('/exportExcel','Common\CustomerGroupController@exportExcel')->name('CustomerGroup.exportExcel');
            Route::get('/exportPDF','Common\CustomerGroupController@exportPDF')->name('CustomerGroup.exportPDF');
        });

        // Route Tỉnh >> Huyện >> Xã
        Route::group(['prefix' => 'locations'], function () {
            Route::get('/{id}/districts', 'Common\LocationController@getDistricts')->name('getDistricts');
            Route::get('/{id}/wards', 'Common\LocationController@getWards')->name('getWards');
        });
    });

});

// route frontend 2
require(base_path().'/routes/front/web.php');
