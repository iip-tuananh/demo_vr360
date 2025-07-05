@extends('site.layouts.master')
@section('title')
    {{ $product->name }}
@endsection
@section('description')
    {!! strip_tags($product->intro) !!}
@endsection
@section('image')
    {{ $product->image ? $product->image->path : $product->galleries[0]->image->path }}
@endsection

@section('css')
@endsection

@section('content')
    <!-- CONTENT START -->
    <div class="page-content">
        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center">
            <div class="overlay-main innr-bnr-olay"></div>
            <div class="wt-bnr-inr-entry">
                <div class="banner-title-outer">
                    <div class="banner-title-name">
                        <h2 class="wt-title">{{ $product->name }}</h2>
                    </div>
                    <!-- BREADCRUMB ROW -->
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('front.home-page') }}">Trang chủ</a></li>
                            <li>{{ $product->name }}</li>
                        </ul>
                    </div>
                </div>
                <!-- BREADCRUMB ROW END -->
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->
        <!-- SECTION CONTENT START -->
        <div class="section-full p-t50 p-b50">
            <!-- PRODUCT DETAILS -->
            <div class="container woo-entry m-b30">
                <div class="twm-pro-detailwrap row m-b30">
                    <div class="col-lg-4 rightSidebar">
                        <div class=" wt-product-gallery">
                            <!--Image Slider-->
                            <div class="swiper product-SW-view2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="mfp-gallery">
                                            <div class="wt-box">
                                                <div class="wt-thum-bx wt-img-overlay1 ">
                                                    <img src="{{ $product->image ? $product->image->path : 'https://placehold.co/600x600' }}" alt="" loading="lazy">
                                                    <div class="product-view">
                                                        <a class="elem pic-long product-view-btn"
                                                            href="{{ $product->image ? $product->image->path : 'https://placehold.co/600x600' }}" title="{{ $product->name }}"
                                                            data-lcl-txt="" data-lcl-author=""
                                                            data-lcl-thumb="{{ $product->image ? $product->image->path : 'https://placehold.co/600x600' }}">
                                                            <i class="bi bi-arrows-angle-expand"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($product->galleries as $gallery)
                                    <div class="swiper-slide">
                                        <div class="mfp-gallery">
                                            <div class="wt-box">
                                                <div class="wt-thum-bx wt-img-overlay1 ">
                                                    <img src="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x600' }}" alt="" loading="lazy">
                                                    <div class="product-view">
                                                        <a class="elem pic-long product-view-btn"
                                                            href="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x600' }}" title="{{ $product->name }}"
                                                            data-lcl-txt="" data-lcl-author=""
                                                            data-lcl-thumb="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x600' }}">
                                                            <i class="bi bi-arrows-angle-expand"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <!--Thumbnail Slider-->
                            <div class="swiper product-SW-view">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ $product->image ? $product->image->path : 'https://placehold.co/600x600' }}" alt="" loading="lazy">
                                    </div>
                                    @foreach ($product->galleries as $gallery)
                                    <div class="swiper-slide">
                                        <img src="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x600' }}" alt="" loading="lazy">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="product-detail-info">
                            <div class="single-product-title ">
                                <h3 class="post-title"><a href="javascript:void(0);">{{ $product->name }}</a></h3>
                            </div>
                            <div class="product-pr-rate">
                                <div class="product-single-price">
                                    @if ($product->base_price > 0 && $product->price > 0)
                                    <span class="p-single-old-price">{{ formatCurrency($product->base_price) }}</span>
                                    <span class="p-single-new-price">{{ formatCurrency($product->price) }}</span>
                                    @elseif ($product->base_price > 0 && $product->price == 0)
                                    <span class="p-single-new-price">{{ formatCurrency($product->base_price) }}</span>
                                    @elseif ($product->price > 0 && $product->base_price == 0)
                                    <span class="p-single-new-price">{{ formatCurrency($product->price) }}</span>
                                    @else
                                    <span class="p-single-new-price">Liên hệ</span>
                                    @endif
                                </div>
                                <div class="product-single-rating">
                                    <span class="rating-bx site-text-primary">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </span>
                                    <span class="font-weight-600 text-black">(customer reviews)</span>
                                </div>
                            </div>
                            <ul class="product_meta">
                                <li class="sku_wrapper">SKU:
                                    <span class="sku">{{ $product->sku }}</span>
                                </li>
                                <li class="posted_in">Categories:
                                    <a href="{{ route('front.show-product-category', $product->category->slug) }}" rel="tag">{{ $product->category->name }}</a>
                                </li>
                                <li class="product-single-availability">
                                    Availability: <span>{{ $product->stock_qty }} {{ $product->stock_qty > 1 ? 'Sản phẩm' : 'Sản phẩm' }}</span>
                                </li>
                            </ul>
                            <div class="wt-product-text">
                                <p>{!! $product->intro !!}</p>
                            </div>
                            {{-- <div class="quantity-btn-wrap">
                                <form method="post" class="cart clearfix m-t30">
                                    <div class="quantity btn-quantity">
                                        <input id="demo_vertical2" type="text" value="1" name="demo_vertical2">
                                    </div>
                                    <button class="site-button">Add to Cart</button>
                                </form>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <!-- Detail SECTION START -->
                <div class="product-detail-full">
                    <div class="wt-accordion " id="accordion-two">
                        <!--One-->
                        <div class="panel wt-panel">
                            <div class="acod-head" id="headingOne">
                                <h4 class="acod-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        Chi tiết sản phẩm
                                        <span class="indicator"><i class="bi bi-plus"></i></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordion-two">
                                <div class="acod-content p-tb15">
                                    {!! $product->body !!}
                                </div>
                            </div>
                        </div>
                        <!--Two-->
                    </div>
                </div>
                <!-- Detail SECTION END -->
            </div>
            <!-- PRODUCT DETAILS -->
        </div>
        <!-- CONTENT CONTENT END -->
        <!-- SECTION CONTENT START -->
        @if ($productsRelated->count() > 0)
        <div class="section-full p-t50 p-b50 site-bg-white">
            <div class="container">
                <div class="section-content">
                    <!-- TITLE START-->
                    <div class="section-head center wt-small-separator-outer">
                        <div class="wt-small-separator site-text-primary">
                            <i class="bi bi-house"></i>
                            <div>Sản phẩm liên quan</div>
                        </div>
                        <h2 class="wt-title  title_split_anim">Sản phẩm liên quan</h2>
                    </div>
                    <!-- TITLE END-->
                    <div class="featured-products">
                        <div class="owl-carousel related-project-slider">
                            <!-- COLUMNS 1 -->
                            @foreach ($productsRelated as $item)
                            <div class="item">
                                <div class="wt-box wt-product-box   overflow-hide">
                                    <div class="wt-thum-bx wt-img-overlay1">
                                        <a href="{{ route('front.show-product-detail', $item->slug) }}">
                                            <img src="{{ $item->image ? $item->image->path : 'https://placehold.co/600x600' }}" alt="" loading="lazy">
                                        </a>
                                        {{-- <div class="item-cart-view">
                                            <div class="item-btn">
                                                <a href="javascript:void(0);">
                                                    <i class="fa fa-cart-plus"></i>
                                                </a>
                                            </div>
                                            <div class="item-btn">
                                                <a href="javascript:void(0);">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="wt-info text-center">
                                        <h4 class="wt-title">
                                            <a href="{{ route('front.show-product-detail', $item->slug) }}">{{ $item->name }}</a>
                                        </h4>
                                        <span class="price">
                                            @if ($item->base_price > 0 && $item->price > 0)
                                            <del><span><span class="Price-currencySymbol">₫</span>{{ formatCurrency($item->base_price) }}</span></del>
                                            <ins>
                                                <span><span class="Price-currencySymbol">₫</span>{{ formatCurrency($item->price) }}</span>
                                            </ins>
                                            @elseif ($item->base_price > 0 && $item->price == 0)
                                            <ins>
                                                <span><span class="Price-currencySymbol">₫</span>{{ formatCurrency($item->base_price) }}</span>
                                            </ins>
                                            @elseif ($item->price > 0 && $item->base_price == 0)
                                            <ins>
                                                <span><span class="Price-currencySymbol">₫</span>{{ formatCurrency($item->price) }}</span>
                                            </ins>
                                            @else
                                            <ins>
                                                <span><span class="Price-currencySymbol"></span>Liên hệ</span>
                                            </ins>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- SECTION CONTENT END -->
    </div>
    <!-- CONTENT END -->
@endsection

@push('script')
    {{-- <script>
        var swiper = new Swiper(".mySwiper", {
            // loop: true,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            loop: true,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });
    </script>
    <script>
        // Plus number quantiy product detail
        var plusQuantity = function() {
            if (jQuery('input[name="quantity"]').val() != undefined) {
                var currentVal = parseInt(jQuery('input[name="quantity"]').val());
                if (!isNaN(currentVal)) {
                    jQuery('input[name="quantity"]').val(currentVal + 1);
                } else {
                    jQuery('input[name="quantity"]').val(1);
                }
            } else {
                console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
            }
        }
        // Minus number quantiy product detail
        var minusQuantity = function() {
            if (jQuery('input[name="quantity"]').val() != undefined) {
                var currentVal = parseInt(jQuery('input[name="quantity"]').val());
                if (!isNaN(currentVal) && currentVal > 1) {
                    jQuery('input[name="quantity"]').val(currentVal - 1);
                }
            } else {
                console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
            }
        }
        app.controller('ProductDetailController', function($scope, $http, $interval, cartItemSync, $rootScope, $compile,
            notiProduct) {
            $scope.product = @json($product);
            $scope.form = {
                quantity: 1
            };

            $scope.selectedAttributes = [];
            jQuery('.product-attribute-values .badge').click(function() {
                if (!jQuery(this).hasClass('active')) {
                    jQuery(this).parent().find('.badge').removeClass('active');
                    jQuery(this).addClass('active');
                    if ($scope.selectedAttributes.length > 0 && $scope.selectedAttributes.find(item => item
                            .index == jQuery(this).data('index'))) {
                        $scope.selectedAttributes.find(item => item.index == jQuery(this).data('index'))
                            .value = jQuery(this).data('value');
                    } else {
                        let index = jQuery(this).data('index');
                        $scope.selectedAttributes.push({
                            index: index,
                            name: jQuery(this).data('name'),
                            value: jQuery(this).data('value'),
                        });
                    }
                } else {
                    jQuery(this).parent().find('.badge').removeClass('active');
                    jQuery(this).removeClass('active');
                    $scope.selectedAttributes = $scope.selectedAttributes.filter(item => item.index !=
                        jQuery(this).data('index'));
                }
                $scope.$apply();
            });

            $scope.addToCartFromProductDetail = function() {
                let quantity = $('.details-product input[name="quantity"]').val();

                url = "{{ route('cart.add.item', ['productId' => 'productId']) }}";
                url = url.replace('productId', $scope.product.id);

                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        'qty': parseInt(quantity),
                        'attributes': $scope.selectedAttributes
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.count > 0) {
                                $scope.hasItemInCart = true;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                                notiProduct.product_id = response.noti_product.product_id;
                                notiProduct.product_name = response.noti_product
                                    .product_name;
                                notiProduct.product_image = response.noti_product
                                    .product_image;
                                notiProduct.product_price = response.noti_product
                                    .product_price;
                                notiProduct.product_qty = response.noti_product.product_qty;
                            }, 1000);
                            // toastr.success('Thao tác thành công !')
                            $scope.$applyAsync();

                            $('#popup-cart-mobile').addClass('active');
                            $('.backdrop__body-backdrop___1rvky').addClass('active');
                            $('#quick-view-product.quickview-product').hide();
                        }
                    },
                    error: function() {
                        toastr.error('Thao tác thất bại !')
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.addToCartCheckoutFromProductDetail = function() {
                let quantity = $('.details-product input[name="quantity"]').val();
                url = "{{ route('cart.add.item', ['productId' => 'productId']) }}";
                url = url.replace('productId', $scope.product.id);

                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        'qty': parseInt(quantity),
                        'attributes': $scope.selectedAttributes
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.count > 0) {
                                $scope.hasItemInCart = true;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);
                            toastr.success('Thao tác thành công !')
                            window.location.href = "{{ route('cart.checkout') }}";
                        }
                    },
                    error: function() {
                        toastr.error('Thao tác thất bại !')
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }
        });
    </script> --}}
@endpush
