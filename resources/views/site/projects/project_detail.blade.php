@extends('site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('description')
    {{ $description ? $description : $config->web_des }}
@endsection
@section('image')
    {{ url('' . $project->image ? $project->image->path : 'https://placehold.co/600x600') }}
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
                            {{-- <li><a
                                    href="{{ route('front.show-category-project', $project->category->slug) }}">{{ $project->category->name }}</a>
                            </li> --}}
                            <li>{{ $title }}</li>
                        </ul>
                    </div>
                </div>
                <!-- BREADCRUMB ROW END -->
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- Info SECTION START -->
        <div class="section-full p-t50 p-b50 bg-gray">
            <div class="container">
                <div class="section-content">
                    <!--About Some info Sction-->
                    <div class="twm-pro-sin-wrap">
                        <div class="twm-pro-sin-media  parallax-section">
                            <div class="parallax-image" style="background-image: url({{ $project->image ? $project->image->path : 'https://placehold.co/600x600' }});">
                            </div>
                        </div>
                    </div>
                    <!--About Some info Sction-->
                    <div class="project-single">
                        <div class="project-single-media-wrap">
                            <div class="owl-carousel project-single-img-slider m-b30">
                                <!--Column-1-->
                                @foreach ($project->galleries as $gallery)
                                <div class="item">
                                    <div class="project-single-media">
                                        <img src="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x600' }}" alt="">
                                        <a class="elem" href="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x600' }}" title="{{ $project->title }}"
                                            data-lcl-txt="" data-lcl-author=""
                                            data-lcl-thumb="{{ $gallery->image ? $gallery->image->path : 'https://placehold.co/600x600' }}">
                                            <i class="fa fa-search-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                                <!--Column-2-->
                                <div class="item">
                                    <div class="project-single-media">
                                        <img src="{{ $project->image ? $project->image->path : 'https://placehold.co/600x600' }}" alt="">
                                        <a class="elem" href="{{ $project->image ? $project->image->path : 'https://placehold.co/600x600' }}" title="{{ $project->title }}"
                                            data-lcl-txt="" data-lcl-author=""
                                            data-lcl-thumb="{{ $project->image ? $project->image->path : 'https://placehold.co/600x600' }}">
                                            <i class="fa fa-search-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="project-single-row-section m-b30">
                            {!! $project->des !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Info  SECTION END -->
    </div>
@endsection

@push('script')
@endpush
