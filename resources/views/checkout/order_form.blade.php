<div class="col-lg-6 col-xl-4 col-12">
    <div class="checkout-personal-details single-details-box">

        @php
            if (Auth::user()) {
                $savedAddressed = DB::table('user_addresses')
                    ->where('user_id', Auth::user()->id)
                    ->get();
            }
        @endphp

        @auth
            @if (count($savedAddressed) > 0)
                <div class="single-details-checkout-widget">
                    <h5 class="checkout-widget-title">Saved Addresses</h5>
                    <div class="row gx-1">
                        @foreach ($savedAddressed as $index => $address)
                            <div class="col"
                                @if ($index == 0) style="padding-right: 5px" @else style="padding-left: 5px" @endif>
                                <div class="address_box">
                                    <label for="saved_address_{{ $address->slug }}">
                                        <b class="d-block"><input type="radio" id="saved_address_{{ $address->slug }}"
                                                name="saved_address" onchange="applySavedAddress('{{ $address->slug }}')">
                                            {{ $address->address_type }} Address</b>
                                        <address>{{ $address->address }}, {{ $address->state }}-{{ $address->post_code }},
                                            {{ $address->city }}</address>

                                        <input type="hidden" id="saved_address_line_{{ $address->slug }}"
                                            value="{{ $address->address }}">
                                        <input type="hidden" id="saved_address_district_{{ $address->slug }}"
                                            value="{{ $address->city }}">
                                        <input type="hidden" id="saved_address_upazila_{{ $address->slug }}"
                                            value="{{ $address->state }}">
                                        <input type="hidden" id="saved_address_post_code_{{ $address->slug }}"
                                            value="{{ $address->post_code }}">

                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endauth

        <div class="single-details-checkout-widget">
            <div class="single-details-checkout-widget-head">
                <h5 class="checkout-widget-title m-0">Address</h5>
            </div>
            <div class="c-personal-details-box single-details-box-inner">
                <div class="form-group">
                    <label>Full name</label><input type="text" name="name" placeholder="ex: Mr./Mrs/Miss"
                        @auth value="{{ Auth::user()->name }}" @endauth required="" />
                </div>
                <div class="form-group">
                    <label>Email</label><input type="email" name="email" placeholder="user@email.com"
                        @auth value="{{ Auth::user()->email }}" @endauth />
                </div>
                <div class="form-group">
                    <label>Mobile number</label>
                    <input type="tel" name="phone" id="customer_phone_no" placeholder="ex: 01234567890"
                        @auth value="{{ Auth::user()->phone }}" @endauth required="" />
                </div>
                <div class="form-group">
                    <label>Address</label><input type="text" required="" name="shipping_address"
                        id="shipping_address" @auth value="{{ Auth::user()->address }}" @endauth
                        placeholder="ex: House no. / building / street / area" />
                </div>
                @php
                    $districts = DB::table('districts')->orderBy('name', 'asc')->get();
                @endphp
                <div class="form-group select-style-2">
                    <label>Select city</label>
                    <select name="shipping_district_id" class="select2 hero-search-filter-select"
                        id="shipping_district_id" required>
                        <option data-display="Select One" value="">Select One</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group select-style-2">
                    <label>Select area</label>
                    <select name="shipping_thana_id" class="select2 hero-search-filter-select" id="shipping_thana_id"
                        required>
                        <option data-display="Select One" value="">Select One</option>
                    </select>
                </div>
            </div>

            @guest
                <!-- Create Account Checkbox -->
                <div class="create-account-check accordion" id="accordionExample">
                    <div class="create-account-check accordion-item">
                        <h2 class="create-account-check-header accordion-header" id="headingThree">
                            <button class="create-account-check-button accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                Create account using above information
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="create-account-check-body">
                                <div class="form-group">
                                    <label>Set Password</label>
                                    <div class="form-group-password">
                                        <input type="password" class="form-control" id="password" name="account_password" autocomplete="off" />
                                        <div class="input-group-append">
                                            <div onclick="togglePasswordVisibility('password')">
                                                <i id="passwordIcon" class="fa fa-eye-slash"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endguest

        </div>
    </div>

    <div class="checkout-special-note">
        <h5 class="checkout-widget-title">Special notes</h5>
        <div class="checkout-special-note-box">
            <div class="form-group">
                <textarea name="special_note"></textarea>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6 col-xl-4 col-12">

    <!-- Checkout Payment -->
    <div class="checkout-payment-method single-details-box">
        <div class="single-details-checkout-widget">
            <h5 class="checkout-widget-title">Payment method</h5>
            @php
                $paymentGateways = DB::table('payment_gateways')->get();
            @endphp
            <div class="checkout-payment-method-inner single-details-box-inner">
                <div class="payment-method-input">
                    <label for="flexRadioDefault1">
                        <div class="payment-method-input-main">
                            <input class="form-check-input" type="radio" checked name="payment_method"
                                value="cod" id="flexRadioDefault1" required />
                            Cash On Delivery (COD service)
                        </div>
                    </label>

                    @if ($paymentGateways[0]->status == 1)
                        <label for="flexRadioDefault2">
                            <div class="payment-method-input-main">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    value="sslcommerz" id="flexRadioDefault2" required />
                                SSLCommerz
                            </div>
                            <img alt="SSLCommerz" src="{{ url(env('ADMIN_URL') . '/images/ssl_commerz.png') }}"
                                style="max-width: 90px;" />
                        </label>
                    @endif

                    @if ($paymentGateways[2]->status == 1)
                        <label for="flexRadioDefault3" style="cursor: no-drop;">
                            <div class="payment-method-input-main">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    id="flexRadioDefault3" disabled />
                                bKash Payment
                            </div>
                            <img alt="bKash Payment"
                                src="{{ url(env('ADMIN_URL') . '/images/bkash_payment_gateway.png') }}"
                                style="max-width: 45px;" />
                        </label>
                    @endif

                    @if ($paymentGateways[3]->status == 1)
                        <label for="flexRadioDefault3" style="cursor: no-drop;">
                            <div class="payment-method-input-main">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    id="flexRadioDefault3" disabled />
                                amarPay
                            </div>
                            <img alt="amarPay" src="{{ url(env('ADMIN_URL') . '/images/amar_pay.png') }}"
                                style="max-width: 90px;" />
                        </label>
                    @endif
                </div>
            </div>
        </div>
        <div class="single-details-checkout-widget">
            <h5 class="checkout-widget-title">Delivery method</h5>
            <div class="checkout-payment-method-inner single-details-box-inner">
                <div class="payment-method-input">
                    <label for="flexRadioDefault4">
                        <div class="payment-method-input-main">
                            <input class="form-check-input" type="radio" name="delivery_method"
                                onchange="changeDeliveryMethod(1)" value="1" id="flexRadioDefault4" required />
                            Home delivery
                        </div>
                    </label>
                    <label for="flexRadioDefault5">
                        <div class="payment-method-input-main">
                            <input class="form-check-input" type="radio" name="delivery_method"
                                onchange="changeDeliveryMethod(2)" value="2" id="flexRadioDefault5" required />
                            Store pickup
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Discount Accordion -->
    <div class="checkout-review-table-bottom">
        <div class="checkout-disocunt-accordion accordion" id="accordionExample">

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Have any coupon or gift voucher?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="checkout-order-review-coupon-box">
                            <div class="cart-single-coupon-form">
                                <div class="cart-single-coupon-input">
                                    <input type="text" placeholder="Enter Coupon" name="coupon_code" id="coupon_code" />
                                    <div class="cart-coupon-form-btn">
                                        <button type="button" onclick="applyCoupon()" class="theme-btn hover">
                                            Apply coupon
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="applied_coupon">
                            @include('checkout.applied_coupon')
                        </div>
                    </div>
                </div>
            </div>

            @auth
                @include('checkout.club_points')
            @endauth

        </div>

        <div class="order-review-summary">
            @include('checkout.order_total')
        </div>

    </div>

    <!-- Checkout Bottom  -->
    <div class="checkout-order-review-bottom">
        <div class="row">
            <div class="col-12">
                <div class="checkout-checkbox-details">
                    <input class="form-check-input" type="checkbox" id="flexCheckChecked2" value="" required />
                    <label class="form-check-label" for="flexCheckChecked2">
                        I have read and agree to the <a href="{{ url('terms/of/services') }}" target="_blank">Terms
                            and Conditions</a>, <a href="{{ url('privacy/policy') }}" target="_blank">Privacy
                            Policy</a> & <a href="{{ url('return/policy') }}" target="_blank">Refund and Return
                            Policy</a>.
                    </label>
                </div>
            </div>
            <div class="col-12">
                <div class="checkout-order-review-button">
                    <button type="button" onclick="validateAllOrderFields()" class="theme-btn" style="color: white; font-weight: 600; font-size: 14px; text-transform: uppercase;">
                        Place order
                    </button>
                    <button type="submit" id="actual_order_place_btn" class="theme-btn d-none">
                        Place order
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
