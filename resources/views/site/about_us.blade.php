@extends('site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection

@section('css')
    <style>
        .limit-5-line {
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .limit-3-line {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
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
                        <h2 class="wt-title">Giới thiệu</h2>
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
        <!--About Some info Sction-->
        <div class="twm-abt2-s-info">
            <div class="container">
                <div class="twm-abt2-certi-info">
                    <h2 class="title">{{ $title }}</h2>
                    <div class="twm-abt2-certi-info-detail">
                        {!! $config->introduction !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- WHAT WE DO SECTION START -->
        <div class="section-full  p-t60 p-b60">
            <div class="container">
                <div class="s-section-three">
                    <div class="row d-flex justify-content-center">

                        <!-- COLUMNS 1 -->
                        <div class="col-lg-4 col-md-6  m-b30">
                            <div class="icon-box-style-three-title">
                                <div class="icon-box-style-three-title-bg">
                                    <!-- TITLE START-->
                                    <div class="section-head left wt-small-separator-outer ">
                                        <div class="wt-small-separator site-text-primary">
                                            <i class="bi bi-house"></i>
                                            <div>Tại Sao ?</div>
                                        </div>
                                        <h2 class="wt-title title_split_anim">Nên Chọn Chúng Tôi</h2>
                                    </div>
                                    <!-- TITLE END-->
                                </div>
                            </div>
                        </div>

                        <!-- COLUMNS 2 -->
                        <div class="col-lg-4 col-md-6  m-b30">
                            <div class="icon-box-style-three-wrap">
                                <div class="icon-box-style-three">

                                    <div class="wt-icon-box-wraper">
                                        <div class="icon-lg d-flex">
                                            <span class="icon-cell site-text-primary">
                                                <img src="/site/images/furniture-2.png" alt="Image"
                                                    loading="lazy"></span>
                                            <h3 class="wt-title"><a href="">Kinh nghiệm lâu năm</a></h3>
                                        </div>
                                    </div>

                                    <div class="icon-box-three-content">
                                        <p>Đã thực hiện hàng trăm công trình nội, ngoại thất lớn nhỏ trên toàn quốc.
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6  m-b30">
                            <div class="icon-box-style-three-wrap">
                                <div class="icon-box-style-three">

                                    <div class="wt-icon-box-wraper">
                                        <div class="icon-lg d-flex">
                                            <span class="icon-cell site-text-primary">
                                                <img src="/site/images/furniture-2.png" alt="Image"
                                                    loading="lazy"></span>
                                            <h3 class="wt-title"><a href="">Đội ngũ chuyên nghiệp</a></h3>
                                        </div>
                                    </div>

                                    <div class="icon-box-three-content">
                                        <p>Kiến trúc sư, kỹ sư và thợ thi công tay nghề cao, giàu nhiệt huyết.</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6  m-b30">
                            <div class="icon-box-style-three-wrap">
                                <div class="icon-box-style-three">

                                    <div class="wt-icon-box-wraper">
                                        <div class="icon-lg d-flex">
                                            <span class="icon-cell site-text-primary">
                                                <img src="/site/images/furniture-2.png" alt="Image"
                                                    loading="lazy"></span>
                                            <h3 class="wt-title"><a href="">Vật liệu cao cấp</a></h3>
                                        </div>
                                    </div>

                                    <div class="icon-box-three-content">
                                        <p>Đặc biệt là vật liệu WPC (Wood Plastic Composite) bền đẹp, chống nước,
                                            chống mối mọt</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6  m-b30">
                            <div class="icon-box-style-three-wrap">
                                <div class="icon-box-style-three">

                                    <div class="wt-icon-box-wraper">
                                        <div class="icon-lg d-flex">
                                            <span class="icon-cell site-text-primary">
                                                <img src="/site/images/furniture-2.png" alt="Image"
                                                    loading="lazy"></span>
                                            <h3 class="wt-title"><a href="">Quy trình rõ ràng</a></h3>
                                        </div>
                                    </div>

                                    <div class="icon-box-three-content">
                                        <p>Báo giá chi tiết, tối ưu ngân sách khách hàng.</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6  m-b30">
                            <div class="icon-box-style-three-wrap">
                                <div class="icon-box-style-three">

                                    <div class="wt-icon-box-wraper">
                                        <div class="icon-lg d-flex">
                                            <span class="icon-cell site-text-primary">
                                                <img src="/site/images/furniture-2.png" alt="Image"
                                                    loading="lazy"></span>
                                            <h3 class="wt-title"><a href="">Cam kết tiến độ</a></h3>
                                        </div>
                                    </div>

                                    <div class="icon-box-three-content">
                                        <p>bảo hành dài hạn: Hoàn thiện đúng thời gian, bảo hành tận tâm sau thi
                                            công.</p>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- WHAT WE DO SECTION END -->

        <!-- CLIENT LOGO SECTION START -->
        <div class="section-full  p-t60 p-b20 twm-home-client-carousel-wrap">
            <div class="container">
                <div class="section-content">
                    <div class="home-client-carousel1-wrap">
                        <!-- TITLE START-->
                        <div class="section-head center wt-small-separator-outer">
                            <div class="wt-small-separator site-text-primary">
                                <i class="bi bi-house"></i>
                                <div>Meet Our Client</div>
                            </div>
                            <h2 class="wt-title title_split_anim">Đối Tác Chiến Lược</h2>
                        </div>
                        <!-- TITLE END-->

                        <!-- Swiper -->
                        <div class="swiper home-client-carousel">
                            <div class="swiper-wrapper">
                                @foreach ($partners as $partner)
                                    <div class="swiper-slide">
                                        <div class="ow-client-logo">
                                            <div class="client-logo client-logo-media">
                                                <a href="{{ $partner->link }}"><img
                                                        src="{{ $partner->image ? $partner->image->path : 'https://placehold.co/100x100' }}"
                                                        alt="" loading="lazy"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CLIENT LOGO  SECTION End -->

        <!-- OUR TEAM START -->
        <div class="section-full p-t30 p-b30 ">
            <div class="container">
                <!-- TITLE START-->
                <div class="section-head center wt-small-separator-outer">
                    <h2 class="wt-title title_split_anim">Đội Ngũ Nhân Sự</h2>
                </div>
                <!-- TITLE END-->
                <div class="swiper home-client-founder">
                    <div class="swiper-wrapper">
                        @foreach ($founders as $founder)
                            <div class="swiper-slide">
                                <div class="team-effect-hvr2">
                                    <div class="team-hvr2-media">
                                        <img src="{{ $founder->image ? $founder->image->path : 'https://placehold.co/400x600' }}"
                                            alt="" loading="lazy">
                                    </div>

                                    <div class="content-info">
                                        <div class="content-info-inner">

                                            <div class="info-detail">
                                                <h3 class="wt-title"><a
                                                        href="{{ $founder->link_website }}">{{ $founder->name }}</a>
                                                </h3>
                                                <p class="wt-title-position">{{ $founder->position }}</p>
                                            </div>
                                            <p class="icon-links">
                                                <a href="{{ $founder->link_facebook }}"><i
                                                        class="bi bi-facebook"></i></a>
                                                <a href="{{ $founder->link_instagram }}"><i
                                                        class="bi bi-twitter-x"></i></a>
                                                <a href="{{ $founder->link_website }}"><i class="bi bi-dribbble"></i></a>
                                                <a href="{{ $founder->link_twitter }}"><i class="bi bi-twitter"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- OUR TEAM SECTION END -->
    </div>
    <!-- CONTENT END -->
@endsection

@push('script')
@endpush
