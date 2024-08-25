<div class="product-left-box">
    <div class="row g-2">
        <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
            <div class="product-main-2 no-arrow">

                @if($variants && count($variants) > 0)
                    @foreach ($variants as $variant)
                        @if($variant->image)
                        <div>
                            <div class="slider-image">
                                <img src="{{env('ADMIN_URL')."/productImages/".$variant->image}}" id="img-1" data-zoom-image="{{env('ADMIN_URL')."/productImages/".$variant->image}}" class="img-fluid image_zoom_cls-0 blur-up lazyload" alt="" />
                            </div>
                        </div>
                        @endif
                    @endforeach
                @elseif ($productMultipleImages && count($productMultipleImages) > 0)
                    @foreach ($productMultipleImages as $image)
                    <div>
                        <div class="slider-image">
                            <img src="{{env('ADMIN_URL')."/productImages/".$image->image}}" id="img-1" data-zoom-image="{{env('ADMIN_URL')."/productImages/".$image->image}}" class="img-fluid image_zoom_cls-0 blur-up lazyload" alt="" />
                        </div>
                    </div>
                    @endforeach
                @else
                    <div>
                        <div class="slider-image">
                            <img src="{{env('ADMIN_URL')."/".$product->image}}" id="img-1" data-zoom-image="{{env('ADMIN_URL')."/".$product->image}}" class="img-fluid image_zoom_cls-0 blur-up lazyload" alt="" />
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
            <div class="left-slider-image-2 left-slider no-arrow slick-top">

                @if($variants && count($variants) > 0)
                    @foreach ($variants as $variant)
                        @if($variant->image)
                        <div>
                            <div class="sidebar-image">
                                <img src="{{env('ADMIN_URL')."/productImages/".$variant->image}}" class="img-fluid blur-up lazyload" alt="" />
                            </div>
                        </div>
                        @endif
                    @endforeach
                @elseif ($productMultipleImages && count($productMultipleImages) > 0)
                    @foreach ($productMultipleImages as $image)
                        <div>
                            <div class="sidebar-image">
                                <img src="{{env('ADMIN_URL')."/productImages/".$image->image}}" class="img-fluid blur-up lazyload" alt="" />
                            </div>
                        </div>
                    @endforeach
                @else
                    <div>
                        <div class="sidebar-image">
                            <img src="{{env('ADMIN_URL')."/".$product->image}}" class="img-fluid blur-up lazyload" alt="" />
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
