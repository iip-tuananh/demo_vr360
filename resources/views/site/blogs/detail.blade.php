@extends('site.layouts.master')
@section('title')
    {{ $blog_title }}
@endsection
@section('description')
    {{ strip_tags($blog->intro) }}
@endsection
@section('image')
    {{ $blog->image ? $blog->image->path : '' }}
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
                        <h2 class="wt-title">{{ $blog_title }}</h2>
                    </div>
                    <!-- BREADCRUMB ROW -->
                    {{-- <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('front.home-page') }}">Trang chủ</a></li>
                            <li>{{ $blog_title }}</li>
                        </ul>
                    </div> --}}
                </div>
                <!-- BREADCRUMB ROW END -->
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->
        <!-- OUR BLOG START -->
        <div class="section-full  p-t50 p-b50">
            <div class="container">
                <!-- BLOG SECTION START -->
                <div class="section-content">
                    <div class="row d-flex justify-content-center">
                        <div class="col-xl-9 col-lg-9 col-md-12  m-b30">
                            <!-- BLOG DETAIL START -->
                            <div class="blog-post-single-outer">
                                <div class="blog-post-style-2 blog-post-single">
                                    <div class="single-post-content">
                                        <img src="{{ $blog->image ? $blog->image->path : 'https://placehold.co/600x600' }}" alt="">
                                        <div class="wt-post-meta">
                                            <ul>
                                                <li class="post-date">{{ $blog->created_at->format('d') }} {{ $blog->created_at->format('M') }} {{ $blog->created_at->format('Y') }}</li>
                                                <li class="post-comment">0 <span>Comment</span></li>
                                            </ul>
                                        </div>
                                        <div class="wt-post-title ">
                                            <h2 class="post-title">{{ $blog->name }}
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="wt-post-info">
                                        <div class="wt-post-discription">
                                            {!! $blog->body !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="s-post-tag-share">
                                    <div class="s-post-share">
                                        <h3 class="twm-title">Share This Post</h3>
                                        <div class="twm-social2">
                                            <ul>
                                                <li><a href="https://www.x.com" class="tm-s-x"><i
                                                            class="bi bi-twitter-x"></i></a></li>
                                                <li><a href="https://www.facebook.com" class="tm-s-fb"><i
                                                            class="bi bi-facebook"></i></a></li>
                                                <li><a href="https://www.instagram.com" class="tm-s-in"><i
                                                            class="bi bi-instagram"></i></a></li>
                                                <li><a href="https://www.pinterest.com/" class="tm-s-pi"><i
                                                            class="bi bi-pinterest"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- OUR BLOG END -->
    </div>
    <!-- CONTENT END -->
@endsection

@push('script')
@endpush
