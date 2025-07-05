<div class="position-sticky">
    <div class="aside-content aside-content-blog">
        <div class="title-head">
            Dịch vụ tiêu biểu
        </div>
        <nav class="nav-category">
            <ul class="nav navbar-pills">
                @foreach ($services as $service)
                    <li class="nav-item  relative">
                        <a title="{{ $service->name }}" class="nav-link" href="{{ route('front.service-detail', $service->slug) }}">
                            {{ $service->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    <script>
        $(".open_mnu").click(function() {
            $(this).toggleClass('cls_mn').next().slideToggle();
        });
    </script>
    <div class="blog_noibat">
        <h2 class="h2_sidebar_blog">
            <a href="javascript:void(0)" title="Tin tức nổi bật">Tin tức nổi bật</a>
        </h2>
        <div class="blog_content">
            @foreach ($newBlogs as $blog)
                <div class="item">
                    <div class="thumb">
                        <a href="{{ route('front.detail-blog', $blog->slug) }}"
                            title="{{ $blog->name }}" class="thumb">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA="
                                data-src="{{ $blog->image->path }}"
                                alt="{{ $blog->name }}"
                                class="lazyload" />
                        </a>
                    </div>
                    <h3><a title="{{ $blog->name }}"
                            href="{{ route('front.detail-blog', $blog->slug) }}">{{ $blog->name }}</a></h3>
                </div>
            @endforeach
        </div>
    </div>
</div>
