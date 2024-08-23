<!-- Poster Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="slider-1 slider-animate product-wrapper no-arrow">

                    @foreach($shopBanners as $shopBanner)
                    <div>
                        <div class="banner-contain-2 hover-effect">
                            <img src="{{url(env('ADMIN_URL')."/".$shopBanner->image)}}" class="bg-img rounded-3 blur-up lazyload" alt="" />
                            <div
                                class="banner-detail p-center-right position-relative shop-banner ms-auto banner-small">
                                <div>
                                    <h2>{{$shopBanner->title}}</h2>
                                    <h3>{{$shopBanner->description}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Poster Section End -->
