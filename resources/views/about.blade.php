@extends('master')

@push('site-seo')
    @php
        $generalInfo = DB::table('general_infos')
            ->select(
                'meta_title',
                'meta_og_title',
                'meta_keywords',
                'meta_description',
                'meta_og_description',
                'meta_og_image',
                'company_name',
                'fav_icon',
            )
            ->where('id', 1)
            ->first();
    @endphp

    <meta name="keywords" content="{{ $generalInfo ? $generalInfo->meta_keywords : '' }}" />
    <meta name="description" content="{{ $generalInfo ? $generalInfo->meta_description : '' }}" />
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') }}">

    <title>
        @if ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }}
        @else
            {{ $generalInfo->company_name }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ env('ADMIN_URL') . '/' . $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
    <!-- End Open Graph general (Facebook, Pinterest)-->
@endpush

@section('content')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>About Us</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    About Us
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Fresh Vegetable Section Start -->
    <section class="fresh-vegetable-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="row gx-xl-5 gy-xl-0 g-3 ratio_148_1">
                <div class="col-xl-6 col-12">
                    <img src="{{url(env('ADMIN_URL')."/".$data->image)}}" class="img-fluid lazyload" alt="" />
                </div>

                <div class="col-xl-6 col-12">
                    <div class="fresh-contain p-center-left">
                        <div>
                            <div class="review-title">
                                <h4>{{$data->section_sub_title}}</h4>
                                <h2>{{$data->section_title}}</h2>
                            </div>

                            <div class="delivery-list">
                                {!! $data->section_description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fresh Vegetable Section End -->


    <!-- store Section Start -->
    <section class="team-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="about-us-title text-center">
                <h4 class="text-content">Our Partners in Business</h4>
                <h2 class="center">{{env('APP_NAME')}}'s Stores</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-user product-wrapper">

                        @foreach($stores as $store)
                        <div>
                            <div class="team-box">
                                <div class="team-iamge" style="height: 230px; width: 230px; background: url('{{url(env('ADMIN_URL')."/".$store->store_banner)}}'); background-size: cover; background-repeat: no-repeat; background-position: center;">
                                    <img src="{{url(env('ADMIN_URL')."/".$store->store_logo)}}" style="height: 250px; width: 250px" class="img-fluid blur-up lazyload" alt="" />
                                </div>

                                <div class="team-name">
                                    <h3>{{$store->store_name}}</h3>
                                    <h5>Since {{date("M-Y", strtotime($store->created_at))}}</h5>
                                    <p>
                                        {{substr($store->store_description, 0, 120)}}..
                                    </p>
                                    <ul class="team-media">
                                        <li>
                                            <a href="{{url('shop')}}?store={{$store->slug}}" class="fb-bg" style="display: inline; padding: 8px 15px;">
                                                <i class="fa fa-share"></i> Visit Store
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- store Section End -->

    <!-- Review Section Start -->
    <section class="review-section section-lg-space">
        <div class="container-fluid">
            <div class="about-us-title text-center">
                <h4 class="text-content">Latest Testimonals</h4>
                <h2 class="center">What people say</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-4-half product-wrapper">

                        @foreach($testimonials as $testimonial)
                        <div>
                            <div class="reviewer-box">
                                <i class="fa-solid fa-quote-right"></i>
                                <div class="product-rating">
                                    <ul class="rating">
                                        @for($i=1; $i<=$testimonial->rating; $i++)
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        @endfor
                                        @for($i=1; $i<=(5-$testimonial->rating); $i++)
                                        <li>
                                            <i data-feather="star"></i>
                                        </li>
                                        @endfor
                                    </ul>
                                </div>
                                <p>{{$testimonial->description}}</p>

                                <div class="reviewer-profile">
                                    <div class="reviewer-image">
                                        <img src="{{url(env('ADMIN_URL')."/".$testimonial->customer_image)}}" class="blur-up lazyload" alt="" />
                                    </div>

                                    <div class="reviewer-name">
                                        <h4>{{$testimonial->customer_name}}</h4>
                                        <h6>{{$testimonial->designation}}</h6>
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
    <!-- Review Section End -->

    <!-- Blog Section Start -->
    <section class="section-lg-space">
        <div class="container-fluid-lg">
            <div class="about-us-title text-center">
                <h4 class="text-content">Our Blog</h4>
                <h2 class="center">Our Latest Blog</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-5 ratio_87">

                        @foreach($blogs as $blog)
                        <div>
                            <div class="blog-box">
                                <div class="blog-box-image">
                                    <div class="blog-image">
                                        <a href="{{url('blog/details')}}/{{$blog->slug}}" class="rounded-3">
                                            <img src="{{url(env('ADMIN_URL')."/".$blog->image)}}" class="bg-img blur-up lazyload"
                                                alt="" />
                                        </a>
                                    </div>
                                </div>

                                <a href="{{url('blog/details')}}/{{$blog->slug}}" class="blog-detail d-block">
                                    <h6>{{date("d M, Y", strtotime($blog->created_at))}}</h6>
                                    <h5 style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">{{$blog->title}}</h5>
                                </a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
