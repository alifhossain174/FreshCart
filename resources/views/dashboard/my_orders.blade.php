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
                    <div class="dashboard-my-order mgTop24">
                        <div class="dashboard-head-widget style-2">
                            <h5 class="dashboard-head-widget-title">My orders</h5>
                            <div class="dashboard-head-widget-select">
                                <span>Sort by:</span>
                                <form action="{{url('my/orders')}}" method="GET">
                                    <select aria-label="Show All Orders" class="form-select" name="order_status" onchange='this.form.submit()'>
                                        <option value="">Show All Orders</option>
                                        <option value="1" @if(isset($order_status) && $order_status == 1) selected @endif>Pending</option>
                                        <option value="2" @if(isset($order_status) && $order_status == 2) selected @endif>Approve</option>
                                        <option value="3" @if(isset($order_status) && $order_status == 3) selected @endif>Intransit</option>
                                        <option value="4" @if(isset($order_status) && $order_status == 4) selected @endif>Delivered</option>
                                        <option value="5" @if(isset($order_status) && $order_status == 5) selected @endif>Cancelled</option>
                                    </select>
                                <form>
                            </div>
                        </div>
                        <div class="dashboard-my-order-table">
                            <div class="table-responsive">
                                <table class="recent-order-table-data table">
                                    <tbody>

                                        @if(count($orders) > 0)
                                        @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <img alt="" src="{{ url('assets') }}/images/dashboard-data-card-images/icon-1.svg" style="height: 30px; width: 30px"/>
                                                <span class="product-name" style="margin-left: 0px">
                                                    Order No #{{$order->order_no}}
                                                </span>
                                            </td>
                                            <td>
                                                {{date("jS M, Y h:i A", strtotime($order->order_date))}}
                                            </td>
                                            <td>

                                                @if($order->order_status == 0)
                                                    <span class="product-status-btn in-progress">Pending</span>
                                                @elseif($order->order_status == 1)
                                                    <span class="product-status-btn pending">Approved</span>
                                                @elseif($order->order_status == 2)
                                                    <span class="product-status-btn on-hold">Intransit</span>
                                                @elseif($order->order_status == 3)
                                                    <span class="product-status-btn complete">Delivered</span>
                                                @else
                                                    <span class="product-status-btn cancelled">Cancelled</span>
                                                @endif

                                            </td>
                                            <td>
                                                Qty:
                                                <span class="product-quantity">
                                                    {{DB::table('order_details')->where('order_id', $order->id)->sum('qty')}}
                                                </span>
                                            </td>
                                            <td>
                                                Amount:<span class="product-price">{{number_format($order->total)}} BDT</span>
                                            </td>
                                            <td>
                                                <a class="view-order-btn" href="{{url('order/details')}}/{{$order->slug}}">View order</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" class="text-center" style="padding: 10px 0px; background: transparent;">
                                                <span class="product-price" style="font-size: 20px;">No Orders Found</span>
                                            </td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="dashboard-my-order-bottom">
                                {{$orders->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
