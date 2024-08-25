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
                'google_tag_manager_status',
                'google_tag_manager_id',
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

@section('header_css')
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/select2.css" />
    <style>
        .select2-selection {
            height: 34px !important;
            border: 1px solid #ced4da !important;
        }

        .select2 {
            width: 100% !important;
        }

        .select2 .selection {
            width: 100%;
        }

        .select2-selection {
            height: 42px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 22px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 6px !important;
        }

        .select-style-2 .nice-select .list {
            max-height: 240px;
            overflow: scroll;
        }

        .select2-results__option {
            font-size: 16px;
        }

        .address_box {
            border: 1px solid #9cbedf;
            border-radius: 8px;
            padding: 5px 12px;
            box-shadow: inset 1px 1px 3px #57575747;
            cursor: pointer;
        }

        .address_box label {
            cursor: pointer;
        }

        address {
            margin-bottom: 0px;
            line-height: 20px;
            font-size: 14px;
        }

        .c-personal-details-box .form-group input {
            color: #1e1e1e;
            font-weight: 500;
        }

        .c-personal-details-box .form-group input::placeholder {
            color: lightgray;
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
    @include('checkout.breadcrumbs')

    <!-- Checkout Page Area -->
    <section class="checkout-area">
        <div class="container">

            @guest
                <div class="checkout-alert">
                    <div class="container">
                        <div class="checkout-alert-inner">
                            <h5 class="checkout-alert-text" style="font-size: 16px">
                                Have any account? please login or register
                            </h5>
                            <div class="checkout-alert-action">
                                <a href="{{ url('/login') }}" class="c-alert-btn">Login</a>
                                <a href="{{ url('/register') }}" class="c-alert-btn primary">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endguest

            <form action="{{ url('place/order') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-xl-4 col-12">
                        <div class="checkout-order-review">
                            <h5 class="checkout-widget-title">Order review</h5>
                            <div class="checkout-order-review-inner">
                                @include('checkout.cart_items')
                            </div>
                        </div>
                    </div>

                    @include('checkout.order_form')

                </div>
            </form>

        </div>
    </section>
    <!-- End Checkout Page Area -->
@endsection

@section('footer_js')
    <script src="{{ url('assets') }}/js/select2.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });

        function applySavedAddress(slug) {

            // fetching the values
            var address = $("#saved_address_line_" + slug).val();
            var district = $("#saved_address_district_" + slug).val();
            var upazila = $("#saved_address_upazila_" + slug).val();
            var post_code = $("#saved_address_post_code_" + slug).val();

            // setting the values
            $("#shipping_address").val(address);
            $("#shipping_district_id option:contains('" + district + "')").prop("selected", true).change();
            setTimeout(function() {
                $("#shipping_thana_id option:contains('" + upazila + "')").prop("selected", true).change();
            }, 1000);
            $("#shipping_postal_code").val(post_code);

            var isChecked = $('#flexCheckChecked').prop('checked');
            if (isChecked) {
                $('#flexCheckChecked').trigger('click');
            }

        }

        function removeCartItems(id) {
            $.get("{{ url('remove/cart/item') }}" + '/' + id, function(data) {

                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.error("Item is Removed");
                // $(".offCanvas__minicart").html(data.rendered_cart);
                $("a.bag-icon small.badge-number").html(data.cartTotalQty);

                $(".checkout-order-review-inner").html(data.checkoutCartItems);
                // $(".order-review-summary").html(data.checkoutTotalAmount);

                if (data.cartTotalQty <= 0) {
                    setTimeout(function() {
                        window.location.href = '{{ url('/') }}';
                    }, 1000);
                }
            })
        }

        function userMaximumPoints(points) {
            var checkbox = document.getElementById("use_maximum");
            if (checkbox.checked) {
                $("#reward_points_used").val(points);
            } else {
                $("#reward_points_used").val("");
            }
        }

        function useRewardPoints() {

            var rewardPoints = Number($("#reward_points_used").val());
            if (isNaN(rewardPoints)) {
                toastr.error("Please Enter a Number as Reward Points");
                return false;
            }

            var formData = new FormData();
            formData.append("reward_points", rewardPoints);
            $.ajax({
                data: formData,
                url: "{{ url('apply/for/reward/points') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status == 0) {
                        toastr.error(data.message);
                        $(".order-review-summary").html(data.checkoutTotalAmount);
                    } else {
                        toastr.success(data.message);
                        $(".order-review-summary").html(data.checkoutTotalAmount);
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    toastr.error("Something Went Wrong", "Try Again");
                }
            });
        }

        function changeDeliveryMethod(value) {

            var district_id = $("#shipping_district_id").val();
            var delivery_method = value;

            $.ajax({
                url: "{{ url('/change/delivery/method') }}",
                type: "POST",
                data: {
                    district_id: district_id,
                    delivery_method: delivery_method,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $(".order-review-summary").html(result.checkoutTotalAmount);
                }
            });
        }

        function applyCoupon() {
            var couponCode = $("#coupon_code").val();
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.options.timeOut = 1000;

            if (couponCode == '') {
                toastr.error("Please Enter a Coupon Code");
                return false;
            }

            var formData = new FormData();
            formData.append("coupon_code", couponCode);
            $.ajax({
                data: formData,
                url: "{{ url('apply/coupon') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status == 0) {
                        toastr.error(data.message);
                        $("#applied_coupon").html(data.appliedCoupon);
                        $(".order-review-summary").html(data.checkoutTotalAmount);
                    } else {
                        toastr.success(data.message);
                        $("#applied_coupon").html(data.appliedCoupon);
                        $(".order-review-summary").html(data.checkoutTotalAmount);
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        }

        function removeAppliedCoupon() {
            $.get("{{ url('remove/applied/coupon') }}", function(data) {
                toastr.error("Coupon Removed");
                $("#coupon_code").val("");
                $("#applied_coupon").html(data.appliedCoupon);
                $(".order-review-summary").html(data.checkoutTotalAmount);
            })
        }

        function togglePasswordVisibility(inputId) {
            const inputElement = document.getElementById(inputId);
            const iconElement = document.getElementById(inputId + "Icon");
            if (inputElement.type === "password") {
                inputElement.type = "text";
                iconElement.classList.remove("fa-eye-slash");
                iconElement.classList.add("fa-eye");
            } else {
                inputElement.type = "password";
                iconElement.classList.remove("fa-eye");
                iconElement.classList.add("fa-eye-slash");
            }
        }

        function validateAllOrderFields() {

            var shppingAdress = $("#shipping_address").val();
            var shppingDistrict = $("#shipping_district_id").val();
            var shippingThana = $("#shipping_thana_id").val();

            if (shppingAdress == '' || shppingAdress == null) {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Write Shipping Address");
                return false;
            }
            if (!shppingDistrict || shppingDistrict == "" || shppingDistrict == null) {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Select Shipping District");
                return false;
            }
            if (shippingThana == '' || shippingThana == null) {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Select Shipping Thana");
                return false;
            }

            const phoneNumber = $("#customer_phone_no").val();
            if (isValidBangladeshPhone(phoneNumber)) {
                $("#actual_order_place_btn").click();
            } else {
                toastr.error("Invalid Phone No");
                return false;
            }

        }

        function isValidBangladeshPhone(phoneNumber) {
            // Regular expression for Bangladeshi phone numbers
            const regex = /^(?:\+?88|0088)?01[3-9]\d{8}$/;
            // Test the phone number against the regular expression
            return regex.test(phoneNumber);
        }

        $(document).ready(function() {
            $('#shipping_district_id').on('change', function() {
                var district_id = this.value;
                $("#shipping_thana_id").html('');
                $.ajax({
                    url: "{{ url('/district/wise/thana') }}",
                    type: "POST",
                    data: {
                        district_id: district_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#shipping_thana_id').html(
                            '<option data-display="Select One" value="">Select Thana</option>'
                        );
                        $.each(result.data, function(key, value) {
                            $("#shipping_thana_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $(".order-review-summary").html(result.checkoutTotalAmount);
                    }
                });
            });

            $('#billing_district_id').on('change', function() {
                var district_id = this.value;
                $("#billing_thana_id").html('');
                $.ajax({
                    url: "{{ url('/district/wise/thana') }}",
                    type: "POST",
                    data: {
                        district_id: district_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#billing_thana_id').html(
                            '<option data-display="Select One" value="">Select Thana</option>'
                        );
                        $.each(result.data, function(key, value) {
                            $("#billing_thana_id").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
