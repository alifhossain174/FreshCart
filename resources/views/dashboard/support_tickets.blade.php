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
                    <div class="dashboard-support-ticket mgTop24">
                        <div class="dashboard-head-widget style-2" style="margin-bottom: 16px">
                            <h5 class="dashboard-head-widget-title">Support tickets</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn secondary-btn icon-right" href="{{ url('create/ticket') }}"><i class="fi-rr-plus"></i>Create ticket</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="support-ticket-table-data table">
                                <tbody>

                                    @if(count($supportTickets) > 0)
                                    @foreach ($supportTickets as $supportTicket)
                                        <tr>
                                            <td>
                                                <span class="support-ticket-number">
                                                    <img alt="" src="{{url('user-dashboard-assets')}}/assets/img/icons/messages.svg">
                                                    {{ $supportTicket->ticket_no }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="support-ticket-date">{{ date('jS M, Y h:i A', strtotime($supportTicket->created_at)) }}</span>
                                            </td>
                                            <td>
                                                <span class="support-ticket-text">{{ substr($supportTicket->subject, 0, 60) }}...</span>
                                            </td>
                                            <td>
                                                @if ($supportTicket->status == 0)
                                                    <span class="support-ticket-status-btn" style="background: #0074e4">Pending</span>
                                                @elseif($supportTicket->status == 1)
                                                    <span class="support-ticket-status-btn cancelled">In Progress</span>
                                                @elseif($supportTicket->status == 2)
                                                    <span class="support-ticket-status-btn open">Solved</span>
                                                @elseif($supportTicket->status == 3)
                                                    <span class="support-ticket-status-btn closed">Rejected</span>
                                                @else
                                                    <span class="support-ticket-status-btn hold">On Hold</span>
                                                @endif

                                            </td>
                                            <td>
                                                <a class="open-ticket-btn" href="{{ url('support/ticket/message') }}/{{ $supportTicket->slug }}">Open ticket</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                No Support Ticket Found
                                            </td>
                                        </tr>
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
