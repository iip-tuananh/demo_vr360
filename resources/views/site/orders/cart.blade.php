@extends('site.layouts.master')
@section('title')
    Giỏ hàng
@endsection

@section('css')
    <link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/cartpage.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
@endsection

@section('content')
    <div ng-controller="CartController" ng-cloak>
        <section class="bread-crumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li class="home">
                        <a href="{{ route('front.home-page') }}" title="Trang chủ"><span>Trang chủ</span></a>
                        <span class="mr_lr">
                            &nbsp;
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                class="svg-inline--fa fa-chevron-right fa-w-10">
                                <path fill="currentColor"
                                    d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"
                                    class=""></path>
                            </svg>
                            &nbsp;
                        </span>
                    </li>
                    <li><strong><span>Giỏ hàng</span></strong></li>
                </ul>
            </div>
        </section>
        <section class="main-cart-page main-container col1-layout">
            <div class="main container cartpcstyle">
                <div class="wrap_background_aside margin-bottom-40">
                    <div class="header-cart">
                        <div class="title-block-page">
                            <h1 class="title_cart">
                                <span>Giỏ hàng của bạn</span>
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-12 col-cart-left col-xs-12 col-12">
                            <div class="clearfix"></div>
                            <div class="cart-page d-xl-block d-none">
                                <div class="drawer__inner">
                                    <div class="CartPageContainer" style="font-size: 16px;">
                                        <form class="cart ajaxcart cartpage">
                                            <div class="cart-header-info">
                                                <div>Thông tin sản phẩm</div>
                                                <div>Đơn giá</div>
                                                <div>Số lượng</div>
                                                <div>Thành tiền</div>
                                                <div>Hành động</div>
                                            </div>
                                            <div class="ajaxcart__inner ajaxcart__inner--has-fixed-footer cart_body items">
                                                <div class="ajaxcart__row" ng-repeat="item in items track by $index">
                                                    <div class="ajaxcart__product cart_product" data-line="1">
                                                        <a href="/san-pham/<%item.attributes.slug%>.html" class="ajaxcart__product-image cart_image" title="<%item.name%>">
                                                            <img ng-src="<%item.attributes.image%>" alt="<%item.name%>">
                                                        </a>
                                                        <div class="grid__item cart_info">
                                                        <div class="ajaxcart__product-name-wrapper cart_name">
                                                            <a href="/san-pham/<%item.attributes.slug%>.html" class="ajaxcart__product-name h4" title="<%item.name%>"><%item.name%></a>
                                                            <div class="cart_attribute">
                                                                <div ng-repeat="attribute in item.attributes.attributes" style="line-height: 1;">
                                                                    <span class="cart_attribute_name" style="margin-left: 8px; font-weight: 600; font-size: 14px;"><% attribute.name %> :</span>
                                                                    <span class="cart_attribute_value" style="font-size: 14px;"><% attribute.value %></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="grid__item one-half text-right cart_prices">
                                                                <span class="cart-price"><% item.price | number %>₫</span>
                                                            </div>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="grid__item one-half cart_select">
                                                                <div class="ajaxcart__qty input-group-btn">
                                                                    <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--minus items-count" data-id="" data-qty="0" data-line="1" aria-label="-" ng-click="decrementQuantity(item); changeQty(item.quantity, item.id)">
                                                                    -
                                                                    </button>
                                                                    <input type="text" name="updates[]" class="ajaxcart__qty-num number-sidebar" maxlength="3" ng-model="item.quantity" value="<%item.quantity%>" min="0" data-id="" data-line="1" aria-label="quantity" pattern="[0-9]*" ng-change="changeQty(item.quantity, item.id)">
                                                                    <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--plus items-count" data-id="" data-line="1" data-qty="2" aria-label="+" ng-click="incrementQuantity(item); changeQty(item.quantity, item.id)">
                                                                    +
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="grid__item one-half text-right cart_prices">
                                                                <span class="cart-price"><% item.price * item.quantity | number %>₫</span>
                                                            </div>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="grid__item one-half text-right cart_prices">
                                                                <a title="Xóa" class="cart__btn-remove remove-item-cart ajaxifyCart--remove" href="javascript:;" data-line="1" ng-click="removeItem(item.id)"><i class="fa fa-trash"></i> Xóa</a>
                                                            </div>
                                                        </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ajaxcart__footer ajaxcart__footer--fixed cart-footer">
                                                <div class="row">
                                                    <div class="col-lg-8 col-12">
                                                        <a class="btn-proceed-checkout btn-checkouts" title="Tiếp tục mua hàng" href="{{ route('front.home-page') }}">Tiếp tục mua hàng</a>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="ajaxcart__subtotal">
                                                        <div class="cart__subtotal">
                                                            <div class="cart__col-6">Tổng tiền:</div>
                                                            <div class="text-right cart__totle"><span class="total-price"><% total | number %>₫</span></div>
                                                        </div>
                                                        </div>
                                                        <div class="cart__btn-proceed-checkout-dt">
                                                        <button onclick="window.location.href = '{{ route('cart.checkout') }}'" type="button" class="button btn btn-default cart__btn-proceed-checkout" id="btn-proceed-checkout" title="Thanh toán">Thanh toán</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-mobile-page d-block d-xl-none">
                                <div class="CartMobileContainer">
                                    <form class="cart ajaxcart cart-mobile">
                                        <div class="ajaxcart__inner ajaxcart__inner--has-fixed-footer cart_body">
                                            <div class="ajaxcart__row" ng-repeat="item in items" style="display: flex;">
                                                <div class="ajaxcart__product-select cart_select_mobile" style="width: 5%;">
                                                    <input style="cursor: pointer; min-height: 75px; height: 75px; width: 4%;" type="checkbox" ng-model="item.selected" ng-change="selectItem(item)">
                                                </div>
                                                <div class="ajaxcart__product cart_product" data-line="1">
                                                    <a href="/san-pham/<%item.attributes.slug%>.html" class="ajaxcart__product-image cart_image" title="<%item.name%>">
                                                        <img ng-src="<%item.attributes.image%>" alt="<%item.name%>">
                                                    </a>
                                                    <div class="grid__item cart_info">
                                                    <div class="ajaxcart__product-name-wrapper cart_name">
                                                        <a href="/san-pham/<%item.attributes.slug%>.html" class="ajaxcart__product-name h4" title="<%item.name%>"><%item.name%></a>
                                                    </div>
                                                    <div class="cart_attribute">
                                                        <div ng-repeat="attribute in item.attributes.attributes" style="line-height: 1;">
                                                            <span class="cart_attribute_name" style="margin-left: 8px; font-weight: 600; font-size: 14px;"><% attribute.name %> :</span>
                                                            <span class="cart_attribute_value" style="font-size: 14px;"><% attribute.value %></span>
                                                        </div>
                                                    </div>
                                                    <div class="grid">
                                                        <div class="grid__item one-half cart_select cart_item_name">
                                                            <div class="ajaxcart__qty input-group-btn">
                                                                <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--minus items-count" data-id="" data-qty="0" data-line="1" aria-label="-">
                                                                -
                                                                </button>
                                                                <input type="text" name="updates[]" class="ajaxcart__qty-num number-sidebar" maxlength="3" value="1" min="0" data-id="" data-line="1" aria-label="quantity" pattern="[0-9]*">
                                                                <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--plus items-count" data-id="" data-line="1" data-qty="2" aria-label="+">
                                                                +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="grid__item one-half text-right cart_prices">
                                                            <span class="cart-price"><% item.price * item.quantity | number %>₫</span>
                                                            <a title="Xóa" class="cart__btn-remove remove-item-cart ajaxifyCart--remove" href="javascript:;" data-line="1" ng-click="removeItem(item)">Xóa</a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ajaxcart__footer ajaxcart__footer--fixed cart-footer">
                                            <div class="ajaxcart__subtotal">
                                                <div class="cart__subtotal">
                                                    <div class="cart__col-6">Tổng tiền:</div>
                                                    <div class="text-right cart__totle"><span class="total-price"><% total | number %>₫</span></div>
                                                </div>
                                            </div>
                                            <div class="cart_btn_continue">
                                                <a class="btn-proceed-checkout btn-checkouts" title="Tiếp tục mua hàng" href="{{ route('front.home-page') }}">Tiếp tục mua hàng</a>
                                            </div>
                                            <div class="cart__btn-proceed-checkout-dt">
                                                <button onclick="window.location.href = '{{ route('cart.checkout') }}'" type="button" class="button btn btn-default cart__btn-proceed-checkout" id="btn-proceed-checkout" title="Thanh toán">Thanh toán</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        app.controller('CartController', function($scope, cartItemSync, $interval, $rootScope) {
            $scope.items = @json($cartCollection);
            $scope.total = @json($total_price);
            Object.keys($scope.items).forEach(function(item) {
                $scope.items[item].selected = false;
            });
            $scope.total_selected = 0;
            $scope.total_qty = "{{ $total_qty }}";
            $scope.checkCart = true;
            $scope.cart_items_selected = [];

            $scope.countItem = Object.keys($scope.items).length;

            jQuery(document).ready(function() {
                if ($scope.total == 0) {
                    $scope.checkCart = false;
                    $scope.$applyAsync();
                }
            })

            $scope.selectAllItems = function() {
                $scope.total_selected = 0;
                $scope.cart_items_selected = [];
                Object.keys($scope.items).forEach(function(item) {
                    $scope.items[item].selected = $scope.selectAll;
                    if ($scope.items[item].selected) {
                        $scope.cart_items_selected.push($scope.items[item]);
                    } else {
                        $scope.cart_items_selected.splice($scope.cart_items_selected.indexOf($scope.items[item].id), 1);
                    }
                });
                $scope.total_selected = $scope.cart_items_selected.reduce(function(total, item) {
                    return total + item.price * item.quantity;
                }, 0);
                $scope.$applyAsync();
            }

            $scope.selectItem = function(item) {
                const existingItemIndex = $scope.cart_items_selected.findIndex(selectedItem => selectedItem.id === item.id);
                if (existingItemIndex == -1 && item.selected) {
                    $scope.cart_items_selected.push(item);
                } else {
                    $scope.cart_items_selected.splice(existingItemIndex, 1);
                }
                $scope.total_selected = $scope.cart_items_selected.reduce(function(total, item) {
                    return total + item.price * item.quantity;
                }, 0);

                let check = true;
                Object.keys($scope.items).forEach(function(item) {
                    if (!$scope.items[item].selected) {
                        check = false;
                        return;
                    }
                });
                $scope.selectAll = check;

                $scope.$applyAsync();
            }

            $scope.submitCart = function() {
                if ($scope.cart_items_selected.length == 0 || $scope.total_selected == 0) {
                    toastr.warning('Chọn sản phẩm thanh toán');
                    return;
                }
                localStorage.setItem('cart_items_selected', JSON.stringify($scope.cart_items_selected));
                localStorage.setItem('total_selected', $scope.total_selected);
                window.location.href = "{{ route('cart.checkout') }}";
            }

            $scope.changeQty = function(qty, product_id) {
                updateCart(qty, product_id)
            }

            $scope.incrementQuantity = function(product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function(product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };

            function updateCart(qty, product_id) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{ route('cart.update.item') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        product_id: product_id,
                        qty: qty
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            $scope.total_selected = 0;
                            $scope.cart_items_selected = [];
                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.$applyAsync();
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.removeItem = function(product_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('cart.remove.item') }}",
                    data: {
                        product_id: product_id
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            $scope.total_selected = 0;
                            $scope.cart_items_selected = [];
                            if ($scope.total == 0) {
                                $scope.checkCart = false;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.countItem = Object.keys($scope.items).length;

                            $scope.$applyAsync();
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }
        });
    </script>
@endpush
