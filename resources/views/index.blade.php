@extends('master')

@section('content')
    @include('homepageSections.sliders')
    @include('homepageSections.top_banners')
    @include('homepageSections.categories')

    @if(isset($featuredCategories[0]))
        @include('homepageSections.top_featured_category')
    @endif

    @if(count($promoOffers) > 0)
        @include('homepageSections.offers')
    @endif

    @include('homepageSections.flagWithDeals')

    {{-- loop hobe --}}
    {{-- @include('homepageSections.featured_category')
    @include('homepageSections.featured_category')
    @include('homepageSections.middle_banners') --}}
    {{-- loop hobe --}}

    @include('homepageSections.blogs')
    @include('homepageSections.feature')
@endsection
