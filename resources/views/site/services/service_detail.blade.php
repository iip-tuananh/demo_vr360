@extends('site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
    {{ url('' . $service->image ? $service->image->path : 'https://placehold.co/600x600') }}
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
        <!-- SERVICE DETAIL SECTION START -->
        <div class="section-full p-t50 p-b50">
            <div class="section-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="section-content service-full-info">
                                <div class="services-etc m-b30">
                                    <div class="wt-media m-b30">
                                        <img src="{{ $service->image ? $service->image->path : 'https://placehold.co/600x600' }}" alt="" loading="lazy">
                                    </div>
                                    <div class="wt-info">
                                        <div class="text-left">
                                            <h2 class="wt-title m-b20">{{ $title }}</h2>
                                        </div>
                                        <p>{!! $content !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 rightSidebar twm-sidebar-section">
                            <div class="all_services_list">
                                <div class="all_services m-b30">
                                    <ul>
                                        @foreach ($services as $item)
                                            <li><a href="{{ route('front.service-detail', $item->slug) }}" class="{{ $item->slug == $service->slug ? 'active' : '' }}">{{ $item->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            {{-- <div class="service-side-btn m-b30">
                                <h3 class="wt-title m-b20">Brochures</h3>
                                <p>View our 2025 financial prospectus brochure for an easy to read guide on all of the
                                    services offer.</p>
                                <div class="btn-block">
                                    <a href="images/poster.zip">
                                        <strong><span class="bi bi-file-earmark-pdf-fill"></span>Documentation</strong>
                                        <i class="download-btn fa fa-download"></i>
                                    </a>
                                    <a href="images/poster.zip">
                                        <strong><span class="bi bi-file-earmark-word-fill"></span>Company Brochure</strong>
                                        <i class="download-btn fa fa-download"></i>
                                    </a>
                                    <a href="images/poster.zip">
                                        <strong><span class="bi bi-file-earmark-play-fill"></span>Company Report
                                            2025</strong>
                                        <i class="download-btn fa fa-download"></i>
                                    </a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SERVICE DETAIL SECTION END -->
    </div>
    <!-- CONTENT END -->
@endsection

@push('script')
@endpush
