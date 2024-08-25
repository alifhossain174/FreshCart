<div class="note-box product-packege">
    <div class="cart_qty qty-box product-qty">
        <div class="input-group">
            <button type="button" class="qty-left-minus2" data-id="{{ $product->id }}" data-field=""><i class="fa fa-minus" aria-hidden="true"></i></button>
            <input id="product_details_cart_qty" class="form-control input-number qty-input" type="text" name="quantity" value="{{ isset(session()->get('cart')[$product->id]) ? session()->get('cart')[$product->id]['quantity'] : 1 }}" />
            <button type="button" class="qty-right-plus2" data-id="{{ $product->id }}" data-field=""><i class="fa fa-plus" aria-hidden="true"></i></button>
        </div>
    </div>

    @if (isset(session()->get('cart')[$product->id]))
        <button class="btn btn-md bg-danger cart-button text-white w-100 cart-qty-{{ $product->id }} removeFromCartQty" data-id="{{ $product->id }}">Remove from Cart</button>
    @else
        <button class="btn btn-md bg-dark cart-button text-white w-100 cart-qty-{{ $product->id }} addToCartWithQty" data-id="{{ $product->id }}">Add To Cart</button>
    @endif

</div>

<div class="buy-box">
    <a href="{{ url('add/to/wishlist') }}/{{ $product->slug }}">
        <i data-feather="heart"></i>
        <span>Add To Wishlist</span>
    </a>

    {{-- <a href="compare.html">
        <i data-feather="shuffle"></i>
        <span>Add To Compare</span>
    </a> --}}
</div>
