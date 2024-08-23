<div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">

    @if ($products->total() > 0)
        @foreach ($products as $product)
        <div>
            @include('single_product')
        </div>
        @endforeach
    @else
        <h5 class="w-100 text-center" style="padding: 15px; font-weight: 600; font-size: 18px;">Sorry! No Products Found</h5>
    @endif

</div>

<nav class="custome-pagination">
    {{$products->links()}}
</nav>
