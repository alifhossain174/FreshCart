<!-- Banner Section Start -->
<section class="banner-section banner-small ratio_65">
    <div class="container-fluid-lg">
        <div class="slider-4-banner no-arrow slick-height">

            @foreach($topBanners as $topBanner)
            <div>
                <div class="banner-contain-3 hover-effect">
                    <a href="javascript:void(0)">
                        <img src="{{env('ADMIN_URL')."/".$topBanner->image}}" class="img-fluid bg-img" alt="" />
                    </a>
                    <div class="banner-detail p-center-left w-75 banner-p-sm mend-auto">
                        <div>
                            <h5 class="fw-light mb-2" @if($topBanner->sub_title_color) style="color: {{$topBanner->sub_title_color}}" @endif>{{$topBanner->sub_title}}</h5>
                            <h4 class="fw-bold mb-0" @if($topBanner->title_color) style="color: {{$topBanner->title_color}}" @endif>{{$topBanner->title}}</h4>
                            <button onclick="location.href = '{{$topBanner->btn_link}}';" class="btn shop-now-button mt-3 ps-0 mend-auto theme-color fw-bold" @if($topBanner->btn_color) style="color: {{$topBanner->btn_color}} !important" @endif>
                                {{$topBanner->btn_text}} <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>
<!-- Banner Section End -->
