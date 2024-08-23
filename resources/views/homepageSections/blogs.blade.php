<!-- Blog Section Start -->
<section class="blog-section section-b-space">
    <div class="container-fluid-lg">
        <div class="title title-4">
            <h2>Blog</h2>
        </div>

        <div class="slider-3-blog arrow-slider slick-height">

            @foreach($blogs as $blog)
            <div>
                <div class="blog-box ratio_45">
                    <div class="blog-box-image">
                        <a href="{{url('blog/details')}}/{{$blog->slug}}">
                            <img src="{{url(env('ADMIN_URL')."/".$blog->image)}}" class="blur-up lazyload bg-img" alt="" />
                        </a>
                    </div>

                    <div class="blog-detail">
                        <label>{{$blog->title}}</label>
                        <a href="{{url('blog/details')}}/{{$blog->slug}}">
                            <h3>{{$blog->short_description}}</h3>
                        </a>
                        <h5 class="text-content">{{env('APP_NAME')}} - {{date("d M, Y", strtotime($blog->created_at))}}</h5>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
<!-- Blog Section End -->
