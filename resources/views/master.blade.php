<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Fastkart" />
    <meta name="keywords" content="Fastkart" />
    <meta name="author" content="Fastkart" />
    <link rel="icon" href="{{url('assets')}}/images/favicon/favicon.svg" type="image/x-icon" />
    <title>FreshKart</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/vendors/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/vendors/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/vendors/feather-icon.css" />
    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/vendors/ion.rangeSlider.min.css" />
    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/vendors/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/vendors/slick/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/font-style.css" />
    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/style.css" />
</head>

<body class="theme-color-3 dark">

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
                            <a href="index.html" class="web-logo nav-logo">
                                <img src="../assets/images/logo/white-logo.svg" class="img-fluid blur-up lazyload"
                                    alt="" />
                            </a>

                            <div class="search-full">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i data-feather="search" class="font-light"></i>
                                    </span>
                                    <input type="text" class="form-control search-type"
                                        placeholder="Search here.." />
                                    <span class="input-group-text close-search">
                                        <i data-feather="x" class="font-light"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="middle-box">
                                <div class="center-box">
                                    <div class="searchbar-box-2 input-group d-xl-flex d-none">
                                        <button class="btn search-icon" type="button">
                                            <i class="iconly-Search icli"></i>
                                        </button>
                                        <input type="text" class="form-control"
                                            placeholder="Search for products, styles,brands..." />
                                        <button class="btn search-button" type="button">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="rightside-menu support-sidemenu">
                                <div class="support-box">
                                    <div class="support-image">
                                        <img src="../assets/images/icon/support.png" class="img-fluid blur-up lazyload"
                                            alt="" />
                                    </div>
                                    <div class="support-number">
                                        <h2>(123) 456 7890</h2>
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
                                    <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link dropdown-toggle ps-0 arrow-none"
                                                href="javascript:void(0)" data-bs-toggle="dropdown">Home</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none"
                                                href="shop-left-sidebar.html">Shop</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none"
                                                href="product-left-thumbnail.html">Product</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none"
                                                href="blog-grid.html">Blog</a>
                                        </li>
                                        <li class="nav-item dropdown new-nav-item">
                                            <a class="nav-link dropdown-toggle arrow-none" href="about-us.html">About
                                                us</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                data-bs-toggle="dropdown">Authentication</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="login.html">Login</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="sign-up.html">Register</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="otp.html">Verify OTP</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="forgot.html">Forget Password</a>
                                                </li>
                                            </ul>
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
                                            <a href="checkout.html"
                                                class="btn btn-sm cart-button theme-bg-color text-white">Checkout</a>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <a href="cart.html" class="header-icon bag-icon">
                                        <small class="badge-number badge-light">2</small>
                                        <i class="iconly-Bag-2 icli"></i>
                                    </a>
                                </li>
                            </ul>

                            <a href="user-dashboard.html" class="user-box">
                                <span class="header-icon">
                                    <i class="iconly-Profile icli"></i>
                                </span>
                                <div class="user-name">
                                    <h6 class="text-content">My Account</h6>
                                    <h4 class="mt-1">Jennifer V. Ward</h4>
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
                <a href="index.html">
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
                        <a href="index.html" class="foot-logo theme-logo">
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
                                <a href="user-dashboard.html" class="light-text">Your Account</a>
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
                        <img src="../assets/images/icon/paymant/visa.png" class="blur-up lazyload"
                            alt="" />
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
    <div class="modal fade theme-modal view-modal" id="view" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-sm-4 g-2">
                        <div class="col-lg-6">
                            <div class="slider-image">
                                <img src="../assets/images/product/category/1.jpg"
                                    class="img-fluid blur-up lazyload" alt="" />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="right-sidebar-modal">
                                <h4 class="title-name">
                                    Peanut Butter Bite Premium Butter Cookies 600 g
                                </h4>
                                <h4 class="price">$36.99</h4>
                                <div class="product-rating">
                                    <ul class="rating">
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star"></i>
                                        </li>
                                    </ul>
                                    <span class="ms-2">8 Reviews</span>
                                    <span class="ms-2 text-danger">6 sold in last 16 hours</span>
                                </div>

                                <div class="product-detail">
                                    <h4>Product Details :</h4>
                                    <p>
                                        Candy canes sugar plum tart cotton candy chupa chups sugar
                                        plum chocolate I love. Caramels marshmallow icing dessert
                                        candy canes I love soufflé I love toffee. Marshmallow pie
                                        sweet sweet roll sesame snaps tiramisu jelly bear claw.
                                        Bonbon muffin I love carrot cake sugar plum dessert
                                        bonbon.
                                    </p>
                                </div>

                                <ul class="brand-list">
                                    <li>
                                        <div class="brand-box">
                                            <h5>Brand Name:</h5>
                                            <h6>Black Forest</h6>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="brand-box">
                                            <h5>Product Code:</h5>
                                            <h6>W0690034</h6>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="brand-box">
                                            <h5>Product Type:</h5>
                                            <h6>White Cream Cake</h6>
                                        </div>
                                    </li>
                                </ul>

                                <div class="select-size">
                                    <h4>Cake Size :</h4>
                                    <select class="form-select select-form-size">
                                        <option selected>Select Size</option>
                                        <option value="1.2">1/2 KG</option>
                                        <option value="0">1 KG</option>
                                        <option value="1.5">1/5 KG</option>
                                        <option value="red">Red Roses</option>
                                        <option value="pink">With Pink Roses</option>
                                    </select>
                                </div>

                                <div class="modal-button">
                                    <button onclick="location.href = 'cart.html';"
                                        class="btn btn-md add-cart-button icon">
                                        Add To Cart
                                    </button>
                                    <button onclick="location.href = 'product-left.html';"
                                        class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                        View More Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="{{url('assets')}}/js/jquery-3.6.0.min.js"></script>
    <script src="{{url('assets')}}/js/jquery-ui.min.js"></script>
    <script src="{{url('assets')}}/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="{{url('assets')}}/js/bootstrap/bootstrap-notify.min.js"></script>
    <script src="{{url('assets')}}/js/bootstrap/popper.min.js"></script>
    <script src="{{url('assets')}}/js/feather/feather.min.js"></script>
    <script src="{{url('assets')}}/js/feather/feather-icon.js"></script>
    <script src="{{url('assets')}}/js/lazysizes.min.js"></script>
    <script src="{{url('assets')}}/js/slick/slick.js"></script>
    <script src="{{url('assets')}}/js/slick/slick-animation.min.js"></script>
    <script src="{{url('assets')}}/js/custom-slick-animated.js"></script>
    <script src="{{url('assets')}}/js/slick/custom_slick.js"></script>
    <script src="{{url('assets')}}/js/ion.rangeSlider.min.js"></script>
    <script src="{{url('assets')}}/js/auto-height.js"></script>
    <script src="{{url('assets')}}/js/lazysizes.min.js"></script>
    <script src="{{url('assets')}}/js/quantity-2.js"></script>
    <script src="{{url('assets')}}/js/fly-cart.js"></script>
    <script src="{{url('assets')}}/js/timer1.js"></script>
    <script src="{{url('assets')}}/js/timer2.js"></script>
    <script src="{{url('assets')}}/js/clipboard.min.js"></script>
    <script src="{{url('assets')}}/js/copy-clipboard.js"></script>
    <script src="{{url('assets')}}/js/wow.min.js"></script>
    <script src="{{url('assets')}}/js/custom-wow.js"></script>
    <script src="{{url('assets')}}/js/script.js"></script>
</body>

</html>
