@if ($product->store_id)
    @if (count($vendorProducts))
        @php
            $storeInfo = DB::table('stores')->where('id', $product->store_id)->first();
        @endphp

        <section class="product-list-section section-b-space">
            <div class="container-fluid-lg">
                <div class="title">
                    <h2>More Products from {{$storeInfo->store_name}}</h2>
                    <span class="title-leaf">
                        <svg class="icon-width">
                            <use xlink:href="{{url('assets')}}/svg/leaf.svg#leaf"></use>
                        </svg>
                    </span>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="slider-6_1 product-wrapper">
                            @foreach ($vendorProducts as $product)
                                <div>
                                    @include('single_product')
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
