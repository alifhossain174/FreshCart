<!-- Product Fruit & Vegetables Section Start -->
<section class="product-section">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>{{$featuredCategories[0]->name}}</h2>
        </div>

        @php
            $products = DB::table('products')->where('category_id', $featuredCategories[0]->id)->inRandomOrder()->skip(0)->limit(20)->get();
        @endphp

        <div class="row">
            <div class="col-12">
                <div class="slider-7_1 arrow-slider img-slider">

                    @foreach ($products as $product)
                    <div>
                        @include('single_product')
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Fruit & Vegetables Section End -->
