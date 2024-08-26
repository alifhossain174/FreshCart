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
        .ticket-converstion-navigation-tools{
            right: 25px;
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

                    <div class="dashboard-ticket-converstion mgTop24">
                        <div class="dashboard-head-widget style-2 m-0">
                            <h5 class="dashboard-head-widget-title">
                                {{$supportTicket->subject}}
                            </h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn secondary-btn icon-right" href="{{url('support/tickets')}}"><i class="fi-rr-arrow-left"></i>Back</a>
                            </div>
                        </div>
                        <div class="ticket-converstion-main">
                            <div style="height: 600px; overflow-y: scroll" id="div1">

                                <div class="ticket-converstion-widget user-conversation">
                                    <div class="ticket-converstion-widget-img">
                                        @if($supportTicket->user_image)
                                            <img alt="" src="{{url(env('ADMIN_URL').'/'.$supportTicket->user_image)}}">
                                        @endif
                                    </div>
                                    <div class="ticket-converstion-widget-info">
                                        <div class="ticket-converstion-widget-info-head">
                                            <h5>{{$supportTicket->user_name}}</h5>
                                            <div class="ticket-converstion-widget-info-date">
                                                <span>{{ date('jS M, Y h:i A', strtotime($supportTicket->created_at)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ticket-converstion-info-body">
                                            <p class="ticket-converstion-info-body-text">
                                                {{$supportTicket->message}}
                                            </p>

                                            @if($supportTicket->attachment)
                                            <div class="ticket-converstion-info-body-images">
                                                <div class="ticket-converstion-info-body-single-img">
                                                    <a href="{{url(env('ADMIN_URL').'/'.$supportTicket->attachment)}}" data-fancybox="photo" class="image-view-btn">
                                                        <img src="{{url(env('ADMIN_URL').'/'.$supportTicket->attachment)}}" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                @foreach ($supportTicketMessages as $supportTicketMessage)
                                    @if($supportTicketMessage->sender_type == 1)
                                        <div class="ticket-converstion-widget admin-conversation">
                                            <div class="ticket-converstion-widget-info">
                                                <div class="ticket-converstion-widget-info-head">
                                                    <div class="ticket-converstion-widget-info-date">
                                                        <span>{{ date('jS M, Y h:i A', strtotime($supportTicketMessage->created_at)) }}</span>
                                                    </div>
                                                    <h5>Admin</h5>
                                                </div>
                                                <div class="ticket-converstion-info-body">
                                                    <p class="ticket-converstion-info-body-text">
                                                        {{$supportTicketMessage->message}}
                                                    </p>

                                                    @if($supportTicketMessage->attachment)
                                                    <div class="ticket-converstion-info-body-images admin-images">
                                                        <div class="ticket-converstion-info-body-single-img">
                                                            <a href="{{url(env('ADMIN_URL').'/'.$supportTicketMessage->attachment)}}" data-fancybox="photo" class="image-view-btn">
                                                                <img src="{{url(env('ADMIN_URL').'/'.$supportTicketMessage->attachment)}}" alt="">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="ticket-converstion-widget-img">
                                                {{-- <img alt="#" src="{{url('frontend_assets')}}/assets/images/ticket-conversation-img/admin-profile.svg"> --}}
                                            </div>
                                        </div>
                                    @else
                                        <div class="ticket-converstion-widget user-conversation">
                                            <div class="ticket-converstion-widget-img">
                                                @if($supportTicketMessage->user_image)
                                                    <img alt="" src="{{url(env('ADMIN_URL').'/'.$supportTicketMessage->user_image)}}">
                                                @endif
                                            </div>
                                            <div class="ticket-converstion-widget-info">
                                                <div class="ticket-converstion-widget-info-head">
                                                    <h5>{{$supportTicketMessage->user_name}}</h5>
                                                    <div class="ticket-converstion-widget-info-date">
                                                        <span>{{ date('jS M, Y h:i A', strtotime($supportTicketMessage->created_at)) }}</span>
                                                    </div>
                                                </div>
                                                <div class="ticket-converstion-info-body">
                                                    <p class="ticket-converstion-info-body-text">
                                                        {{$supportTicketMessage->message}}
                                                    </p>

                                                    @if($supportTicketMessage->attachment)
                                                    <div class="ticket-converstion-info-body-images">
                                                        <div class="ticket-converstion-info-body-single-img">
                                                            <a href="{{url(env('ADMIN_URL').'/'.$supportTicketMessage->attachment)}}" data-fancybox="photo" class="image-view-btn">
                                                                <img src="{{url(env('ADMIN_URL').'/'.$supportTicketMessage->attachment)}}" alt="">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                            </div>


                            <form action="{{url('send/support/message')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="support_ticket_id" value="{{$supportTicket->id}}">
                                <div class="ticket-converstion-bottom">
                                    <div class="ticket-converstion-navigation">
                                        <textarea type="text" name="message" placeholder="Type your message"></textarea>
                                        <div class="ticket-converstion-navigation-tools">
                                            <div class="ticket-c-navigation-attachment">
                                                <div class="ticket-c-navigation-upload-image">
                                                    <input type="file" name="image" id="upload-img" placeholder="Choose file" multiple=""><label for="upload-img"><i class="fi fi-rs-clip"></i></label>
                                                </div>
                                            </div>
                                            <button type="submit" class="ticket-c-navigation-send-btn btn btn-primary" style="height: 40px; width: 40px; line-height: 44px;">
                                                <i class="fi-rr-paper-plane" style="font-size: 20px;"></i>
                                            </button>
                                        </div>
                                        <div class="upload-image-list"></div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div></div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer_js')
    <script>
        $(document).ready(function() {
            // console.log($(document).height());
            $("#div1").animate({ scrollTop: $('#div1').prop("scrollHeight")}, 1000);
            $("html, body").animate({ scrollTop: 500 }, 1000);
        });
    </script>
@endsection
