<section class="product-list-section section-b-space">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Related Products</h2>
            <span class="title-leaf">
                <svg class="icon-width">
                    <use xlink:href="{{url('assets')}}/svg/leaf.svg#leaf"></use>
                </svg>
            </span>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="slider-6_1 product-wrapper">
                    @foreach($relatedProducts as $product)
                    <div>
                        @include('single_product')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
