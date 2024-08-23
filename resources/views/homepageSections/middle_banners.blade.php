<section class="banner-section">
    <div class="container-fluid-lg">
        <div class="row gy-lg-0 gy-3">

            @foreach($middleBanners as $middleBanner)
            <div class="col-lg-6">
                <div class="banner-contain-3 hover-effect">
                    <div>
                        <img src="{{url(env('ADMIN_URL')."/".$middleBanner->image)}}" class="bg-img blur-up lazyload" alt="" />
                        <div class="banner-detail banner-detail-2 text-dark p-center-left w-75 banner-p-sm position-relative mend-auto">
                            <div>
                                <h2 class="text-great fw-normal text-danger" @if($middleBanner->sub_title_color) style="color: {{$middleBanner->sub_title_color}}" @endif>
                                    {{$middleBanner->sub_title}}
                                </h2>
                                <h3 class="mb-1 fw-bold" @if($middleBanner->title_color) style="color: {{$middleBanner->title_color}}" @endif>
                                    {{$middleBanner->title}}
                                </h3>
                                <h4 class="text-content" @if($middleBanner->description_color) style="color: {{$middleBanner->description_color}}" @endif>{{$middleBanner->description}}</h4>
                                <a href="{{$middleBanner->btn_link}}" class="btn btn-md theme-bg-color text-white mt-sm-3 mt-1 fw-bold mend-auto" style="width: 120px; @if($middleBanner->btn_color) color: {{$middleBanner->btn_color}} @endif">
                                    {{$middleBanner->btn_text}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
