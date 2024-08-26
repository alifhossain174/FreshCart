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
        .manage-profile-form .form-control{
            font-size: 16px !important;
            height: 45px !important;
            padding: .6rem .8rem !important;
        }
        .manage-profile-form button.theme-btn{
            font-size: 14px;
        }
        .form-control::file-selector-button{
            padding: 0px !important; margin: 3px !important;
        }
        .manage-profile-form-widget .btn{
            font-size: 16px !important;
        }
        .manage-profile-form .form-control::file-selector-button {
            padding: 2px 5px !important;
            margin: 10px 6px !important;
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
                    <div class="dashboard-mange-profile mgTop24">
                        <div class="dashboard-head-widget style-2 m-0">
                            <h5 class="dashboard-head-widget-title">Manage profile</h5>
                        </div>
                        <div class="dashboard-mange-profile-inner">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-md-10 col-12">
                                    <div class="manage-profile-card">

                                        @if (Auth::user()->image)
                                            <div class="manage-profile-img">
                                                <img alt="" src="{{ env('ADMIN_URL') . '/' . Auth::user()->image }}">
                                                <div class="manage-profile-img-btn">
                                                    <a href="{{ url('remove/user/image') }}"
                                                        class="theme-btn secondary-btn icon-right">
                                                        <i class="fi-rr-camera"></i> &nbsp; Remove Photo
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        <form action="{{ url('update/profile') }}" method="post" class="manage-profile-form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="full_name">Full Name</label>
                                                        <input name="name" placeholder="Mr. XYZ" type="text" id="full_name" value="{{ Auth::user()->name }}" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="full_name">Upload New Photo</label>
                                                        <input type="file" name="image" class="form-control" style="padding: 0px !important; margin: 0px">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address">Address</label>
                                                        <input name="address" placeholder="ex. Dhaka, Bangladesh" value="{{ Auth::user()->address }}" type="text" id="address" class="form-control" required="">
                                                    </div>
                                                </div>

                                                <div class="manage-profile-form-button" style="margin-top: 20px; margin-bottom: 30px">
                                                    <button type="submit" class="theme-btn btn btn-primary">
                                                        Save Changes
                                                    </button>
                                                </div>
                                        </form>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Phone Number</label>
                                                <div class="form-input-with-input-text">
                                                    <input placeholder="e.g. 01*********" type="tel"
                                                        value="{{ Auth::user()->phone }}" class="form-control" readonly>
                                                    <button type="button"
                                                        class="my-button manage-profile-form-input-text btn btn-primary"
                                                        onclick="changePhoneEmail('phone')">
                                                        Change number
                                                    </button>
                                                </div>

                                                <!-- Type New Number Form -->
                                                <div id="widget1" class="widget-box manage-profile-form-widget"
                                                    style="display: none">
                                                    <div class="form-group">
                                                        <label class="form-label" for="phoneNumber">Type a new
                                                            number</label>
                                                        <input name="phone-number" placeholder="01234567890" type="tel"
                                                            id="phoneNumber" class="form-control">
                                                    </div>
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="discardEveryModal()">Cancel</button>
                                                    <button type="button" id="widget1NextButton" class="btn btn-primary"
                                                        onclick="sendOtp('phone')">Next</button>
                                                </div>

                                                <!-- Verify OTP Form -->
                                                <div id="widget3" class="manage-profile-form-widget"
                                                    style="display: none; width: 330px">
                                                    <form action="{{ url('verify/sent/otp') }}" method="POST">
                                                        @csrf
                                                        <div class="form-group otp-input">
                                                            <label class="form-label" for="emailAddress">Type OTP
                                                                code</label>
                                                            <div class="otp-input" id="otp-input"
                                                                style="margin-top: 15px">
                                                                <input type="text" name="code[]" maxlength="1"
                                                                    class="otp-input-field is-invalid" value=""
                                                                    style="padding: 0px" />
                                                                <input type="text" name="code[]" maxlength="1"
                                                                    class="otp-input-field is-invalid" value=""
                                                                    style="padding: 0px" />
                                                                <input type="text" name="code[]" maxlength="1"
                                                                    class="otp-input-field is-invalid" value=""
                                                                    style="padding: 0px" />
                                                                <input type="text" name="code[]" maxlength="1"
                                                                    class="otp-input-field is-invalid" value=""
                                                                    style="padding: 0px" />
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="verify-btn"
                                                            class="theme-btn btn btn-primary">
                                                            Submit
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- Verify Success Widget -->
                                                {{-- <div class="manage-profile-form-widget success-widget">
                                                    <div class="manage-profile-form-success-icon">
                                                        <img alt="#" src="../assets/images/success-icon.svg" />
                                                    </div>
                                                    <p class="manage-profile-form-success-title">
                                                        Successfully changed number!
                                                    </p>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Email Address</label>
                                                <div class="form-input-with-input-text">
                                                    <input placeholder="your-email@mail.com"
                                                        value="{{ Auth::user()->email }}" type="email"
                                                        class="form-control" readonly>
                                                    <button type="button"
                                                        class="my-button manage-profile-form-input-text btn btn-primary"
                                                        onclick="changePhoneEmail('email')">
                                                        Change email
                                                    </button>
                                                </div>
                                                <div id="widget2" class="widget-box manage-profile-form-widget"
                                                    style="display: none">
                                                    <div class="form-group">
                                                        <label class="form-label" for="emailAddress">Type a new email
                                                            address</label>
                                                        <input name="email" placeholder="xyz@gmail.com" type="email"
                                                            id="emailAddress" class="form-control">
                                                    </div>
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="discardEveryModal()">Cancel</button>
                                                    <button type="button" id="widget2NextButton" class="btn btn-primary"
                                                        onclick="sendOtp('email')">Next</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    @if (Auth::user()->provider_id)
                                        <div class="manage-profile-form-bottom">
                                            <span class="manage-profile-form-btm-title">Third-party linked account</span>
                                            <div class="manage-profile-form-btm-widget">
                                                <div class="manage-profile-form-btm-widget-icon">
                                                    <img alt="#"
                                                        src="{{url('user-dashboard-assets')}}/assets/img/icons/google.svg">
                                                    <p>Google</p>
                                                </div>
                                                <a class="manage-profile-form-btm-widget-btn"
                                                    href="{{ url('unlink/google/account') }}">Rebroke</a>
                                            </div>
                                        </div>
                                    @endif


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

@section('footer_js')
    <script type="text/javascript">
        function changePhoneEmail(type) {
            if (type == 'phone') {
                $("#widget1").css("display", 'block');
                $("#widget2").css("display", 'none');

                $("#widget1NextButton").html('Next');
                $("#widget2NextButton").html('Next');
            } else {
                $("#widget1").css("display", 'none');
                $("#widget2").css("display", 'block');

                $("#widget1NextButton").html('Next');
                $("#widget2NextButton").html('Next');
            }
        }

        function discardEveryModal() {
            $("#widget1").css("display", 'none');
            $("#widget2").css("display", 'none');
            $("#widget3").css("display", 'none');
            $("#widget1NextButton").html('Next');
            $("#widget2NextButton").html('Next');
        }

        function sendOtp(type) {
            let emailPhone = '';
            if (type == 'phone') {
                emailPhone = $("#phoneNumber").val();
                if (emailPhone == '') {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Fill up the Input Field");
                    return false;
                }
            } else {
                emailPhone = $("#emailAddress").val();
                if (emailPhone == '') {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Please Fill up the Input Field");
                    return false;
                }
            }

            var formData = new FormData();
            formData.append("emailPhone", emailPhone);
            formData.append("type", type);
            $("#widget1NextButton").html('Sending..');
            $("#widget2NextButton").html('Sending..');
            $.ajax({
                data: formData,
                url: "{{ url('send/otp/profile') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.success(data.message);
                    $("#widget1").css("display", 'none');
                    $("#widget2").css("display", 'none');
                    $("#widget3").css("display", 'block');

                    $("#widget1NextButton").html('Next');
                    $("#widget2NextButton").html('Next');
                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                    $("#widget1NextButton").html('Next');
                    $("#widget2NextButton").html('Next');
                }
            });
        }

        document.addEventListener("paste", function(e) {
            // if the target is a text input
            if (e.target.type === "text") {
                var data = e.clipboardData.getData('Text');
                // split clipboard text into single characters
                data = data.split('');
                // find all other text inputs
                [].forEach.call(document.querySelectorAll("input[type=text]"), (node, index) => {
                    // And set input value to the relative character
                    node.value = data[index];
                    checkFilled();
                });
            }
        });

        $('input.otp-input-field').on('keyup', function() {
            if ($(this).val()) {
                $(this).next().focus();
                checkFilled();
            }
        });

        function checkFilled() {
            var interests = document.getElementsByClassName("otp-input-field");
            var emptyBoxCount = 0;
            for (var i = 0; i < interests.length; i++) {
                if (interests[i].value == '') {
                    interests[i].style.borderColor = 'red';
                } else {
                    interests[i].style.borderColor = 'green';
                    emptyBoxCount = emptyBoxCount + 1
                }
            }

            if (emptyBoxCount == 4) {
                document.getElementById("verify-btn").style.cursor = "pointer";
                document.getElementById("verify-btn").click();
            } else {
                document.getElementById("verify-btn").style.cursor = "no-drop";
            }
        }
    </script>
@endsection
