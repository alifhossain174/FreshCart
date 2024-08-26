<div class="summery-header">
    <h3>Cart Total</h3>
</div>

<div class="summery-contain">
    <ul>
        @if(session('cart') && is_array(session('cart')) && count(session('cart')) > 0)
            @foreach(session('cart') as $id => $details)
                <li>
                    <h4><label>{{$details['quantity']}} × {{ substr($details['name'], 0, 15) }}..</label></h4>
                    <h4 class="price">
                        @if($details['discount_price'] > 0 && $details['discount_price'] < $details['price'])
                        ৳ {{$details['discount_price']*$details['quantity']}}
                        @else
                        ৳ {{$details['price']*$details['quantity']}}
                        @endif
                    </h4>
                </li>
            @endforeach
        @endif
    </ul>
</div>

<ul class="summery-total">
    <li class="list-total border-top-0">
        <h4>Total (BDT)</h4>
        @php $cartTotal = 0 @endphp
        @foreach((array) session('cart') as $id => $details)
            @php
                $cartTotal += ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity']
            @endphp
        @endforeach
        <h4 class="price theme-color">৳ {{number_format($cartTotal)}}</h4>
    </li>
</ul>

<div class="button-group cart-button">
    <ul>
        <li>
            <button onclick="location.href = '{{url('/checkout')}}';"
                class="btn btn-animation proceed-btn fw-bold">
                Process To Checkout
            </button>
        </li>

        <li>
            <button onclick="location.href = '{{url('/')}}';"
                class="btn btn-light shopping-button text-dark">
                <i class="fa-solid fa-arrow-left-long"></i>Return To
                Shopping
            </button>
        </li>
    </ul>
</div>
