<div class="product-box-4 wow fadeInUp">
    <div class="product-image product-image-2">
        <a href="{{url('product')}}/{{$product->slug}}">
            <img src="{{url('assets')}}/images/product-load.gif" data-src="{{url(env('ADMIN_URL')."/".$product->image)}}" class="lazy img-fluid blur-up lazyload w-100" alt="" />
        </a>

        <ul class="option">
            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View">
                <a href="javascript:void(0)" onclick="showQuickView('{{$product->slug}}')" data-bs-toggle="modal" data-bs-target="#view">
                    <i class="iconly-Show icli"></i>
                </a>
            </li>
            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                <a href="javascript:void(0)" class="notifi-wishlist">
                    <i class="iconly-Heart icli"></i>
                </a>
            </li>
            {{-- <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                <a href="compare.html">
                    <i class="iconly-Swap icli"></i>
                </a>
            </li> --}}
        </ul>
    </div>

    <div class="product-detail">

        @php
            $productReviews = DB::table('product_reviews')->where('product_id', $product->id)->count();
            $productRating = DB::table('product_reviews')->where('product_id', $product->id)->sum('rating');
        @endphp

        <ul class="rating">
            @if($productReviews > 0)
                @for ($i=1;$i<=round($productRating/$productReviews);$i++)
                <li><i data-feather="star" class="fill"></i></li>
                @endfor

                @for ($i=1;$i<=5-round($productRating/$productReviews);$i++)
                <li><i data-feather="star"></i></li>
                @endfor
            @else
                <li><i data-feather="star"></i></li>
                <li><i data-feather="star"></i></li>
                <li><i data-feather="star"></i></li>
                <li><i data-feather="star"></i></li>
                <li><i data-feather="star"></i></li>
            @endif
        </ul>

        <a href="{{url('product')}}/{{$product->slug}}">
            <h5 class="name text-title">{{$product->name}}</h5>
        </a>

        @php
            $variants = DB::table('product_variants')->where('product_id', $product->id)->get();
            $totalStockAllVariants = $product->stock;
            if($variants && count($variants) > 0){
                $variantMinDiscountPrice = 0;
                $variantMinPrice = 0;
                $variantMinDiscountPriceArray = array();
                $variantMinPriceArray = array();

                foreach ($variants as $variant) {
                    if($variant->discounted_price > 0){
                        $variantMinDiscountPriceArray[] = $variant->discounted_price;
                    }
                    if($variant->price > 0){
                        $variantMinPriceArray[] = $variant->price;
                    }
                    $totalStockAllVariants = $totalStockAllVariants + (int) $variant->stock;
                }

                $variantMinDiscountPrice = min($variantMinDiscountPriceArray);
                $variantMinPrice = min($variantMinPriceArray);
            }
        @endphp

        <h5 class="price theme-color">
            @if($variants && count($variants) > 0)
                @if($variantMinDiscountPrice > 0)
                    ৳{{number_format($variantMinDiscountPrice)}}
                    <del>৳{{number_format($variantMinPrice)}}</del>
                @else
                    ৳{{number_format($variantMinPrice)}}
                @endif
            @else
                @if($product->discount_price > 0)
                    ৳{{number_format($product->discount_price)}}
                    <del>৳{{number_format($product->price)}}</del>
                @else
                    ৳{{number_format($product->price)}}
                @endif
            @endif
        </h5>

        <div class="addtocart_btn">
            <button class="add-button addcart-button btn buy-button text-light" data-id="{{ $product->id }}">
                <i class="fa-solid fa-plus"></i>
            </button>
            <div class="qty-box qty-box-{{ $product->id }} cart_qty @if(isset(session()->get('cart')[$product->id]) && session()->get('cart')[$product->id]['quantity'] >= 1) open @endif">
                <div class="input-group">
                    <button type="button" class="btn qty-left-minus" data-type="minus" data-id="{{ $product->id }}" data-field=""><i class="fa fa-minus" aria-hidden="true"></i></button>
                    <input class="form-control input-number qty-input" id="cart_qty_{{$product->id}}" type="text" name="quantity" value="{{ isset(session()->get('cart')[$product->id]) ? session()->get('cart')[$product->id]['quantity'] : 1 }}" />
                    <button type="button" class="btn qty-right-plus" data-type="plus" data-id="{{ $product->id }}" data-field=""><i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
