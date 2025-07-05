<div class="item-blog animate__animated ">
    <div class="block-thumb">
        <a class="thumb"
            href="{{ route('front.detail-blog', $post->slug) }}"
            title="{{ $post->name }}">
            <img class="img-responsive lazyload"
                src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                data-src="{{ $post->image->path }}"
                alt="{{ $post->name }}">
        </a>
    </div>
    <div class="block-info">
        <div class="post">
            <div class="time-post f">
                {{ \Carbon\Carbon::parse($post->created_at)->locale('vi')->translatedFormat('l, d/m/Y') }}
            </div>
            -
            <div class="time-post">
                <span>By Admin</span>
            </div>
        </div>
        <h3>
            <a href="{{ route('front.detail-blog', $post->slug) }}"
                title="{{ $post->name }}">{{ $post->name }}</a>
        </h3>
        <div class="justify limit-3-line">
            {{ $post->intro }}
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".block_video_play").lightGallery();
    });
</script>
<style>
    .limit-3-line {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 10px;
    }
</style>
