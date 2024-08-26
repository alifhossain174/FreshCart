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
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif
@endpush

@section('header_css')
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/user-pannel.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/uicons.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/icofont.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/nice-select.css" />
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
                    <div class="dasboard-data-card mgTop24">
                        <div class="single-data-card card-1">
                            <div class="data-card-info">
                                <h3>{{ $totalOrderPlaced }}</h3>
                                <p>Total order placed</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('assets') }}/images/dashboard-data-card-images/icon-1.svg" />
                            </div>
                        </div>
                        <div class="single-data-card card-2">
                            <div class="data-card-info">
                                <h3>{{ $totalRunningOrder }}</h3>
                                <p>Running orders</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('assets') }}/images/dashboard-data-card-images/icon-2.svg" />
                            </div>
                        </div>
                        <div class="single-data-card card-3">
                            <div class="data-card-info">
                                <h3>{{ session('cart') ? count(session('cart')) : 0 }}</h3>
                                <p>Items in cart</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('assets') }}/images/dashboard-data-card-images/icon-3.svg" />
                            </div>
                        </div>
                        <div class="single-data-card card-4">
                            <div class="data-card-info">
                                <h3>{{ $itemsInWishList }}</h3>
                                <p>Product in wishlist's</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('assets') }}/images/dashboard-data-card-images/icon-4.svg" />
                            </div>
                        </div>
                        <div class="single-data-card card-5">
                            <div class="data-card-info">
                                <h3>{{ number_format($totalAmountSpent) }}</h3>
                                <p>Amount spent</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('assets') }}/images/dashboard-data-card-images/icon-5.svg" />
                            </div>
                        </div>
                        <div class="single-data-card card-6">
                            <div class="data-card-info">
                                <h3>{{ $totalOpenedTickets }}</h3>
                                <p>Opened Tickets</p>
                            </div>
                            <div class="data-card-icon">
                                <img alt=""
                                    src="{{ url('assets') }}/images/dashboard-data-card-images/support-ticket.svg" />
                            </div>
                        </div>
                    </div>
                    <div class="recent-order-table-area">
                        <div class="dashboard-head-widget">
                            <h5 class="dashboard-head-widget-title">Recent orders</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn" href="{{ url('my/orders') }}">View more</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="recent-order-table-data table">
                                <tbody>

                                    @if (count($recentOrders) > 0)
                                        @foreach ($recentOrders as $recentOrder)
                                            <tr>
                                                <td>
                                                    <img alt=""
                                                        src="{{ url('assets') }}/images/dashboard-data-card-images/icon-1.svg"
                                                        style="height: 30px; width: 30px" />
                                                    <span class="product-name" style="margin-left: 0px">
                                                        Order No #{{ $recentOrder->order_no }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ date('jS M, Y h:i A', strtotime($recentOrder->order_date)) }}
                                                </td>
                                                <td>

                                                    @if ($recentOrder->order_status == 0)
                                                        <span class="product-status-btn in-progress">Pending</span>
                                                    @elseif($recentOrder->order_status == 1)
                                                        <span class="product-status-btn pending">Approved</span>
                                                    @elseif($recentOrder->order_status == 2)
                                                        <span class="product-status-btn on-hold">Intransit</span>
                                                    @elseif($recentOrder->order_status == 3)
                                                        <span class="product-status-btn complete">Delivered</span>
                                                    @else
                                                        <span class="product-status-btn cancelled">Cancelled</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    Qty:
                                                    <span class="product-quantity">
                                                        {{ DB::table('order_details')->where('order_id', $recentOrder->id)->sum('qty') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    Amount:<span
                                                        class="product-price">{{ number_format($recentOrder->total) }}
                                                        BDT</span>
                                                </td>
                                                <td>
                                                    <a class="view-order-btn"
                                                        href="{{ url('order/details') }}/{{ $recentOrder->slug }}">View
                                                        order</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <span class="product-price" style="font-size: 18px;">No Order Found</span>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="wishlist-items-area">
                        <div class="dashboard-head-widget">
                            <h5 class="dashboard-head-widget-title">Wishlist items</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn" href="{{ url('my/wishlists') }}">View more</a>
                            </div>
                        </div>
                        <div class="dashboard-wishlist-inner">

                            @if (count($wishlistedItems) > 0)
                                @foreach ($wishlistedItems as $wishlistedItem)
                                    <div class="wishlist-card">
                                        <div class="wishlist-card-data">
                                            <div class="wishlist-card-img">
                                                <img alt=""
                                                    src="{{ env('ADMIN_URL') . '/' . $wishlistedItem->image }}" />
                                                <div class="wishlist-card-remove">
                                                    <a href="{{ url('remove/from/wishlist') }}/{{ $wishlistedItem->product_slug }}"
                                                        class="d-block">
                                                        <span><i class="fi-br-cross-small"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="wishlist-card-info">
                                                <h6>{{ $wishlistedItem->name }}</h6>
                                                <p>{{ $wishlistedItem->discount_price > 0 ? $wishlistedItem->discount_price : $wishlistedItem->price }}
                                                    BDT<span>
                                                        @if ($wishlistedItem->unit_name)
                                                            /{{ $wishlistedItem->unit_name }}
                                                        @endif
                                                    </span></p>
                                            </div>
                                        </div>
                                        <div class="wishlist-card-btn">
                                            <a href="{{ url('product/details') }}/{{ $wishlistedItem->product_slug }}"
                                                target="_blank"><i class="fi-rr-arrow-right"></i></a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <style>
                                    .dashboard-wishlist-inner {
                                        display: block;
                                        margin-top: 0px;
                                    }
                                </style>
                                <table class="recent-order-table-data table">
                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <span class="product-price" style="font-size: 18px;">No Product in
                                                    Wishlist</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
