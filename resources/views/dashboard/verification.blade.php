@extends('master')

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
        <link rel="icon" href="{{ env('ADMIN_URL') . '/' . $generalInfo->fav_icon }}" type="image/x-icon" />
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
                        <h2>User Verify</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">User Verify</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section otp-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{url('assets')}}/images/inner-page/otp.png" class="img-fluid" alt="" />
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="log-in-box">
                            <div class="log-in-title">
                                <h3 class="text-title">
                                    Please enter the one time password to verify your account
                                </h3>
                                <h5 class="text-content">
                                    A code has been sent to <span>{{ Auth::user()->email ? Auth::user()->email : Auth::user()->phone }}</span>
                                </h5>
                            </div>

                            <form class="auth-card-form" action="{{ url('user/verify/check') }}" method="post">
                                @csrf
                                <div id="otp-input otp" class="otp-input inputs d-flex flex-row justify-content-center">
                                    <input class="text-center form-control rounded otp-input-field" value="" name="code[]" type="text" maxlength="1" placeholder="0" required/>
                                    <input class="text-center form-control rounded otp-input-field" value="" name="code[]" type="text" maxlength="1" placeholder="0" required/>
                                    <input class="text-center form-control rounded otp-input-field" value="" name="code[]" type="text" maxlength="1" placeholder="0" required/>
                                    <input class="text-center form-control rounded otp-input-field" value="" name="code[]" type="text" maxlength="1" placeholder="0" required/>
                                    <input class="text-center form-control rounded otp-input-field" value="" name="code[]" type="text" maxlength="1" placeholder="0" required/>
                                    <input class="text-center form-control rounded otp-input-field" value="" name="code[]" type="text" maxlength="1" placeholder="0" required/>
                                </div>

                                <div class="send-box pt-4">
                                    <h5>
                                        Didn't get the code?
                                        <a href="{{ url('user/verification/resend') }}" class="theme-color fw-bold">Resend It</a>
                                    </h5>
                                </div>

                                <button id="verify-btn" class="btn btn-animation w-100 mt-3" type="submit">
                                    Validate
                                </button>
                            </form>

                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="padding: 8px 15px; border-radius: 4px; display: block; text-align: center; margin-top: 10px; padding: 8px 15px; border-radius: 4px;"><i class="fa fa-arrow-left" style="font-size: 12px"></i> Go Back</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

@endsection


@section('footer_js')
    <script>
        document.addEventListener("paste", function(e) {
            // if the target is a text input
            if (e.target.type === "text") {
                var data = e.clipboardData.getData('Text');
                // split clipboard text into single characters
                data = data.split('');
                // find all other text inputs
                [].forEach.call(document.querySelectorAll("input.otp-input-field"), (node, index) => {
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

            if (emptyBoxCount == 6) {
                document.getElementById("verify-btn").style.cursor = "pointer";
                document.getElementById("verify-btn").click();
            } else {
                document.getElementById("verify-btn").style.cursor = "no-drop";
            }
        }
    </script>
@endsection
