<!-- Deal Section Start -->
<section class="product-section product-section-3">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Top Selling Items</h2>
        </div>
        <div class="row g-sm-4 g-3">
            <div class="col-xxl-4 col-lg-5 order-lg-2">
                <div class="product-bg-image wow fadeInUp">
                    <div class="product-title product-warning">
                        <h2>Special Offer</h2>
                    </div>

                    <div class="product-box-4 product-box-3 rounded-0">
                        <div class="deal-box">
                            <div class="circle-box">
                                <div class="shape-circle">
                                    <img src="{{url('assets')}}/images/grocery/circle.svg" class="blur-up lazyload"
                                        alt="" />
                                    <div class="shape-text">
                                        <h6>
                                            Hot <br />
                                            Deal
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="top-selling-slider product-arrow">
                            @include('offered_items')
                        </div>
                    </div>
                </div>
            </div>

            @php
                $flagWiseProducts = DB::table('products')->where('status', 1)->where('flag_id', $flags[0]->id)->skip(0)->limit(20)->get();
            @endphp

            <div class="col-xxl-8 col-lg-7 order-lg-1">
                <div class="slider-5_2 img-slider">

                    @for($i = 0; $i < count($flagWiseProducts); $i += 2)
                        <div>
                            {{-- Include the first product in this iteration --}}
                            @include('single_product', ['product' => $flagWiseProducts[$i]])

                            {{-- Include the second product if it exists --}}
                            @if(isset($flagWiseProducts[$i + 1]))
                                @include('single_product', ['product' => $flagWiseProducts[$i + 1]])
                            @endif
                        </div>
                    @endfor

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Deal Section End -->
