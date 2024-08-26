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

@section('header_css')
    <style>
        nav.custome-pagination ul.pagination {
            justify-content: center !important;
        }
    </style>
@endsection

@section('content')

    @include('vendors.breadcrumb')

    <!-- Grid Section Start -->
    <section class="seller-grid-section">
        <div class="container-fluid-lg">
            <div class="row g-4">

                @forEach($stores as $store)
                <div class="col-xxl-4 col-md-6">
                    <div class="seller-grid-box seller-grid-box-1">
                        <div class="grid-image">
                            <div class="image">
                                <img src="{{url(env('ADMIN_URL')."/".$store->store_logo)}}" class="img-fluid" alt="" />
                            </div>

                            <div class="contain-name">
                                <div>
                                    <div class="since-number">
                                        <h6>Since {{date("M-Y", strtotime($store->created_at))}}</h6>
                                        @php
                                            $vendorProductsReviews = DB::table('product_reviews')
                                                                ->join('products', 'product_reviews.product_id', 'products.id')
                                                                ->where('products.store_id', $store->id)
                                                                ->get();

                                            $vendorProductsRating = DB::table('product_reviews')
                                                                ->join('products', 'product_reviews.product_id', 'products.id')
                                                                ->where('products.store_id', $store->id)
                                                                ->sum('rating');
                                            $totalProducts = DB::table('products')->where('store_id', $store->id)->count();
                                            $vendorProducts = DB::table('products')->where('store_id', $store->id)->orderBy('id', 'desc')->skip(0)->limit(8)->get();
                                        @endphp

                                        <div class="product-rating">
                                            <ul class="rating">
                                                @if(count($vendorProductsReviews) > 0)
                                                    @for ($i=1;$i<=round($vendorProductsRating/count($vendorProductsReviews));$i++)
                                                    <li><i data-feather="star" class="fill"></i></li>
                                                    @endfor

                                                    @for ($i=1;$i<=5-round($vendorProductsRating/count($vendorProductsReviews));$i++)
                                                    <li><i data-feather="star"></i></li>
                                                    @endfor
                                                @else
                                                    <li><i data-feather="star"></i></li>
                                                    <li><i data-feather="star"></i></li>
                                                    <li><i data-feather="star"></i></li>
                                                    <li><i data-feather="star"></i></li>
                                                    <li><i data-feather="star"></i></li>
                                                @endif
                                            </ul>
                                            <h6 class="theme-color ms-2">({{count($vendorProductsReviews)}})</h6>
                                        </div>
                                    </div>
                                    <h3>{{$store->store_name}}</h3>
                                </div>
                                <label class="product-label">{{$totalProducts}} Products</label>
                            </div>
                        </div>

                        <div class="grid-contain">
                            <div class="seller-contact-details">
                                <div class="saller-contact">
                                    <div class="seller-icon">
                                        <i class="fa-solid fa-map-pin"></i>
                                    </div>

                                    <div class="contact-detail">
                                        <h5>Description: <span>{{substr($store->store_description, 0, 120)}}..</span></h5>
                                    </div>
                                </div>
                            </div>

                            <div class="seller-category">
                                <button onclick="location.href = '{{url('shop')}}?store={{$store->slug}}';"
                                    class="btn btn-sm theme-bg-color text-white fw-bold">
                                    Visit Store
                                    <i class="fa-solid fa-arrow-right-long ms-2"></i>
                                </button>
                                <ul class="product-image">
                                    @foreach($vendorProducts as $vendorProduct)
                                    <li style="overflow: hidden;">
                                        <img src="{{url(env('ADMIN_URL')."/".$vendorProduct->image)}}" class="img-fluid" alt="" />
                                    </li>
                                    @endforeach
                                    {{-- <li>+{{$totalProducts}}</li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <nav class="custome-pagination">
                {{$stores->links()}}
            </nav>

        </div>
    </section>
    <!-- Grid Section End -->

    @include('vendors.newletter')

@endsection
