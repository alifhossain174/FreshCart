
@php
    $storeInfo = DB::table('stores')->where('id', $product->store_id)->first();
    $vendorInfo = DB::table('vendors')->where('id', $storeInfo->vendor_id)->first();

    $vendorProductsReviews = DB::table('product_reviews')
                        ->join('products', 'product_reviews.product_id', 'products.id')
                        ->where('products.store_id', $storeInfo->id)
                        ->get();

    $vendorProductsRating = DB::table('product_reviews')
                        ->join('products', 'product_reviews.product_id', 'products.id')
                        ->where('products.store_id', $storeInfo->id)
                        ->sum('rating');
@endphp

<div class="vendor-box" style="margin-bottom: 25px">
    <div class="verndor-contain">
        <div class="vendor-image">
            <img src="{{env('ADMIN_URL')."/".$storeInfo->store_logo}}" class="blur-up lazyload" alt="" />
        </div>

        <div class="vendor-name">
            <h5 class="fw-500">{{$storeInfo->store_name}}</h5>

            <div class="product-rating mt-1">
                <ul class="rating">
                    @if(count($vendorProductsReviews) > 0)
                        @for ($i=1;$i<=round($vendorProductsRating/count($vendorProductsReviews));$i++)
                        <li><i data-feather="star" class="fill"></i></li>
                        @endfor

                        @for ($i=1;$i<=5-round($vendorProductsRating/count($vendorProductsReviews));$i++)
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
                <span>({{count($vendorProductsReviews)}} Reviews)</span>
            </div>
        </div>
    </div>

    <p class="vendor-detail">
        {{$storeInfo->store_description}}
    </p>
</div>
