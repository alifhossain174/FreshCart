<h5 class="price">
    @if ($variants && count($variants) > 0)
        @if ($variantMinDiscountPrice > 0)
            ৳{{ number_format($variantMinDiscountPrice) }}
            <del>৳{{ number_format($variantMinPrice) }}</del>
        @else
            ৳{{ number_format($variantMinPrice) }}
        @endif
    @else
        @if ($product->discount_price > 0)
            ৳{{ number_format($product->discount_price) }}
            <del>৳{{ number_format($product->price) }}</del>
        @else
            ৳{{ number_format($product->price) }}
        @endif
    @endif
</h5>

@if ($variants && count($variants) > 0)
    @if ($variantMinDiscountPrice > 0)
        <input type="hidden" name="product_price" id="product_discount_price" value="{{$variantMinDiscountPrice}}">
        <input type="hidden" name="product_price" id="product_price" value="{{$variantMinPrice}}">
    @else
        <input type="hidden" name="product_price" id="product_discount_price" value="0">
        <input type="hidden" name="product_price" id="product_price" value="{{$variantMinPrice}}">
    @endif
@else
    @if ($product->discount_price > 0)
        <input type="hidden" name="product_price" id="product_discount_price" value="{{$product->discount_price}}">
        <input type="hidden" name="product_price" id="product_price" value="{{$product->price}}">
    @else
        <input type="hidden" name="product_price" id="product_discount_price" value="0">
        <input type="hidden" name="product_price" id="product_price" value="{{$product->price}}">
    @endif
@endif
