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
    <meta property="og:title" content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ env('ADMIN_URL') . '/' . $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
    <!-- End Open Graph general (Facebook, Pinterest)-->
@endpush

@section('header_css')
    <style>
        nav.custome-pagination .pagination {
            justify-content: center !important;
        }
    </style>
@endsection


@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Blogs</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Blogs
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Start -->
    <section class="blog-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-4">
                <div class="col-xxl-9 col-xl-8 col-lg-7 order-lg-2">
                    <div class="row g-4 ratio_65">

                        @foreach ($blogs as $blog)
                        <div class="col-xxl-4 col-sm-6">
                            <div class="blog-box wow fadeInUp">
                                <div class="blog-image">
                                    <a href="{{url('blog/details')}}/{{$blog->slug}}">
                                        <img src="{{url(env('ADMIN_URL')."/".$blog->image)}}" class="bg-img blur-up lazyload" alt="" />
                                    </a>
                                </div>

                                <div class="blog-contain">
                                    <div class="blog-label">
                                        <span class="time">
                                            <i data-feather="clock"></i>
                                            <span>{{date('d M, Y', strtotime($blog->created_at))}}</span>
                                        </span>
                                        <span class="super">
                                            <i data-feather="user"></i>
                                            <span>{{env('APP_NAME')}}</span>
                                        </span>
                                    </div>
                                    <a href="{{url('blog/details')}}/{{$blog->slug}}">
                                        <h3>{{$blog->title}}</h3>
                                    </a>
                                    <button onclick="location.href='{{url('blog/details')}}/{{$blog->slug}}';" class="blog-button">
                                        Read More <i class="fa-solid fa-right-long"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <nav class="custome-pagination">
                        {{$blogs->links()}}
                    </nav>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-5 order-lg-1">
                    <div class="left-sidebar-box wow fadeInUp">
                        <div class="accordion left-accordion-box mt-0" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapseOne">
                                        Recent Post
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body pt-0">
                                        <div class="recent-post-box">

                                            <div class="recent-box">
                                                <a href="blog-detail.html" class="recent-image">
                                                    <img src="./assets/images/inner-page/blog/1.jpg"
                                                        class="img-fluid blur-up lazyload" alt="" />
                                                </a>

                                                <div class="recent-detail">
                                                    <a href="blog-detail.html">
                                                        <h5 class="recent-name">
                                                            Green onion knife and salad placed
                                                        </h5>
                                                    </a>
                                                    <h6>
                                                        25 Jan, 2022 <i data-feather="thumbs-up"></i>
                                                    </h6>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseTwo">
                                        Category
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body p-0">
                                        <div class="category-list-box">
                                            <ul>

                                                <li>
                                                    <a href="blog-list.html">
                                                        <div class="category-name">
                                                            <h5>Latest Recipes</h5>
                                                            <span>10</span>
                                                        </div>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseFour">
                                        Trending Products
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingFour">
                                    <div class="accordion-body">
                                        <ul class="product-list product-list-2 border-0 p-0">

                                            <li>
                                                <div class="offer-product">
                                                    <a href="shop-left-sidebar.html" class="offer-image">
                                                        <img src="./assets/images/vegetable/product/23.png"
                                                            class="blur-up lazyload" alt="" />
                                                    </a>

                                                    <div class="offer-detail">
                                                        <div>
                                                            <a href="shop-left-sidebar.html">
                                                                <h6 class="name">
                                                                    Meatigo Premium Goat Curry
                                                                </h6>
                                                            </a>
                                                            <span>450 G</span>
                                                            <h6 class="price theme-color">$ 70.00</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
