@extends('site.layouts.master')
@section('title')
    {{ $cate_title }}
@endsection
@section('description')
    {{ $cate_des ?? '' }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
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
                        <h2 class="wt-title">{{ $cate_title }}</h2>
                    </div>
                    <!-- BREADCRUMB ROW -->
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('front.home-page') }}">Trang chủ</a></li>
                            <li>{{ $cate_title }}</li>
                        </ul>
                    </div>
                </div>
                <!-- BREADCRUMB ROW END -->
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->
        <!-- OUR BLOG START -->
        <div class="section-full p-t50  p-b50">
            <div class="container">
                <div class="section-content">
                    <div class="row justify-content-center">
                        <!-- COLUMNS 1 -->
                        @foreach ($blogs as $item)
                        <div class="col-lg-4 col-md-6 m-b30">
                            <div class="blog-post blog-post-5-outer">
                                <div class="wt-post-media">
                                    <a href="{{ route('front.detail-blog', $item->slug) }}"><img src="{{ $item->image ? $item->image->path : 'https://placehold.co/600x600' }}" alt=""></a>
                                </div>
                                <div class="wt-post-info">
                                    <div class="wt-post-meta ">
                                        <ul>
                                            <li class="post-category">{{ $item->category->name }}</li>
                                            <li class="post-date"><span>{{ $item->created_at->format('d') }}</span> {{ $item->created_at->format('M') }} {{ $item->created_at->format('Y') }}</li>
                                        </ul>
                                    </div>
                                    <div class="wt-post-title ">
                                        <h3 class="post-title"><a href="{{ route('front.detail-blog', $item->slug) }}">{{ $item->name }}</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <ul class="custom-pagination clearfix">
                        {{ $blogs->links() }}
                    </ul>
                </div>
            </div>
        </div>
        <!-- OUR BLOG END -->
    </div>
    <!-- CONTENT END -->
@endsection

@push('script')
@endpush
