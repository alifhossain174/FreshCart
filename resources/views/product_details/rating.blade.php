@php
    $productReviews = DB::table('product_reviews')->where('product_id', $product->id)->count();
    $productRating = DB::table('product_reviews')->where('product_id', $product->id)->sum('rating');
@endphp

<div class="product-rating custom-rate">
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
    <span class="review">{{$productReviews}} Customer Review</span>
</div>
