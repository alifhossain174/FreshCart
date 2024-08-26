@extends('master')

@push('site-seo')
    @php
        $generalInfo = DB::table('general_infos')
            ->select('meta_title', 'company_name', 'fav_icon')
            ->where('id', 1)
            ->first();
    @endphp
    <title>
        @if ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }}
        @else
            {{ $generalInfo->company_name }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" type="image/x-icon"/>
    @endif
@endpush

@section('header_css')
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/user-pannel.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/uicons.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/icofont.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/nice-select.css" />
    <style>
        .pagination{
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection


@push('user_dashboard_menu')
    @include('dashboard.mobile_menu_offcanvus')
@endpush

@section('content')
    <section class="getcom-user-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="getcom-user-body-bg">
                        <img alt="" src="{{ url('assets') }}/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('dashboard.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">

                    <div class="wishlist-page-area mgTop24">
                        <div class="dashboard-head-widget style-2">
                            <h5 class="dashboard-head-widget-title">Wishlist’s</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn secondary-btn" href="{{url('clear/all/wishlist')}}">Clear all</a>
                            </div>
                        </div>
                        <div class="wishlist-items-area" style="margin-top: 32px">
                            <div class="dashboard-wishlist-inner">

                                @if(count($wishlistedItems) > 0)
                                @foreach ($wishlistedItems as $wishlistedItem)
                                <div class="wishlist-card">
                                    <div class="wishlist-card-data">
                                        <div class="wishlist-card-img">
                                            <img alt="" src="{{env('ADMIN_URL')."/".$wishlistedItem->image}}" />
                                            <div class="wishlist-card-remove">
                                                <a href="{{url('remove/from/wishlist')}}/{{$wishlistedItem->product_slug}}" class="d-block">
                                                    <span><i class="fi-br-cross-small"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="wishlist-card-info">
                                            <h6>{{$wishlistedItem->name}}</h6>
                                            <p>{{$wishlistedItem->discount_price > 0 ? $wishlistedItem->discount_price : $wishlistedItem->price}} BDT<span>@if($wishlistedItem->unit_name)/{{$wishlistedItem->unit_name}}@endif</span></p>
                                        </div>
                                    </div>
                                    <div class="wishlist-card-btn">
                                        <a href="{{url('product/details')}}/{{$wishlistedItem->product_slug}}" target="_blank"><i class="fi-rr-arrow-right"></i></a>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <style>
                                    .dashboard-wishlist-inner{
                                        display: block;
                                    }
                                </style>
                                <h3 class="text-center">No Product in Wishlist</h3>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
