<section class="banner-section">
    <div class="container-fluid-lg">
        <div class="row gy-lg-0 gy-3">

            @foreach($bottomBanners as $bottomBanner)
            <div class="col-lg-6">
                <div class="banner-contain-3 hover-effect">
                    <div>
                        <img src="{{url(env('ADMIN_URL')."/".$bottomBanner->image)}}" class="bg-img blur-up lazyload" alt="" />
                        <div class="banner-detail banner-detail-2 text-dark p-center-left w-75 banner-p-sm position-relative mend-auto">
                            <div>
                                <h2 class="text-great fw-normal text-danger" @if($bottomBanner->sub_title_color) style="color: {{$bottomBanner->sub_title_color}}" @endif>
                                    {{$bottomBanner->sub_title}}
                                </h2>
                                <h3 class="mb-1 fw-bold" @if($bottomBanner->title_color) style="color: {{$bottomBanner->title_color}}" @endif>
                                    {{$bottomBanner->title}}
                                </h3>
                                <h4 class="text-content" @if($bottomBanner->description_color) style="color: {{$bottomBanner->description_color}}" @endif>{{$bottomBanner->description}}</h4>
                                <a href="{{$bottomBanner->btn_link}}" class="btn btn-md theme-bg-color text-white mt-sm-3 mt-1 fw-bold mend-auto" style="width: 120px; @if($bottomBanner->btn_color) color: {{$bottomBanner->btn_color}} @endif">
                                    {{$bottomBanner->btn_text}}
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
