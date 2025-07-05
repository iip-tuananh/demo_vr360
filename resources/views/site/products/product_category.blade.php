@extends('site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('description')
    {{ $short_des }}
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
                        <h2 class="wt-title">{{ $title }}</h2>
                    </div>
                    <!-- BREADCRUMB ROW -->
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('front.home-page') }}">Trang chủ</a></li>
                            <li>{{ $title }}</li>
                        </ul>
                    </div>
                </div>
                <!-- BREADCRUMB ROW END -->
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->
        <!-- SHOP SECTION START -->
        <div class="section-full p-t50 p-b50">
            <div class="container">
                <!--Showing Result -->
                <div class="product-filter-wrap d-flex justify-content-between align-items-center m-b30">
                    <span class="woocommerce-result-count">Showing {{ $products->firstItem() }} &ndash; {{ $products->lastItem() }} of {{ $products->total() }} results</span>
                    <form class="woocommerce-ordering select-box-border-style1-wrapper" method="get">
                        <select name="orderby" class="orderby select-box-border-style1" aria-label="Shop order">
                            <option value="menu_order" selected='selected'>Default sorting</option>
                            <option value="popularity">Sort by popularity</option>
                            <option value="rating">Sort by average rating</option>
                            <option value="date">Sort by latest</option>
                            <option value="price">Sort by price: low to high</option>
                            <option value="price-desc">Sort by price: high to low</option>
                        </select>
                        <input type="hidden" name="paged" value="1">
                    </form>
                </div>
                <!--Showing Result -->
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="wt-product-box-wrap">
                            <div class="row">
                                <!-- COLUMNS 1 -->
                                @foreach ($products as $item)
                                <div class="col-lg-4 col-md-4 col-sm-6 m-b30">
                                    <div class="wt-box wt-product-box   overflow-hide">
                                        <div class="wt-thum-bx wt-img-overlay1">
                                            <a href="{{ route('front.show-product-detail', $item->slug) }}">
                                                <img src="{{ $item->image ? $item->image->path : 'https://placehold.co/600x600' }}" alt="" loading="lazy">
                                            </a>
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
                <ul class="custom-pagination clearfix">
                    {{ $products->links() }}
                </ul>
            </div>
        </div>
        <!-- SHOP SECTION END -->
    </div>
    <!-- CONTENT END -->
@endsection

@push('script')
@endpush
