<div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
    <div class="right-sidebar-box">
        @if ($product->store_id)
            @include('product_details.vendor_info')
        @endif
        @include('product_details.you_may_like')
    </div>
</div>
