@extends('site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('description')
    {{ $description ? $description : $config->web_des }}
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
        <!-- Project START -->
        <div class="section-full p-t50 p-b50 projects-outer-full">
            <div class="container">
                <div class="section-content">
                    <div class="project-box-style1-outer row clearfix d-flex justify-content-center flex-wrap">
                        <!-- COLUMNS 1 -->
                        @foreach ($projects as $item)
                        <div class=" col-xl-4 col-lg-6 col-md-6">
                            <div class="twm-pro-st2">
                                <div class="twm-pro-st2-media">
                                    <img src="{{ $item->image ? $item->image->path : 'https://placehold.co/600x600' }}" alt="img20">
                                    <a class="elem project-view-btn" href="{{ $item->image ? $item->image->path : 'https://placehold.co/600x600' }}" title="{{ $item->title }}"
                                        data-lcl-txt="" data-lcl-author="" data-lcl-thumb="{{ $item->image ? $item->image->path : 'https://placehold.co/600x600' }}"><i
                                            class="fa fa-search-plus"></i>
                                    </a>
                                </div>
                                <div class="twm-pro-st2-inner">
                                    <h3 class="wt-title"><a href="{{ route('front.show-project-detail', $item->slug) }}">{{ $item->title }}</a></h3>
                                    <span class="project-new-category">{{ $item->category->name }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center load-more-btn-outer m-t30 m-b30">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- Project SECTION END -->
    </div>
@endsection

@push('script')
@endpush
