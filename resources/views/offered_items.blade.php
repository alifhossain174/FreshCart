@foreach($offerProducts as $index => $offerProduct)
<div>
    <div class="product-image">
        <a href="product-left-thumbnail.html">
            <img src="{{url('assets')}}/images/product-load.gif" data-src="{{url(env('ADMIN_URL')."/".$offerProduct->image)}}" class="lazy img-fluid product-image blur-up lazyload" alt="" />
        </a>

        <ul class="option">
            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View">
                <a href="javascript:void(0)" onclick="showQuickView('{{$offerProduct->slug}}')" data-bs-toggle="modal"
                    data-bs-target="#view">
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

    <div class="product-detail text-center">
        @php
            $productReviews = DB::table('product_reviews')->where('product_id', $offerProduct->id)->count();
            $productRating = DB::table('product_reviews')->where('product_id', $offerProduct->id)->sum('rating');
        @endphp

        <ul class="rating justify-content-center">
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

        <a href="product-left-thumbnail.html">
            <h3 class="name w-100 mx-auto text-center">
                {{$offerProduct->name}}
            </h3>
        </a>

        @php
            $variants = DB::table('product_variants')->where('product_id', $offerProduct->id)->get();
            $totalStockAllVariants = $offerProduct->stock;
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

        <h3 class="price theme-color d-flex justify-content-center">
            @if($variants && count($variants) > 0)
                @if($variantMinDiscountPrice > 0)
                    ৳{{number_format($variantMinDiscountPrice)}}
                    <del class="delete-price">৳{{number_format($variantMinPrice)}}</del>
                @else
                    ৳{{number_format($variantMinPrice)}}
                @endif
            @else
                @if($offerProduct->discount_price > 0)
                    ৳{{number_format($offerProduct->discount_price)}}
                    <del class="delete-price">৳{{number_format($offerProduct->price)}}</del>
                @else
                    ৳{{number_format($offerProduct->price)}}
                @endif
            @endif
        </h3>
        <div class="progress custom-progressbar">
            <div class="progress-bar" style="width: 79%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h5 class="text-content">
            Stock : <span class="text-dark">{{$totalStockAllVariants}} items</span>
            <span class="ms-auto text-content">Hurry up offer end in</span>
        </h5>

        <?php
            $targetDate = $offerProduct->offer_end_time;
            $currentDate = new DateTime();
            $endDate = new DateTime($targetDate);
            $interval = $currentDate->diff($endDate);
            $days = $interval->format('%a');
            $hours = $interval->format('%h');
            $minutes = $interval->format('%i');
            $seconds = $interval->format('%s');
        ?>

        <div class="timer timer-2 ms-0 my-4" id="clockdiv-{{$index+1}}" data-hours="{{$hours}}" data-minutes="{{$minutes}}" data-seconds="{{$seconds}}">
            <ul class="d-flex justify-content-center" data-target-date="2024-11-25 15:30:00">
                <li>
                    <div class="counter">
                        <div class="days">
                            <h6>{{$days}}</h6>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="counter">
                        <div class="hours">
                            <h6>{{$hours}}</h6>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="counter">
                        <div class="minutes">
                            <h6>{{$minutes}}</h6>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="counter">
                        <div class="seconds">
                            <h6>{{$seconds}}</h6>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endforeach
