<section class="home-section-2 home-section-bg pt-0 overflow-hidden">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="slider-animate">

                    @foreach ($sliders as $slider)
                    <div class="home-contain rounded-0 p-0">
                        <img src="{{env('ADMIN_URL')."/".$slider->image}}" class="img-fluid bg-img blur-up lazyload" alt="" />
                        <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                            <div class="container-fluid-lg">
                                <h6 class="ls-expanded theme-color text-uppercase">{{$slider->sub_title}}</h6>
                                <h1 class="heding-2">{{$slider->title}}</h1>
                                {{-- <h2 class="content-2">{{$slider->description}}</h2> --}}
                                <h5 class="text-content">{{$slider->description}}</h5>
                                <button class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto"
                                    onclick="location.href='{{$slider->btn_link}}'">
                                    {{$slider->btn_text}} <i class="fa-solid fa-arrow-right icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
