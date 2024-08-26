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
        #changePasswordForm .form-control{
            font-size: 16px !important;
            height: 45px !important;
            padding: .6rem .8rem !important;
        }
        #changePasswordForm button.theme-btn{
            font-size: 14px;
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
                        <img alt="" src="{{ url('assets') }}/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('dashboard.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">

                    <div class="dashboard-change-password mgTop24">
                        <div class="dashboard-head-widget style-2 m-0">
                            <h5 class="dashboard-head-widget-title">Change password</h5>
                        </div>
                        <div class="change-password-inner">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-md-10 col-12">
                                    <div class="change-password-card">

                                        <form action="{{url('update/password')}}" method="post" id="changePasswordForm" class="change-password-form">
                                            @csrf

                                            @if(!Auth::user()->provider_id)
                                            <div class="form-group">
                                                <label for="oldPassword">Type old password</label>
                                                <div class="form-group-password">
                                                    <input type="password" class="form-control" id="oldPassword" name="old_password" required="">
                                                    <div class="input-group-append">
                                                        <div onclick="togglePasswordVisibility('oldPassword')">
                                                            <i id="oldPasswordIcon" class="fi-rr-eye-crossed"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="newPassword">Set a new password</label>
                                                <div class="form-group-password">
                                                    <input type="password" class="form-control" id="newPassword" name="new_password" required="">
                                                    <div class="input-group-append">
                                                        <div onclick="togglePasswordVisibility('newPassword')">
                                                            <i id="newPasswordIcon" class="fi-rr-eye-crossed"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmPassword">Confirm password</label>
                                                <div class="form-group-password">
                                                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password"  required="">
                                                    <div class="input-group-append">
                                                        <div onclick="togglePasswordVisibility('confirmPassword')">
                                                            <i id="confirmPasswordIcon" class="fi-rr-eye-crossed"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="change-password-form-btn theme-btn btn btn-primary">
                                                Update Password
                                            </button>
                                        </form>

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
    <script>
        function togglePasswordVisibility(inputId) {
            const inputElement = document.getElementById(inputId);
            const iconElement = document.getElementById(inputId + "Icon");
            if (inputElement.type === "password") {
                inputElement.type = "text";
                iconElement.classList.remove("fi-rr-eye-crossed");
                iconElement.classList.add("fi-rr-eye");
            } else {
                inputElement.type = "password";
                iconElement.classList.remove("fi-rr-eye");
                iconElement.classList.add("fi-rr-eye-crossed");
            }
        }
    </script>
@endsection
