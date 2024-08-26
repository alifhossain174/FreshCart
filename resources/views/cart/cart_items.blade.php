@if(session('cart') && is_array(session('cart')) && count(session('cart')) > 0)
    @foreach(session('cart') as $id => $details)
    <tr class="product-box-contain">
        <td class="product-detail">
            <div class="product border-0">
                <a href="{{ url('product') }}/{{ $details['slug'] }}" class="product-image">
                    <img src="{{ url(env('ADMIN_URL')."/".$details['image']) }}" class="img-fluid blur-up lazyload" alt="" />
                </a>
                <div class="product-detail">
                    <ul>
                        <li class="name">
                            <a href="{{ url('product') }}/{{ $details['slug'] }}">{{substr($details['name'], 0, 12)}}..</a>
                        </li>

                        <li class="text-content">
                            @php
                                $storeName = env('APP_NAME');
                                $productInfo = DB::table('products')->where('id', $id)->first();
                                if($productInfo && $productInfo->store_id){
                                    $storeInfo = DB::table('stores')->where('id', $productInfo->store_id)->first();
                                    if($storeInfo){
                                        $storeName = $storeInfo->store_name;
                                    }
                                }
                            @endphp
                            @if($details['color_id'] && $colorInfo = DB::table('colors')->where('id', $details['color_id'])->first()) <span class="color__variant d-block" style="font-size: 14px"><b>Color:</b> {{$colorInfo->name}}</span> @endif
                            @if($details['size_id'] && $sizeInfo = DB::table('product_sizes')->where('id', $details['size_id'])->first()) <span class="color__variant d-block" style="font-size: 14px"><b>Size:</b> {{$sizeInfo->name}}</span> @endif
                            <span class="d-block"><span class="text-title">Sold By:</span> {{$storeName}}</span>
                        </li>

                        <li class="text-content">
                            <span class="text-title">Quantity</span> - {{$details['quantity']}}
                        </li>
                    </ul>
                </div>
            </div>
        </td>

        <td class="price">
            <h4 class="table-title text-content">Price</h4>

            @if($details['discount_price'] > 0)
                <h5>৳{{$details['discount_price']}}<del class="text-content"><small>৳{{$details['price']}}</small></del></h5>
            @else
                <h5>৳{{$details['price']}}</h5>
            @endif

            @if($details['discount_price'] > 0)
            <h6 class="theme-color">Save : ৳{{$details['price']-$details['discount_price']}}</h6>
            @endif
        </td>

        <td class="quantity">
            <h4 class="table-title text-content">Qty</h4>
            <div class="quantity-price">
                <div class="cart_qty">
                    <div class="input-group">
                        <button type="button" class="btn qty-left-minus" data-type="minus" data-field="" data-id="{{$id}}">
                            <i class="fa fa-minus ms-0" aria-hidden="true"></i>
                        </button>
                        <input class="form-control input-number qty-input" type="text" name="quantity" value="{{$details['quantity']}}" />
                        <button type="button" class="btn qty-right-plus" data-type="plus" data-field="" data-id="{{$id}}">
                            <i class="fa fa-plus ms-0" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </td>

        <td class="subtotal">
            <h4 class="table-title text-content">Total</h4>
            <h5>
                @if($details['discount_price'] > 0 && $details['discount_price'] < $details['price'])
                ৳{{$details['discount_price']*$details['quantity']}}
                @else
                ৳{{$details['price']*$details['quantity']}}
                @endif
            </h5>
        </td>

        <td>
            <h4 class="table-title text-content">Action</h4>
            <a style="font-weight: 400; font-size: 15px; color: #bf2020; text-decoration: underline;" class="sidebar-product-remove" href="javascript:void(0)" data-id="{{$id}}">Remove</a>
        </td>
    </tr>
    @endforeach
@else
    <tr class="product-box-contain">
        <td colspan="5" class="text-center"><h5>No items in Cart !</h5></td>
    </tr>
@endif
