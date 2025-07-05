<form class="variants product-action "
    enctype="multipart/form-data">
    <div class="product-thumbnail">
        <a class="image_thumb scale_hover" href="{{ route('front.show-product-detail', $product->slug) }}" title="{{$product->name}}">
            <img class="lazyload" width="200" height="200"
                {{-- src="data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA="
                data-src="{{$product->image ? $product->image->path : ''}}" --}}
                src="{{$product->image ? $product->image->path : ''}}"
                alt="{{$product->name}}">
        </a>
    </div>
    <div class="product-info">
        <h3 class="product-name"><a href="{{ route('front.show-product-detail', $product->slug) }}" title="{{$product->name}}">{{$product->name}}</a></h3>
        @if ($product->price)
            <div class="price-box">
                {{formatCurrency($product->price)}}₫
            </div>
        @else
            <div class="price-box cursor-pointer" onclick="window.location.href = 'tel:{{ str_replace(' ', '', $config->hotline) }}'">
                Liên hệ
            </div>
        @endif
        <div class="actions-primary">
            @if ($product->price)
            <button class="btn-cart add_to_cart " title="Thêm vào giỏ hàng" ng-click="addToCart({{ $product->id }})">
                <svg class="icon icon-cart">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-cart"></use>
                </svg>
            </button>
            @endif
        </div>
    </div>
</form>
