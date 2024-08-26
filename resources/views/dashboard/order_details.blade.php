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
        .order-d-info-single-card-data-list li span{
            width: 20%;
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

                    <div class="order-details-area mgTop24">
                        <div class="order-details-inner">
                            <div class="dashboard-head-widget style-2">
                                <h5 class="dashboard-head-widget-title">Order details</h5>
                                <div class="dashboard-head-widget-btn">
                                    <a class="theme-btn secondary-btn icon-right" href="{{url('my/orders')}}"><i class="fi-rr-arrow-left"></i>Back to orders</a>
                                </div>
                            </div>
                            <div class="order-details-inner">
                                <div class="order-details-information">
                                    <div class="order-details-info-head">
                                        <div class="order-details-info-order-id">
                                            <h4 class="order-details-info-order-id-parent">
                                                Order NO <span>#{{$order->order_no}}</span>

                                                @if($order->order_status == 0)
                                                    <div class="order-details-info-status" style="background: var(--warning-color) !important;">pending</div>
                                                @elseif($order->order_status == 1)
                                                    <div class="order-details-info-status" style="background: var(--primary-color) !important;">Approved</div>
                                                @elseif($order->order_status == 2)
                                                    <div class="order-details-info-status" style="background: var(--hints-color) !important;">Intransit</div>
                                                @elseif($order->order_status == 3)
                                                    <div class="order-details-info-status" style="background: var(--success-color) !important;">Delivered</div>
                                                @else
                                                    <div class="order-details-info-status" style="background: var(--alert-color) !important;">Cancelled</div>
                                                @endif

                                            </h4>
                                            <ul class="order-details-info-date-time">
                                                <li>{{date("F d, Y", strtotime($order->order_date))}}</li>
                                                <li>{{date("h:i A", strtotime($order->order_date))}}</li>
                                            </ul>
                                        </div>
                                        <div class="order-details-info-head-button">
                                            {{-- <a class="theme-btn secondary-btn icon-right" href="#">
                                                <i class="fi-rs-cloud-download"></i>
                                                Download invoice
                                            </a>
                                            <a class="theme-btn icon-right" href="#">
                                                <i class="fi fi-rr-shopping-cart-add"></i>
                                                Re-order products
                                            </a> --}}
                                        </div>
                                    </div>
                                    <div class="order-details-info-card-group">
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt="" src="{{url('user-dashboard-assets')}}/assets/img/icons/user.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Personal information
                                                </h6>
                                            </div>
                                            <ul class="order-d-info-single-card-data-list">
                                                <li>
                                                    <span>Name</span><strong>{{$order->username}}</strong>
                                                </li>
                                                <li>
                                                    <span>Email</span><strong>{{$order->user_email}}</strong>
                                                </li>
                                                <li>
                                                    <span>Phone</span><strong>{{$order->phone}}</strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt="" src="{{url('user-dashboard-assets')}}/assets/img/icons/shipping-box.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Shipping information
                                                </h6>
                                            </div>
                                            <ul class="order-d-info-single-card-data-list">
                                                <li><span>Address</span><strong>{{$order->shipping_address}}</strong></li>
                                                <li><span>District</span><strong>{{$order->shipping_city}} @if($order->shipping_post_code) - {{$order->shipping_post_code}}@endif</strong></li>
                                                <li><span>Thana</span><strong>{{$order->shipping_thana}}</strong></li>
                                            </ul>
                                        </div>
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt="" src="{{url('user-dashboard-assets')}}/assets/img/icons/track.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Delivery information
                                                </h6>
                                            </div>
                                            <ul class="order-d-info-single-card-data-list">
                                                <li>
                                                    <span>Address</span>
                                                    <strong>
                                                        {{$order->shipping_address}}, {{$order->shipping_city}} @if($order->shipping_post_code) - {{$order->shipping_post_code}}@endif, {{$order->shipping_thana}}
                                                    </strong>
                                                </li>
                                                <li>
                                                    <span>Method</span>
                                                    <strong>
                                                        @if($order->delivery_method == 1)
                                                        COD (Cash on delivery)
                                                        @else
                                                        Store Pickup
                                                        @endif
                                                    </strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt="#" src="{{url('user-dashboard-assets')}}/assets/img/icons/card-information.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Payment information
                                                </h6>
                                            </div>
                                            <ul class="order-d-info-single-card-data-list">
                                                <li>
                                                    <span>Status</span>
                                                    @if($order->payment_method == 1)
                                                        {{-- if cash on delivery then check delivered or not--}}
                                                        @if($order->order_status == 3)
                                                        <strong style="color: #34be82">Paid</strong>
                                                        @else
                                                        <strong style="color: var(--alert-color)">Unpaid</strong>
                                                        @endif
                                                    @else
                                                        @if($order->payment_status == 1)
                                                            <strong style="color: #34be82">Paid</strong>
                                                        @else
                                                            <strong style="color: var(--alert-color)">Unpaid</strong>
                                                        @endif
                                                    @endif

                                                </li>
                                                <li>
                                                    <span>Method</span>
                                                    @if($order->payment_method == 1)
                                                    <strong>Cash On Delivery</strong>
                                                    @endif
                                                    @if($order->payment_method == 2)
                                                    <strong>bKash</strong>
                                                    @endif
                                                    @if($order->payment_method == 3)
                                                    <strong>Nagad</strong>
                                                    @endif
                                                </li>
                                                <li>
                                                    <span>TRXN ID</span>

                                                    @if($order->payment_method == 1)
                                                        {{-- if cash on delivery then check delivered or not--}}
                                                        @if($order->order_status == 3)
                                                        <strong>{{$order->trx_id}}</strong>
                                                        @endif
                                                    @else
                                                        <strong>{{$order->trx_id}}</strong>
                                                    @endif

                                                </li>
                                                <li>
                                                    <span>Date</span>

                                                    @if($order->payment_method == 1)
                                                        {{-- if cash on delivery then check delivered or not--}}
                                                        @if($order->order_status == 3)
                                                        @php
                                                            $orderProgressInfo = DB::table('order_progress')->where('order_id', $order->id)->where('order_status', 3)->first();
                                                        @endphp
                                                        <strong>{{date("jS M, Y h:i A", strtotime($orderProgressInfo->created_at))}}</strong>
                                                        @endif
                                                    @else
                                                        <strong>{{date("jS M, Y h:i A", strtotime($order->order_date))}}</strong>
                                                    @endif

                                                </li>
                                            </ul>
                                        </div>
                                        <div class="order-d-info-single-card">
                                            <div class="order-d-info-single-card-head">
                                                <div class="order-d-info-single-card-head-icon">
                                                    <img alt="" src="{{url('user-dashboard-assets')}}/assets/img/icons/note.svg" />
                                                </div>
                                                <h6 class="order-d-info-single-card-title">
                                                    Special Notes
                                                </h6>
                                            </div>
                                            <p class="order-d-info-single-card-text">
                                                {{$order->order_note}}
                                            </p>
                                        </div>
                                        {{-- <div class="order-d-info-tracking-card">
                                            <div class="order-d-info-tracking-card-img">
                                                <img alt="" src="{{url('user-dashboard-assets')}}/assets/img/track-image.svg" />
                                            </div>
                                            <div class="order-d-info-tracking-card-content">
                                                <h6>Track your order instantly!</h6>
                                                <a class="theme-btn" href="{{url('track/my/order')}}/{{$order->order_no}}">Track order</a>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order-summary">
                            <div class="order-summary-head">
                                <h4 class="order-summary-head-title">
                                    <img alt="#" src="{{url('frontend_assets')}}/assets/images/icons/humberger.svg" />Order summary
                                </h4>
                            </div>
                            <div class="table-responsive">
                                <table class="recent-order-table-data order-summary-table-data table">
                                    <thead>
                                        <tr>
                                            <th>Product name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItems as $item)
                                        <tr>
                                            <td>
                                                <a href="{{url('/product/details')}}/{{$item->product_slug}}" target="_blank" class="d-block">
                                                    <img alt="" src="{{env('ADMIN_URL')."/".$item->product_image}}" style="height: 30px; width: 30px; object-fit: contain;"/>
                                                    <span class="product-name">{{$item->name}}</span>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="product-price">{{number_format($item->product_price)}} BDT @if($item->unit_name)/ {{$item->unit_name}}@endif</span>
                                            </td>
                                            <td><span class="product-quantity">{{$item->qty}}</span></td>
                                            <td>
                                                <span class="product-total-price">{{number_format($item->product_price*$item->qty)}} BDT</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="order-summary-total">
                                <ul class="order-summary-total-list">
                                    <li>Subtotal<strong>{{number_format($order->sub_total)}} BDT</strong></li>
                                    <li>
                                        VAT/Tax<span>(0%)</span><strong>0 BDT</strong>
                                    </li>
                                    <li>
                                        Discount<strong>{{number_format($order->discount)}} BDT</strong>
                                    </li>
                                    <li>
                                        Delivery Cost<strong>{{number_format($order->delivery_fee)}} BDT</strong>
                                    </li>
                                    <li class="total-price">
                                        Total<strong>{{number_format($order->total)}} BDT</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
