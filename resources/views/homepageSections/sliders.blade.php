<section class="home-section-2 home-section-bg pt-0 overflow-hidden">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="slider-animate">

                    @foreach ($sliders as $slider)
                    <div class="home-contain rounded-0 p-0">
                        <img src="{{env('ADMIN_URL')."/".$slider->image}}" class="img-fluid bg-img blur-up lazyload" alt="" />
                        <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                            <div class="container-fluid-lg w-100">
                                <h6 class="ls-expanded theme-color text-uppercase" @if($slider->sub_title_color) style="color: {{$slider->sub_title_color}}" @endif>{{$slider->sub_title}}</h6>
                                <h1 class="heding-2" @if($slider->title_color) style="color: {{$slider->title_color}}" @endif>{{$slider->title}}</h1>
                                <h5 class="text-content" @if($slider->description_color) style="color: {{$slider->description_color}}" @endif>{{$slider->description}}</h5>
                                <button class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 " onclick="location.href='{{$slider->btn_link}}'" @if($slider->btn_color) style="color: {{$slider->btn_color}} !important" @endif>
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
