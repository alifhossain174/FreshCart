@extends('master')

@section('header_css')
    <style>
        /* Confirmation Email Modal  */
        #backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--theme-color);
            z-index: 999;
            opacity: 0.5;
        }

        #confirmation-email-modal {
            display: none;
            padding: 32px 24px;
            background-color: white;
            margin-top: 20px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999;
            border-radius: 24px;
            text-align: center;
            /* width: 648px; */
            width: 500px;
        }

        #close-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .c-email-modal-icon img {
            width: 200px;
            height: 176x;
            object-fit: contain;
        }

        .c-email-modal-content {
            margin-top: 24px;
        }

        .c-email-modal-content h4 {
            font-size: 25px;
            font-weight: 600;
            line-height: 120%;
            margin: 0;
        }

        .c-email-modal-content p {
            font-size: 16px;
            font-weight: 500;
            line-height: 150%;
            margin: 0;
            margin-top: 16px;
        }

        .c-email-modal-buttons {
            display: flex;
            align-items: center;
            gap: 24px;
            justify-content: center;
            margin-top: 32px;
        }

        .single-c-email-modal-btn {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            line-height: 150%;
            width: 100%;
            border-radius: 8px;
            transition: all 0.4s ease;
        }

        .single-c-email-modal-btn.edit {
            background: #EBF4FD;
            color: var(--theme-color);
        }

        .single-c-email-modal-btn.edit:hover {
            background: var(--theme-color);
            color: white;
        }

        .single-c-email-modal-btn.confirm {
            background: var(--theme-color);
            color: white;
        }

        .single-c-email-modal-btn.confirm:hover {
            background: var(--theme-color);
        }

        .c-email-modal-content span {
            background: #EBF4FD;
            display: inline-block;
            border-radius: 8px;
            line-height: 150%;
            font-weight: 500;

            padding: 8px 24px;
            font-size: 18px;
            margin-top: 20px;
        }

        #close-icon {
            width: 32px;
            height: 32px;
            line-height: 39px;
            background: #EBF4FD;
            color: var(--theme-color);
            border-radius: 100%;
            font-size: 18px;
            transition: all 0.4s ease;
            text-align: center;
        }

        #close-icon:hover {
            background: var(--theme-color);
            color: white;
        }

        /* Responsive CSS */
        @media only screen and (min-width: 992px) and (max-width: 1240px) {
            .c-email-modal-icon img {
                width: 172px;
                height: 152px;
            }
        }

        @media only screen and (max-width: 767px) {

            #confirmation-email-modal {
                width: 90%;
            }

            .c-email-modal-icon img {
                width: 124px;
                height: 100px;
            }

            .c-email-modal-content h4 {
                font-size: 20px;
            }

            .c-email-modal-content p {
                font-size: 14px;
            }

            .c-email-modal-content span {
                padding: 12px;
                font-size: 16px;
                margin-top: 18px;
            }

            .c-email-modal-buttons {
                margin-top: 24px;
            }

            .single-c-email-modal-btn {
                padding: 12px 8px;
                font-size: 14px;
            }

            #close-icon {
                line-height: 36px;
                text-align: center;
            }

            .c-email-modal-content p br {
                display: none;
            }
        }
    </style>
@endsection


@push('site-seo')
    @php
        $generalInfo = DB::table('general_infos')
            ->select(
                'meta_title',
                'meta_og_title',
                'meta_keywords',
                'meta_description',
                'meta_og_description',
                'meta_og_image',
                'company_name',
                'fav_icon',
            )
            ->where('id', 1)
            ->first();
        $socialLogin = DB::table('social_logins')->select('gmail_login_status')->where('id', 1)->first();
    @endphp
    <meta name="keywords" content="{{ $generalInfo ? $generalInfo->meta_keywords : '' }}" />
    <meta name="description" content="{{ $generalInfo ? $generalInfo->meta_description : '' }}" />
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') }}">

    {{-- Page Title & Favicon --}}
    <title>
        @if ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }}
        @else
            {{ $generalInfo->company_name }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" />
    @endif

    {{-- open graph meta --}}
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ env('ADMIN_URL') . '/' . $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
@endpush

@section('content')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Sign In</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Sign In</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{url('assets')}}/images/inner-page/sign-up.png" class="img-fluid" alt="" />
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Welcome To {{env('APP_NAME')}}</h3>
                            <h4>Create New Account</h4>
                        </div>

                        <div class="input-box">
                            <form class="row g-4" action="{{ url('register') }}" method="post">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Full Name" required="" />
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="fullname">Full Name</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email or Phone Number" required="" />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="email">Email or Phone Number</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid  @enderror" value="" placeholder="Set Password" required="" />
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="password">Password</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="button" id="show-confirmation-email-modal" class="btn btn-animation w-100">
                                        Register account
                                    </button>
                                    <button type="submit" id="registration_button" class="btn btn-animation w-100 d-none">
                                        Register account
                                    </button>
                                </div>
                            </form>
                        </div>

                        @if ($socialLogin->gmail_login_status)
                        <div class="other-log-in">
                            <h6>or</h6>
                        </div>

                        <div class="log-in-button">
                            <ul>
                                <li>
                                    <a href="{{ url('auth/google') }}" class="btn google-button w-100">
                                        <img src="{{url('assets')}}/images/inner-page/google.png" class="blur-up lazyload" alt="" />
                                        Sign up with Google
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="other-log-in">
                            <h6></h6>
                        </div>
                        @endif

                        <div class="sign-up-box">
                            <h4>Already have an account?</h4>
                            <a href="{{ url('login') }}">Log In</a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-7 col-xl-6 col-lg-6"></div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

    <!-- Tap to top start -->
    <div class="theme-option">
        <div class="back-to-top">
            <a id="back-to-top" href="#">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <!-- Tap to top end -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->

    <div id="backdrop"></div>
    <!-- Confimation Email Modal -->
    <div id="confirmation-email-modal">
        {{-- <span id="close-icon" onclick="closeWidget()"><i class="fi-rr-cross-small"></i></span> --}}
        <div class="c-email-modal-icon">
            <img src="{{ url('assets') }}/images/confirm-notification-icon.svg" alt="" />
        </div>
        <div class="c-email-modal-content">
            <h4 style="font-size: 22px;">Confirm Your Email or Phone <br />Number</h4>
            <p style="font-size: 14px">
                A verification code will be sent to your email or phone to<br />
                verify your account. Please confirm your email or phone<br />
                number.
            </p>
            <span id="confirmationEmailOrPhone" style="font-size: 16px; padding: 14px 28px;"></span>
            <div class="c-email-modal-buttons" style="margin-top: 40px">
                <a href="javascript:void(0)" style="padding: 12px 20px;" class="single-c-email-modal-btn edit" onclick="closeWidget()">Edit</a>
                <a href="javascript:void(0)" style="padding: 12px 20px;" class="single-c-email-modal-btn confirm" onclick="submitRegistrationForm()">Yes, confirm</a>
            </div>
        </div>
    </div>
    <!-- End Confimation Email Modal -->
@endsection


@section('footer_js')

    <!-- Confirmation Email Modal JS -->
    <script type="text/javascript">

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function containsAtSymbol(inputString) {
            return inputString.indexOf('@') !== -1; // or inputString.includes('@');
        }

        function isValidBangladeshiMobileNumber(mobileNumber) {
            // Bangladeshi mobile numbers can start with 01, and the total length should be 11 digits
            const mobileRegex = /^01[0-9]{9}$/;
            return mobileRegex.test(mobileNumber);
        }

        // JavaScript to handle button click and show/hide the modal
        document.getElementById("show-confirmation-email-modal").addEventListener("click", function() {

            var name = $("#name").val();
            var username = $("#email").val();
            var password = $("#password").val();
            var address = $("#address").val();

            if(name == '' || username == '' || password == '' || address == ''){
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 2000;
                toastr.error("Please fill up all the input fields");
                return false;
            }

            if (containsAtSymbol(username)) {
                if (!isValidEmail(username)) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 2000;
                    toastr.error("Email is not in a valid format");
                    return false;
                }
            } else {
                if (!isValidBangladeshiMobileNumber(username)) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 2000;
                    toastr.error("Mobile number is not in a valid Bangladeshi format");
                    return false;
                }
            }

            $("#confirmationEmailOrPhone").html(username);

            var backdrop = document.getElementById("backdrop");
            var widget = document.getElementById("confirmation-email-modal");

            // Toggle the display property of the backdrop and modal
            backdrop.style.display = backdrop.style.display === "none" || backdrop.style.display === "" ? "block" : "none";
            widget.style.display = widget.style.display === "none" || widget.style.display === "" ? "block" : "none";
        });

        function submitRegistrationForm(){
            $('#show-confirmation-email-modal').prop('disabled', true);
            $('#show-confirmation-email-modal').css('cursor', 'wait');
            closeWidget();
            $("#show-confirmation-email-modal").html("Sending Code...");
            document.getElementById('registration_button').click();
        }

        // Function to close the modal
        function closeWidget() {
            var backdrop = document.getElementById("backdrop");
            var widget = document.getElementById("confirmation-email-modal");
            $('#email').focus();

            // Hide the backdrop and modal
            backdrop.style.display = "none";
            widget.style.display = "none";
        }
    </script>

@endsection
