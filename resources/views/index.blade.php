@extends('master')

@push('site-seo')
    @php
        $generalInfo = DB::table('general_infos')->select('meta_title', 'meta_og_title', 'meta_keywords', 'meta_description', 'meta_og_description', 'meta_og_image', 'company_name', 'email', 'fav_icon')->where('id', 1)->first();
    @endphp

    <meta name="keywords" content="{{$generalInfo ? $generalInfo->meta_keywords : ''}}" />
    <meta name="description" content="{{$generalInfo ? $generalInfo->meta_description : ''}}" />
    <meta name="author" content="{{$generalInfo ? $generalInfo->company_name : ''}}" />
    <meta name="copyright" content="{{$generalInfo ? $generalInfo->company_name : ''}}">
    <meta name="url" content="{{env('APP_URL')}}">

    <title>@if($generalInfo && $generalInfo->meta_title) {{$generalInfo->meta_title}} @else {{$generalInfo->company_name}} @endif</title>
    @if($generalInfo && $generalInfo->fav_icon)<link rel="icon" href="{{env('ADMIN_URL')."/".($generalInfo->fav_icon)}}" type="image/x-icon"/>@endif

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title" content="@if($generalInfo && $generalInfo->meta_og_title) {{$generalInfo->meta_og_title}} @else {{$generalInfo->company_name}} @endif"/>
    <meta property="og:type" content="Ecommerce"/>
    <meta property="og:url" content="{{env('APP_URL')}}"/>
    <meta property="og:image" content="{{env('ADMIN_URL')."/".($generalInfo->meta_og_image)}}"/>
    <meta property="og:site_name" content="{{$generalInfo ? $generalInfo->company_name : ''}}"/>
    <meta property="og:description" content="{{$generalInfo->meta_og_description}}"/>
    <!-- End Open Graph general (Facebook, Pinterest)-->
@endpush

@section('content')

    @include('homepageSections.sliders')
    @include('homepageSections.top_banners')
    @include('homepageSections.categories')

    @foreach($featuredCategories as $featuredCategory)
        @include('homepageSections.top_featured_category')
    @endforeach

    @if(count($promoOffers) > 0)
        @include('homepageSections.offers')
    @endif

    @if($flags && count($flags) > 0)
        @include('homepageSections.flagWithDeals')
    @endif


    @foreach($flags as $flagIndex => $flag)
        @if($flagIndex > 0)
            @if($flagIndex == 3)
                @include('homepageSections.middle_banners')
            @endif
            @if($flagIndex == 5)
                @include('homepageSections.bottom_banners')
            @endif
            @include('homepageSections.flag_wise_products')
        @endif
    @endforeach

    @include('homepageSections.blogs')

@endsection

@section('footer_js')
    <script src="{{ url('assets') }}/js/timer1.js"></script>
    <script src="{{ url('assets') }}/js/timer2.js"></script>
    <script src="{{ url('assets') }}/js/timer3.js"></script>
    <script src="{{ url('assets') }}/js/timer4.js"></script>
    <script src="{{ url('assets') }}/js/timer5.js"></script>
@endsection
