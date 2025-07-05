<!-- HEADER START -->
<header class="sticky-header site-header header-style-2 mobile-sider-drawer-menu">
    <div class="main-bar-wraper  navbar-expand-lg">
        <div class="main-bar">

            <div class="container-fluid clearfix">

                <div class="logo-header">
                    <div class="logo-header-inner logo-header-one">
                        <a href="{{route('front.home-page')}}">
                            <img src="{{ $config->image ? $config->image->path : 'https://placehold.co/100x100' }}" alt="">
                        </a>
                    </div>
                </div>


                <!-- NAV Toggle Button -->
                <button id="mobile-side-drawer" data-target=".header-nav" data-toggle="collapse" type="button"
                    class="navbar-toggler collapsed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar icon-bar-first"></span>
                    <span class="icon-bar icon-bar-two"></span>
                    <span class="icon-bar icon-bar-three"></span>
                </button>

                <!-- MAIN Vav -->
                <div class="nav-animation header-nav navbar-collapse collapse d-flex justify-content-end">

                    <ul class=" nav navbar-nav">
                        <li><a href="{{route('front.home-page')}}">Trang chủ</a></li>
                        <li><a href="{{route('front.about-us')}}">Về Chúng Tôi</a></li>

                        <li class="has-child"><a href="javascript:;">Dịch vụ</a>
                            <ul class="sub-menu">
                                @foreach ($services as $service)
                                    <li><a href="{{route('front.service-detail', $service->slug)}}">{{$service->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="has-child"><a href="javascript:;">Dự án</a>
                            <ul class="sub-menu">
                                @foreach ($projectCategories as $projectCategory)
                                    <li><a href="{{route('front.show-project-category', $projectCategory->slug)}}">{{$projectCategory->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="has-child">
                            <a href="javascript:;">Sản phẩm</a>
                            <ul class="sub-menu">
                                @foreach ($productCategories as $productCategory)
                                <li class="has-child"><a href="{{route('front.show-product-category', $productCategory->slug)}}">{{$productCategory->name}}</a>
                                    @if ($productCategory->childs->count() > 0)
                                    <div class="fa fa-angle-right submenu-toogle"></div>
                                    <ul class="sub-menu">
                                        @foreach ($productCategory->childs as $child)
                                            <li><a href="{{route('front.show-product-category', $child->slug)}}">{{$child->name}}</a></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @foreach ($postCategories as $postCategory)
                        <li class="has-child"><a href="{{route('front.list-blog', $postCategory->slug)}}">{{$postCategory->name}}</a>
                            <ul class="sub-menu">
                                @foreach ($postCategory->childs as $child)
                                    <li><a href="{{route('front.list-blog', $child->slug)}}">{{$child->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach

                        <li><a href="{{route('front.contact-us')}}">Liên hệ</a></li>

                    </ul>

                </div>

                <!-- Header Right Section-->
                <div class="extra-nav header-1-nav">
                    <div class="extra-cell one">
                        <div class="header-search">
                            <a href="#search" class="header-search-icon"><i class="bi bi-search"></i></a>
                        </div>
                    </div>
                </div>




                <!-- SITE Search -->
                <div id="search">
                    <span class="close-btn">X</span>
                    <form role="search" id="searchform" action="{{ route('front.search') }}" method="get" class="radius-xl">
                        <div class="input-group">
                            <input class="form-control" value="" name="keyword" type="search"
                                placeholder="Search...">
                            <span class="input-group-append">
                                <button type="button" class="search-btn">
                                    <i class="bi bi-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</header>
<!-- HEADER END -->
