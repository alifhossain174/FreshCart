@extends('master')

@section('content')
    @include('homepageSections.sliders')
    @include('homepageSections.top_banners')
    @include('homepageSections.categories')
    @include('homepageSections.featured_category')
    @include('homepageSections.offers')
    @include('homepageSections.flagWithDeals')

    {{-- loop hobe --}}
    @include('homepageSections.featured_category')
    @include('homepageSections.featured_category')
    @include('homepageSections.middle_banners')
    {{-- loop hobe --}}

    @include('homepageSections.blogs')
    @include('homepageSections.feature')
@endsection
