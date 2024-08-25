<!DOCTYPE html>
<html lang="en">

@php
    $generalInfo = DB::table('general_infos')
        ->select('logo_dark', 'logo', 'fav_icon', 'company_name', 'email', 'address', 'custom_css', 'header_script', 'footer_script', 'payment_banner', 'play_store_link', 'contact', 'footer_copyright_text', 'app_store_link', 'whatsapp', 'messenger', 'telegram', 'youtube', 'facebook', 'twitter', 'linkedin', 'instagram', 'primary_color', 'secondary_color', 'tertiary_color', 'title_color', 'paragraph_color', 'border_color', 'google_tag_manager_status', 'google_tag_manager_id', 'google_analytic_status', 'google_analytic_tracking_id', 'fb_pixel_status', 'fb_pixel_app_id', 'tawk_chat_status', 'tawk_chat_link', 'messenger_chat_status', 'fb_page_id', 'short_description')
        ->where('id', 1)
        ->first();
@endphp

<head>

    <!-- Start Meta Data -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- End Meta Data -->

    @stack('site-seo')

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/vendors/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/vendors/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/vendors/feather-icon.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/vendors/ion.rangeSlider.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/vendors/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/vendors/slick/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/font-style.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/style.css" />

    @yield('header_css')

    <style>
        .theme-color-3 {
            --theme-color: {{ $generalInfo->primary_color }};
        }
    </style>

    @if ($generalInfo->google_tag_manager_status)
        <!-- Google Tag Manager -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ $generalInfo->google_tag_manager_id }}');
        </script>
        <!-- End Google Tag Manager-->
    @endif

    @if ($generalInfo->google_analytic_status)
        <!-- Google tag (gtag.js) google analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $generalInfo->google_analytic_tracking_id }}" type="53191a76ba85f8f784cbe351-text/javascript"></script>
        <script type="53191a76ba85f8f784cbe351-text/javascript">
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{$generalInfo->google_analytic_tracking_id}}');
        </script>
    @endif

    @if ($generalInfo->fb_pixel_status)
        <!-- Facebook Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $generalInfo->fb_pixel_app_id }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $generalInfo->fb_pixel_app_id }}&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->
    @endif

    @if ($generalInfo->tawk_chat_status)
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = '{{ $generalInfo->tawk_chat_link }}';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    @endif

    {!! $generalInfo->header_script !!}
</head>

<body class="theme-color-3 dark">

    @if ($generalInfo->google_tag_manager_status)
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $generalInfo->google_tag_manager_id }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif

    @if ($generalInfo->messenger_chat_status)
        <a href="{{$generalInfo->fb_page_id}}" target="_blank" style="position: fixed; right: 12px; width: 60px; bottom: 65px; z-index: 99999;">
            <img src="{{url('assets')}}/images/messenger_icon.png" style="width: 60px">
        </a>
    @endif

    <!-- Loader Start -->
    <div class="fullpage-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <!-- Loader End -->

    <!-- Header Start -->
    <header class="header-3">
        <div class="top-nav sticky-header sticky-header-2">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="navbar-top">
                            <button class="navbar-toggler d-xl-none d-block p-0 me-3" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                                <span class="navbar-toggler-icon">
                                    <i class="iconly-Category icli"></i>
                                </span>
                            </button>
                            <a href="{{url('/')}}" class="web-logo nav-logo">
                                <img src="{{ url(env('ADMIN_URL') . '/' . $generalInfo->logo) }}" alt="{{$generalInfo->company_name}}" class="img-fluid blur-up lazyload" alt="" />
                            </a>

                            <div class="search-full">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i data-feather="search" class="font-light"></i>
                                    </span>
                                    <input type="text" class="form-control search-type" placeholder="Search here.." />
                                    <span class="input-group-text close-search">
                                        <i data-feather="x" class="font-light"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="middle-box">
                                <div class="center-box">
                                    <form action="{{url('search/for/products')}}" method="GET">
                                        @csrf
                                        <div class="searchbar-box-2 input-group d-xl-flex d-none" style="position: relative">
                                            <button class="btn search-icon" type="button">
                                                <i class="iconly-Search icli"></i>
                                            </button>
                                            <input type="text" autocomplete="off" @if(isset($search_keyword)) value="{{$search_keyword}}" @endif name="search_keyword" id="search_keyword" class="form-control" placeholder="Search for products..." required/>
                                            <button class="btn search-button" type="submit">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="rightside-menu support-sidemenu">
                                <div class="support-box">
                                    <div class="support-image">
                                        <img src="{{url('assets')}}/images/icon/support.png" class="img-fluid blur-up lazyload" alt="" />
                                    </div>
                                    <div class="support-number">
                                        <h2>{{$generalInfo->contact}}</h2>
                                        <h4>24/7 Support Center</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12 position-relative">
                    <div class="main-nav nav-left-align">
                        <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky p-0">
                            <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                <div class="offcanvas-header navbar-shadow">
                                    <h5>Menu</h5>
                                    <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link dropdown-toggle ps-0 arrow-none" href="{{url('/')}}">Home</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="{{url('/shop')}}">Shop</a>
                                        </li>
                                        <li class="nav-item dropdown new-nav-item">
                                            <a class="nav-link dropdown-toggle arrow-none" href="{{url('/vendor/shops')}}">Vendors</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="{{url('/blogs')}}">Blogs</a>
                                        </li>
                                        <li class="nav-item dropdown new-nav-item">
                                            <a class="nav-link dropdown-toggle arrow-none" href="{{url('/about')}}">About us</a>
                                        </li>
                                        <li class="nav-item dropdown new-nav-item">
                                            <a class="nav-link dropdown-toggle arrow-none" href="{{url('/contact')}}">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="rightside-menu">
                            <ul class="option-list-2">
                                <li>
                                    <a href="javascript:void(0)" class="header-icon search-box search-icon">
                                        <i class="iconly-Search icli"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="compare.html" class="header-icon">
                                        <small class="badge-number badge-light">2</small>
                                        <i class="iconly-Swap icli"></i>
                                    </a>
                                </li>

                                <li class="onhover-dropdown">
                                    <a href="wishlist.html" class="header-icon swap-icon">
                                        <i class="iconly-Heart icli"></i>
                                    </a>

                                    <div class="onhover-div">
                                        <ul class="cart-list">
                                            <li>
                                                <div class="drop-cart">
                                                    <a href="product-left-thumbnail.html" class="drop-image">
                                                        <img src="../assets/images/vegetable/product/1.png"
                                                            class="blur-up lazyload" alt="" />
                                                    </a>

                                                    <div class="drop-contain">
                                                        <a href="product-left-thumbnail.html">
                                                            <h5>Fantasy Crunchy Choco Chip Cookies</h5>
                                                        </a>
                                                        <h6><span>1 x</span> $80.58</h6>
                                                        <button class="close-button">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="drop-cart">
                                                    <a href="product-left-thumbnail.html" class="drop-image">
                                                        <img src="../assets/images/vegetable/product/2.png"
                                                            class="blur-up lazyload" alt="" />
                                                    </a>

                                                    <div class="drop-contain">
                                                        <a href="product-left-thumbnail.html">
                                                            <h5>
                                                                Peanut Butter Bite Premium Butter Cookies 600
                                                                g
                                                            </h5>
                                                        </a>
                                                        <h6><span>1 x</span> $25.68</h6>
                                                        <button class="close-button">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>

                                        <div class="price-box">
                                            <h5>Price :</h5>
                                            <h4 class="theme-color fw-bold">$106.58</h4>
                                        </div>

                                        <div class="button-group">
                                            <a href="cart.html" class="btn btn-sm cart-button">View Cart</a>
                                            <a href="checkout.html" class="btn btn-sm cart-button theme-bg-color text-white">Checkout</a>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <a href="{{url('view/cart')}}" class="header-icon bag-icon">
                                        <small class="badge-number badge-light">{{ session('cart') ? count(session('cart')) : 0 }}</small>
                                        <i class="iconly-Bag-2 icli"></i>
                                    </a>
                                </li>
                            </ul>

                            <a href="{{url('/login')}}" class="user-box">
                                <span class="header-icon">
                                    <i class="iconly-Profile icli"></i>
                                </span>
                                <div class="user-name">
                                    <h6 class="text-content">My Account</h6>
                                    <h4 class="mt-1">@auth{{Auth::user()->name}}@endauth</h4>
                                </div>
                            </a>

                            <a target="_blank" class="btn mobile-app d-xxl-flex d-none"
                                href="https://play.google.com/store/games?utm_source=apac_med&utm_medium=hasem&utm_content=Oct0121&utm_campaign=Evergreen&pcampaignid=MKT-EDR-apac-in-1003227-med-hasem-py-Evergreen-Oct0121-Text_Search_BKWS-BKWS%7CONSEM_kwid_43700065205026415_creativeid_535350509927_device_c&gclid=Cj0KCQjw8uOWBhDXARIsAOxKJ2H1K3VqdJFHodt0-XSnQzcuOuTP-s2aPBE6lG0QVOf8D5cJBsB-DxQaAkNAEALw_wcB&gclsrc=aw.ds">
                                <div class="mobile-image">
                                    <img src="../assets/images/icon/mobile.png" class="img-fluid blur-up lazyload"
                                        alt="" />
                                </div>

                                <div class="mobile-name">
                                    <h4>Download App</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- mobile fix menu start -->
    <div class="mobile-menu d-md-none d-block mobile-cart">
        <ul>
            <li class="active">
                <a href="{{url('/')}}">
                    <i class="iconly-Home icli"></i>
                    <span>Home</span>
                </a>
            </li>

            <li class="mobile-category">
                <a href="javascript:void(0)">
                    <i class="iconly-Category icli js-link"></i>
                    <span>Category</span>
                </a>
            </li>

            <li>
                <a href="search.html" class="search-box">
                    <i class="iconly-Search icli"></i>
                    <span>Search</span>
                </a>
            </li>

            <li>
                <a href="wishlist.html" class="notifi-wishlist">
                    <i class="iconly-Heart icli"></i>
                    <span>My Wish</span>
                </a>
            </li>

            <li>
                <a href="cart.html">
                    <i class="iconly-Bag-2 icli fly-cate"></i>
                    <span>Cart</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- mobile fix menu end -->

    @yield('content')

    <!-- Footer Start -->
    <footer class="section-t-space footer-section-2 footer-color-2">
        <div class="container-fluid-lg">
            <div class="main-footer">
                <div class="row g-md-4 gy-sm-5">
                    <div class="col-xxl-3 col-xl-4 col-sm-6">
                        <a href="{{ url('/') }}" class="foot-logo theme-logo">
                            <img src="../assets/images/logo/white-logo.svg" class="img-fluid blur-up lazyload"
                                alt="" />
                        </a>
                        <p class="information-text information-text-2">
                            it is a long established fact that a reader will be distracted
                            by the readable content.
                        </p>
                        <ul class="social-icon">
                            <li class="light-bg">
                                <a href="https://www.facebook.com/" class="footer-link-color">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="light-bg">
                                <a href="https://accounts.google.com/signin/v2/identifier?flowName=GlifWebSignIn&flowEntry=ServiceLogin"
                                    class="footer-link-color">
                                    <i class="fab fa-google"></i>
                                </a>
                            </li>
                            <li class="light-bg">
                                <a href="https://twitter.com/i/flow/login" class="footer-link-color">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li class="light-bg">
                                <a href="https://www.instagram.com/" class="footer-link-color">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li class="light-bg">
                                <a href="https://in.pinterest.com/" class="footer-link-color">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xxl-2 col-xl-4 col-sm-6">
                        <div class="footer-title">
                            <h4 class="text-white">About Fastkart</h4>
                        </div>
                        <ul class="footer-list footer-contact footer-list-light">
                            <li>
                                <a href="about-us.html" class="light-text">About Us</a>
                            </li>
                            <li>
                                <a href="contact-us.html" class="light-text">Contact Us</a>
                            </li>
                            <li>
                                <a href="term_condition.html" class="light-text">Terms & Coditions</a>
                            </li>
                            <li>
                                <a href="careers.html" class="light-text">Careers</a>
                            </li>
                            <li>
                                <a href="blog-list.html" class="light-text">Latest Blog</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xxl-2 col-xl-4 col-sm-6">
                        <div class="footer-title">
                            <h4 class="text-white">Useful Link</h4>
                        </div>
                        <ul class="footer-list footer-list-light footer-contact">
                            <li>
                                <a href="order-success.html" class="light-text">Your Order</a>
                            </li>
                            <li>
                                <a href="{{url('/login')}}" class="light-text">Your Account</a>
                            </li>
                            <li>
                                <a href="order-tracking.html" class="light-text">Track Orders</a>
                            </li>
                            <li>
                                <a href="wishlist.html" class="light-text">Your Wishlist</a>
                            </li>
                            <li>
                                <a href="faq.html" class="light-text">FAQs</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xxl-2 col-xl-4 col-sm-6">
                        <div class="footer-title">
                            <h4 class="text-white">Categories</h4>
                        </div>
                        <ul class="footer-list footer-list-light footer-contact">
                            <li>
                                <a href="vegetables-demo.html" class="light-text">Fresh Vegetables</a>
                            </li>
                            <li>
                                <a href="spice-demo.html" class="light-text">Hot Spice</a>
                            </li>
                            <li>
                                <a href="bags-demo.html" class="light-text">Brand New Bags</a>
                            </li>
                            <li>
                                <a href="bakery-demo.html" class="light-text">New Bakery</a>
                            </li>
                            <li>
                                <a href="grocery-demo.html" class="light-text">New Grocery</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xxl-3 col-xl-4 col-sm-6">
                        <div class="footer-title">
                            <h4 class="text-white">Store infomation</h4>
                        </div>
                        <ul class="footer-address footer-contact">
                            <li>
                                <a href="javascript:void(0)" class="light-text">
                                    <div class="inform-box flex-start-box">
                                        <i data-feather="map-pin"></i>
                                        <p>Fastkart Demo Store, Demo store india 345 - 659</p>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)" class="light-text">
                                    <div class="inform-box">
                                        <i data-feather="phone"></i>
                                        <p>Call us: 123-456-7890</p>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)" class="light-text">
                                    <div class="inform-box">
                                        <i data-feather="mail"></i>
                                        <p>Email Us: Support@Fastkart.com</p>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)" class="light-text">
                                    <div class="inform-box">
                                        <i data-feather="printer"></i>
                                        <p>Fax: 123456</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="sub-footer sub-footer-lite section-b-space section-t-space">
                <div class="left-footer">
                    <p class="light-text">
                        2022 Copyright By Themeforest Powered By Pixelstrap
                    </p>
                </div>

                <ul class="payment-box">
                    <li>
                        <img src="../assets/images/icon/paymant/visa.png" class="blur-up lazyload" alt="" />
                    </li>
                    <li>
                        <img src="../assets/images/icon/paymant/discover.png" alt=""
                            class="blur-up lazyload" />
                    </li>
                    <li>
                        <img src="../assets/images/icon/paymant/american.png" alt=""
                            class="blur-up lazyload" />
                    </li>
                    <li>
                        <img src="../assets/images/icon/paymant/master-card.png" alt=""
                            class="blur-up lazyload" />
                    </li>
                    <li>
                        <img src="../assets/images/icon/paymant/giro-pay.png" alt=""
                            class="blur-up lazyload" />
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- Quick View Modal Box Start -->
    @include('quick_view.modal')
    <!-- Quick View Modal Box End -->

    <!-- Location Modal Start -->
    <div class="modal location-modal fade theme-modal" id="locationModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Choose your Delivery Location
                    </h5>
                    <p class="mt-1 text-content">
                        Enter your address and we will specify the offer for your area.
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="location-list">
                        <div class="search-input">
                            <input type="search" class="form-control" placeholder="Search Your Area" />
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>

                        <div class="disabled-box">
                            <h6>Select a Location</h6>
                        </div>

                        <ul class="location-select custom-height">
                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Alabama</h6>
                                    <span>Min: $130</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Arizona</h6>
                                    <span>Min: $150</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>California</h6>
                                    <span>Min: $110</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Colorado</h6>
                                    <span>Min: $140</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Florida</h6>
                                    <span>Min: $160</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Georgia</h6>
                                    <span>Min: $120</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Kansas</h6>
                                    <span>Min: $170</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Minnesota</h6>
                                    <span>Min: $120</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>New York</h6>
                                    <span>Min: $110</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Washington</h6>
                                    <span>Min: $130</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Location Modal End -->

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

    <!-- latest jquery-->
    <script src="{{ url('assets') }}/js/jquery-3.6.0.min.js"></script>
    <script src="{{ url('assets') }}/js/jquery-ui.min.js"></script>
    <script src="{{ url('assets') }}/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="{{ url('assets') }}/js/bootstrap/bootstrap-notify.min.js"></script>
    <script src="{{ url('assets') }}/js/bootstrap/popper.min.js"></script>
    <script src="{{ url('assets') }}/js/feather/feather.min.js"></script>
    <script src="{{ url('assets') }}/js/feather/feather-icon.js"></script>
    <script src="{{ url('assets') }}/js/lazysizes.min.js"></script>
    <script src="{{ url('assets') }}/js/slick/slick.js"></script>
    <script src="{{ url('assets') }}/js/slick/slick-animation.min.js"></script>
    <script src="{{ url('assets') }}/js/custom-slick-animated.js"></script>
    <script src="{{ url('assets') }}/js/slick/custom_slick.js"></script>
    <script src="{{ url('assets') }}/js/ion.rangeSlider.min.js"></script>
    <script src="{{ url('assets') }}/js/auto-height.js"></script>
    <script src="{{ url('assets') }}/js/lazysizes.min.js"></script>
    <script src="{{ url('assets') }}/js/quantity-2.js"></script>
    <script src="{{ url('assets') }}/js/fly-cart.js"></script>
    <script src="{{ url('assets') }}/js/clipboard.min.js"></script>
    <script src="{{ url('assets') }}/js/copy-clipboard.js"></script>
    <script src="{{ url('assets') }}/js/wow.min.js"></script>
    <script src="{{ url('assets') }}/js/custom-wow.js"></script>
    <script src="{{ url('assets') }}/js/script.js"></script>

    {{-- for lazy load image --}}
    <script>
        function renderLazyImage() {
            var lazyloadImages;
            if ("IntersectionObserver" in window) {
                lazyloadImages = document.querySelectorAll(".lazy");
                var imageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var image = entry.target;
                            image.src = image.dataset.src;
                            image.classList.remove("lazy");
                            imageObserver.unobserve(image);
                        }
                    });
                });

                lazyloadImages.forEach(function(image) {
                    imageObserver.observe(image);
                });
            } else {
                var lazyloadThrottleTimeout;
                lazyloadImages = document.querySelectorAll(".lazy");

                function lazyload() {
                    if (lazyloadThrottleTimeout) {
                        clearTimeout(lazyloadThrottleTimeout);
                    }

                    lazyloadThrottleTimeout = setTimeout(function() {
                        var scrollTop = window.pageYOffset;
                        lazyloadImages.forEach(function(img) {
                            if (img.offsetTop < (window.innerHeight + scrollTop)) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                            }
                        });
                        if (lazyloadImages.length == 0) {
                            document.removeEventListener("scroll", lazyload);
                            window.removeEventListener("resize", lazyload);
                            window.removeEventListener("orientationChange", lazyload);
                        }
                    }, 20);
                }

                document.addEventListener("scroll", lazyload);
                window.addEventListener("resize", lazyload);
                window.addEventListener("orientationChange", lazyload);
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            renderLazyImage();
        })
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // add to cart
        $(".addcart-button").click(function () {
            var id = $(this).data('id');
            $(this).next().addClass("open");
            $("#cart_qty_"+id).val(1);

            $.get("{{ url('add/to/cart') }}" + '/' + id, function(data) {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.success("Added to Cart");
                $("a.bag-icon small.badge-number").html(data.cartTotalQty);
            })
        });

        // cart qty increase
        // $('.qty-right-plus').click(function () {
        $(document).on('click', '.qty-right-plus', function () {

            var cartQty = Number(Number($(this).prev().val()) + 1);
            $(this).prev().val(cartQty);
            var id = $(this).data('id');

            var formData = new FormData();
            formData.append("cart_id", id);
            formData.append("cart_qty", cartQty);
            $.ajax({
                data: formData,
                url: "{{ url('update/cart/qty') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.success("Cart quantity has increased");
                    $("#view_cart_items").html(data.viewCartItems);
                    $("#view_cart_calculation").html(data.viewCartCalculation);
                    // $(".offCanvas__minicart").html(data.rendered_cart);
                    $(".checkout-order-review-inner").html(data.checkoutCartItems);
                    $(".order-review-summary").html(data.checkoutTotalAmount);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        });

        // cart qty decrease
        // $('.qty-left-minus').on('click', function () {
        $(document).on('click', '.qty-left-minus', function () {
            var $qty = $(this).siblings(".qty-input");
            var _val = parseInt($($qty).val());
            if (_val == 1) {
                var _removeCls = $(this).parents('.cart_qty');
                $(_removeCls).removeClass("open");
            }
            var currentVal = parseInt($qty.val());
            if (!isNaN(currentVal) && currentVal > 0) {
                $qty.val(currentVal - 1);
            }

            var id = $(this).data('id');
            if(parseInt($($qty).val()) == 0){
                var id = $(this).data('id');
                $.get("{{ url('remove/cart/item') }}" + '/' + id, function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Item removed from cart");
                    $("a.bag-icon small.badge-number").html(data.cartTotalQty);
                    $("#view_cart_items").html(data.viewCartItems);
                    $("#view_cart_calculation").html(data.viewCartCalculation);
                    $(".checkout-order-review-inner").html(data.checkoutCartItems);
                    // $("#dropdown_box_sidebar_cart").html(data.rendered_cart);
                    // $("span.cart-count").html(data.cartTotalQty);
                    // $("#product_details_cart_qty").val(1);
                    // $("table.cart-single-product-table tbody").html(data.checkoutCartItems);
                    $(".order-review-summary").html(data.checkoutTotalAmount);
                })
            } else {
                var formData = new FormData();
                formData.append("cart_id", id);
                formData.append("cart_qty", parseInt($($qty).val()));
                $.ajax({
                    data: formData,
                    url: "{{ url('update/cart/qty') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        toastr.options.positionClass = 'toast-bottom-right';
                        toastr.options.timeOut = 1000;
                        toastr.success("Cart quantity has decreased");
                        $("#view_cart_items").html(data.viewCartItems);
                        $("#view_cart_calculation").html(data.viewCartCalculation);
                        // $(".offCanvas__minicart").html(data.rendered_cart);
                        $(".checkout-order-review-inner").html(data.checkoutCartItems);
                        $(".order-review-summary").html(data.checkoutTotalAmount);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }

        });

        // quick view
        function showQuickView(productSlug){
            var formData = new FormData();
            formData.append("product_slug", productSlug);
            $.ajax({
                data: formData,
                url: "{{ url('product/quick/view') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#quick_view_modal_body").html(data.rendered_quick_view);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }
    </script>

    @yield('footer_js')

    {!! $generalInfo->footer_script !!}

    <script src="{{ url('assets') }}/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>

</html>
