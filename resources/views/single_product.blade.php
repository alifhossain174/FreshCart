<div class="product-box-4 wow fadeInUp">
    <div class="product-image product-image-2">
        <a href="{{url('product')}}/{{$product->slug}}">
            <img src="{{url('assets')}}/images/product-load.gif" data-src="{{url(env('ADMIN_URL')."/".$product->image)}}" class="lazy img-fluid blur-up lazyload" alt="" />
        </a>

        <ul class="option">
            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                    <i class="iconly-Show icli"></i>
                </a>
            </li>
            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                <a href="javascript:void(0)" class="notifi-wishlist">
                    <i class="iconly-Heart icli"></i>
                </a>
            </li>
            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                <a href="compare.html">
                    <i class="iconly-Swap icli"></i>
                </a>
            </li>
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
            $variants = DB::table('product_variants')->select('discounted_price', 'price')->where('product_id', $product->id)->get();
            if($variants && count($variants) > 0){
                $variantMinDiscountPrice = 0;
                $variantMinPrice = 0;
                $variantMinDiscountPriceArray = array();
                $variantMinPriceArray = array();

                foreach ($variants as $variant) {
                    $variantMinDiscountPriceArray[] = $variant->discounted_price;
                    $variantMinPriceArray[] = $variant->price;
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
            <button class="add-button addcart-button btn buy-button text-light">
                <i class="fa-solid fa-plus"></i>
            </button>
            <div class="qty-box cart_qty">
                <div class="input-group">
                    <button type="button" class="btn qty-left-minus" data-type="minus"
                        data-field="">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                    <input class="form-control input-number qty-input" type="text"
                        name="quantity" value="1" />
                    <button type="button" class="btn qty-right-plus" data-type="plus"
                        data-field="">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
