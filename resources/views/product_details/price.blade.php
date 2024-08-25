<h3 class="theme-color price">
    @if($variants && count($variants) > 0)
        @if($variantMinDiscountPrice > 0)
            <em class="product-price">৳ {{number_format($variantMinDiscountPrice)}}</em> <del class="text-content">৳{{number_format($variantMinPrice)}}</del>
            {{-- <span class="offer theme-color">({{number_format((($variantMinPrice-$variantMinDiscountPrice)*100)/$variantMinPrice)}}% off)</span> --}}

            <input type="hidden" name="product_price" id="product_discount_price" value="{{$variantMinDiscountPrice}}">
            <input type="hidden" name="product_price" id="product_price" value="{{$variantMinPrice}}">
        @else
            <em class="product-price">৳ {{number_format($variantMinPrice)}}</em> <del class="text-content"></del>

            <input type="hidden" name="product_price" id="product_discount_price" value="0">
            <input type="hidden" name="product_price" id="product_price" value="{{$variantMinPrice}}">
        @endif
    @else
        @if($product->discount_price > 0)
            <em class="product-price">৳ {{number_format($product->discount_price)}}</em> <del class="text-content">৳{{number_format($product->price)}}</del>
            {{-- <span class="offer theme-color">({{number_format((($product->price-$product->discount_price)*100)/$product->price)}}% off)</span> --}}

            <input type="hidden" name="product_price" id="product_discount_price" value="{{$product->discount_price}}">
            <input type="hidden" name="product_price" id="product_price" value="{{$product->price}}">
        @else
            <em class="product-price">৳ {{number_format($product->price)}}</em> <del class="text-content"></del>

            <input type="hidden" name="product_price" id="product_discount_price" value="0">
            <input type="hidden" name="product_price" id="product_price" value="{{$product->price}}">
        @endif
    @endif
</h3>
