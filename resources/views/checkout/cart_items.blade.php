@if (session('cart'))
    @foreach (session('cart') as $id => $details)
    <div class="single-checkout-order-review">
        <div class="cart-single-product-first-col">
            <button onclick="removeCartItems({{ $id }})" type="button" class="cart-single-product-remove" style="cursor: pointer">
                <i class="fa fa-trash"></i>
            </button>
        </div>
        <div class="checkout-order-review-info">
            <span class="cart-single-product-title">{{ $details['name'] }}</span>
            <div class="checkout-order-varient-group">

                @if ($details['color_id'])
                    @php
                        $colorInfo = DB::table('colors')
                            ->where('id', $details['color_id'])
                            ->first();
                    @endphp
                    @if ($colorInfo)
                        <div class="c-order-varient-single">
                            <span>Color: <strong>{{ $colorInfo ? $colorInfo->name : '' }}</strong></span>
                        </div>
                    @endif
                @endif

                @if ($details['size_id'])
                    @php
                        $sizeInfo = DB::table('product_sizes')
                            ->where('id', $details['size_id'])
                            ->first();
                    @endphp
                    @if ($sizeInfo)
                        <div class="c-order-varient-single">
                            <span>Size: <strong>{{ $sizeInfo ? $sizeInfo->name : '' }}</strong></span>
                        </div>
                    @endif
                @endif

            </div>
        </div>
        <div class="checkout-order-qty-price">
            <div class="checkout-order-qty">
                <span>Qty:</span>

                <div class="quantity__box minicart__quantity">
                    <button type="button" class="quantity__value decrease qty-left-minus" data-id="{{ $id }}" data-type="minus" data-field="">-</button>
                    <input type="number" class="quantity__number qty-input" value="{{ $details['quantity'] }}"/>
                    <button type="button" class="quantity__value increase qty-right-plus" data-id="{{ $id }}" data-type="plus" data-field="">+</button>
                </div>
            </div>
            @php
                $checkoutUnitPrice = $details['discount_price'] > 0 ? $details['discount_price'] : $details['price'];
            @endphp
            <span class="checkout-order-price">Price:<strong>{{ number_format($checkoutUnitPrice * $details['quantity'], 2) }} BDT</strong></span>
        </div>
    </div>
    @endforeach
@endif
