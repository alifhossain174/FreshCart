@extends('master')

@section('header_css')
    <link rel="stylesheet" href="{{ url('frontend_assets') }}/css/user-pannel.css" />
@endsection

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
    <style>
        .single-order-status-card:last-child::after{
            background: none
        }
        .single-order-status-card:last-child::before{
            background: none
        }
    </style>
@endsection

@push('user_dashboard_menu')
    @include('dashboard.mobile_menu_offcanvus')
@endpush

@section('content')
    <section class="getcom-user-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="getcom-user-body-bg">
                        <img alt="" src="{{ url('frontend_assets') }}/assets/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('dashboard.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">

                    <div class="order-tracking-area">
                        <div class="dashboard-head-widget style-2" style="margin-top: 25px;">
                            <h5 class="dashboard-head-widget-title">Order tracking</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn secondary-btn icon-right" href="{{url('order/details')}}/{{$order->slug}}"><i class="fi-rr-arrow-left"></i>Back to details</a>
                            </div>
                        </div>
                        <div class="order-tracking-card-group">
                            <div class="single-order-tracking-card card-1">
                                <div class="order-tracking-card-icon">
                                    <img alt="#" src="{{url('frontend_assets')}}/assets/images/order-tracking/card-icon-1.svg">
                                </div>
                                <div class="order-tracking-card-info">
                                    <h6>#{{$order->order_no}}</h6>
                                    <p>Order number</p>
                                </div>
                            </div>
                            <div class="single-order-tracking-card card-2">
                                <div class="order-tracking-card-icon">
                                    <img alt="#" src="{{url('frontend_assets')}}/assets/images/order-tracking/card-icon-2.svg">
                                </div>
                                <div class="order-tracking-card-info">
                                    <h6>{{date("F d, Y", strtotime($order->estimated_dd))}}</h6>
                                    <p>Estimated delivery date</p>
                                </div>
                            </div>
                            <div class="single-order-tracking-card card-3">
                                <div class="order-tracking-card-icon">
                                    <img alt="#" src="{{url('frontend_assets')}}/assets/images/order-tracking/card-icon-3.svg">
                                </div>
                                <div class="order-tracking-card-info">
                                    <h6>{{$totalItems}} items</h6>
                                    <p>Total products</p>
                                </div>
                            </div>
                        </div>
                        <div class="order-status-area">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-12">
                                    <div class="order-status-section-head">
                                        <h4 class="order-status-s-head-title">Order status</h4>
                                        <div class="seperator-group">
                                            <span class="seperator-sm"></span><span class="seperator-big"></span><span class="seperator-sm"></span>
                                        </div>
                                    </div>
                                    <div class="order-status-card-group">

                                        @foreach ($orderProgress as $index => $status)

                                            @if($status->order_status == 0)
                                            <div class="single-order-status-card card-{{$index+1}}">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Order placed</h6>
                                                    <p>We have received your order</p>
                                                    <ul>
                                                        <li>{{date("d M, y", strtotime($status->created_at))}}</li>
                                                        <li>{{date("h:i:s a", strtotime($status->created_at))}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif

                                            @if($status->order_status == 1)
                                            <div class="single-order-status-card card-{{$index+1}}">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Order confirmed</h6>
                                                    <p>Your order has been confirmed</p>
                                                    <ul>
                                                        <li>{{date("d M, y", strtotime($status->created_at))}}</li>
                                                        <li>{{date("h:i:s a", strtotime($status->created_at))}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif

                                            @if($status->order_status == 2)
                                            <div class="single-order-status-card card-{{$index+1}}">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>On the way</h6>
                                                    <p>We are on the way to your destination</p>
                                                    <ul>
                                                        <li>{{date("d M, y", strtotime($status->created_at))}}</li>
                                                        <li>{{date("h:i:s a", strtotime($status->created_at))}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif

                                            @if($status->order_status == 3)
                                            <div class="single-order-status-card card-{{$index+1}}">
                                                <div class="order-status-card-icon">
                                                    <i class="fi-br-check"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Ready to Pickup/Delivery</h6>
                                                    <p>Your order is ready to pickup/Delivery</p>
                                                    <ul>
                                                        <li>{{date("d M, y", strtotime($status->created_at))}}</li>
                                                        <li>{{date("h:i:s a", strtotime($status->created_at))}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif

                                            @if($status->order_status == 4)
                                            <div class="single-order-status-card card-{{$index+1}}">
                                                <div class="order-status-card-icon-cross">
                                                    <i class="fi-br-cross"></i>
                                                </div>
                                                <div class="order-status-card-info">
                                                    <h6>Your Order is Cancelled</h6>
                                                    <p>We have cancelled your order</p>
                                                    <ul>
                                                        <li>{{date("d M, y", strtotime($status->created_at))}}</li>
                                                        <li>{{date("h:i:s a", strtotime($status->created_at))}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif

                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection
