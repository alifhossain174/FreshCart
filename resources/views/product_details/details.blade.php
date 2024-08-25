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
    <meta name="author" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta name="copyright" content="{{ $generalInfo ? $generalInfo->company_name : '' }}">
    <meta name="url" content="{{ env('APP_URL') }}">

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

    <!-- Open Graph general (Facebook, Pinterest)-->
    <meta property="og:title"
        content="@if ($generalInfo && $generalInfo->meta_og_title) {{ $generalInfo->meta_og_title }} @else {{ $generalInfo->company_name }} @endif" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ env('ADMIN_URL') . '/' . $generalInfo->meta_og_image }}" />
    <meta property="og:site_name" content="{{ $generalInfo ? $generalInfo->company_name : '' }}" />
    <meta property="og:description" content="{{ $generalInfo->meta_og_description }}" />
    <!-- End Open Graph general (Facebook, Pinterest)-->
@endpush

@section('header_css')
    <style>
        .product-variation-form input[type="radio"] {
            clip: rect(0, 0, 0, 0);
            overflow: hidden;
            position: absolute;
            height: 1px;
            width: 1px;
        }

        .product-variation-form input[type="radio"]:checked+label {
            border: 3px solid white !important;
            box-shadow: none !important;
            outline: 2px solid var(--theme-color);;
        }

        .product-variation-form .variant__color--value {
            width: 1.5rem !important;
            height: 1.5rem;
            padding: 2px;
            display: inline-block;
            border-radius: 50%;
            margin-right: 5px;
            line-height: 1;
            cursor: pointer;
            overflow: hidden;
        }

        .product-size-swatch label.variant__size--value {
            background: transparent;
            /* width: 20px !important; */
            max-width: 55px;
            margin-right: 5px;
            border: 1px solid gray;
            color: #1e1e1e;
            font-weight: 400;
            border-radius: 4px;
            padding: 5px;
        }

        .product-single .product-form label {
            display: block;
            max-width: 7.5rem;
            flex: 0 0 7.5rem;
            padding: 0.6rem 0;
            font-size: 1.4rem;
            color: black;
            line-height: 1;
        }
    </style>
@endsection

@section('content')
    @include('product_details.breadcrumb')

    <!-- Product Left Sidebar Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                    <div class="row g-4">
                        <div class="col-xl-6 wow fadeInUp">
                            @include('product_details.gallery')
                        </div>

                        <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="right-box-contain">
                                <h2 class="name">{{ $product->name }}</h2>

                                @php
                                    $totalStockAllVariants = $product->stock; // jekonon variant er at least ekta stock e thakleo stock in dekhabe
                                    if ($variants && count($variants) > 0) {
                                        $variantMinDiscountPrice = 0;
                                        $variantMinPrice = 0;
                                        $variantMinDiscountPriceArray = [];
                                        $variantMinPriceArray = [];
                                        $totalStockAllVariants = 0;

                                        foreach ($variants as $variant) {
                                            $variantMinDiscountPriceArray[] = $variant->discounted_price;
                                            $variantMinPriceArray[] = $variant->price;
                                            $totalStockAllVariants = $totalStockAllVariants + (int) $variant->stock;
                                        }

                                        $variantMinDiscountPrice = min($variantMinDiscountPriceArray);
                                        $variantMinPrice = min($variantMinPriceArray);
                                    }
                                @endphp

                                <div class="price-rating">
                                    @include('product_details.price')
                                    @include('product_details.rating')
                                </div>

                                @include('product_details.short_description')
                                @include('product_details.offer')


                                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                <div class="product-packege" style="padding-top: 20px;">
                                    @if ($variants && count($variants) > 0)

                                        @php
                                            $colorCheckArray = [];
                                            $colorChecked = [];
                                            $colorArray = [];
                                            foreach ($variants as $variant) {
                                                if ($variant->color_id) {
                                                    $colorCheckArray[] = $variant->color_id;
                                                }
                                                if ($variant->color_id && !in_array($variant->color_id, $colorChecked)) {
                                                    $colorChecked[] = $variant->color_id;
                                                }
                                            }
                                        @endphp

                                        @if (count($colorCheckArray) > 0)
                                            <div class="product-form product-variation-form product-color-swatch">
                                                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Select Color :</label>
                                                @foreach ($variants as $variant)
                                                    @if ($variant->color_code && !in_array($variant->color_code, $colorArray))
                                                        @php $colorArray[] = $variant->color_code; @endphp
                                                        <input id="option_color_{{ $variant->color_id }}" name="color_id[]" value="{{ $variant->color_id }}" type="radio" onchange="checkVariantStock()" class="btn-check" @if (count($colorChecked) == 1) checked="checked" @endif />
                                                        <label class="variant__color--value btn" style="background: {{ $variant->color_code }};" for="option_color_{{ $variant->color_id }}" title="{{ $variant->color_name }}"></label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif

                                        @if ($configSetup[0]->status == 1)
                                            @php
                                                $sizeCheckArray = [];
                                                $sizeChecked = [];
                                                $sizeArray = [];
                                                foreach ($variants as $variant) {
                                                    if ($variant->size_id) {
                                                        $sizeCheckArray[] = $variant->size_id;
                                                    }
                                                    if ($variant->size_id && !in_array($variant->size_id, $sizeChecked)) {
                                                        $sizeChecked[] = $variant->size_id;
                                                    }
                                                }
                                            @endphp

                                            @if (count($sizeCheckArray) > 0)
                                                <div class="product-form product-variation-form product-size-swatch">
                                                    <label style="display: block; font-weight: 600; margin-bottom: 5px; margin-top: 15px">Select Size : </label>
                                                    @foreach ($variants as $variant)
                                                        @if ($variant->size_id && !in_array($variant->size_id, $sizeArray))
                                                            @php $sizeArray[] = $variant->size_id; @endphp
                                                            <input id="option_size_{{ $variant->size_id }}"
                                                                onchange="checkVariantStock()" value="{{ $variant->size_id }}"
                                                                name="size_id[]" type="radio"
                                                                @if (count($sizeChecked) == 1) checked @endif
                                                                class="btn-check" autocomplete="off" />
                                                            <label class="variant__size--value" style="cursor: pointer" for="option_size_{{ $variant->size_id }}">{{ $variant->size_name }}</label>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif

                                    @endif
                                </div>


                                <div id="product_details_add_to_cart_section">
                                    @if ($variants && count($variants) > 0)
                                        @if ($totalStockAllVariants && $totalStockAllVariants > 0)
                                            @include('product_details.cart_buy_button')
                                        @else
                                            <button class="btn btn-md bg-danger cart-button text-white w-100 mt-3">Stock Out</button>
                                        @endif
                                    @else
                                        @if ($product->stock && $product->stock > 0)
                                            @include('product_details.cart_buy_button')
                                        @else
                                            <button class="btn btn-md bg-danger cart-button text-white w-100 mt-3">Stock Out</button>
                                        @endif
                                    @endif
                                </div>

                                @include('product_details.short_info', ['totalStockAllVariants' => $totalStockAllVariants])

                            </div>
                        </div>

                        <div class="col-12">
                            @include('product_details.description')
                        </div>

                    </div>
                </div>

                @include('product_details.right_sidebar')

            </div>
        </div>
    </section>
    <!-- Product Left Sidebar End -->

    @include('product_details.vendor_products')
    @include('product_details.related_products')

@endsection

@section('footer_js')
    <script>
        function checkVariantStock() {

            let color_id = null;
            let size_id = null;

            // color
            let colorFields = document.getElementsByName("color_id[]");
            for (let i = 0; i < colorFields.length; i++) {
                if (colorFields[i].checked) {
                    // const swiper3 = document.querySelector('.swiper-container').swiper;
                    // swiper3.slideTo(i);
                    color_id = colorFields[i].value;
                }
            }

            // size
            let sizeFields = document.getElementsByName("size_id[]");
            for (let i = 0; i < sizeFields.length; i++) {
                if (sizeFields[i].checked) {
                    size_id = sizeFields[i].value;
                }
            }

            // sending request
            var formData = new FormData();
            formData.append("product_id", $("#product_id").val());
            formData.append("color_id", color_id);
            formData.append("size_id", size_id);

            $.ajax({
                data: formData,
                url: "{{ url('check/product/details/variant') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    if (Number(data.discounted_price) > 0) {
                        $("h3.price del").html('৳ ' + data.price);
                        $("em.product-price").html('৳ ' + data.discounted_price);
                        $("#product_price").val(Number(data.discounted_price));
                    } else {
                        $("h3.price del").html("");
                        $("em.product-price").html('৳ ' + data.price);
                        $("#product_price").val(Number(data.price));
                    }

                    if (data.stock > 0) {
                        $("#product_details_add_to_cart_section").html(data.rendered_button)
                    } else {
                        toastr.options.positionClass = 'toast-bottom-right';
                        toastr.options.timeOut = 1000;
                        toastr.error("Stock Out");
                        $("#product_details_add_to_cart_section").html("<button class='btn btn-md bg-danger cart-button text-white w-100 mt-3'>Stock Out</button>")
                    }

                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });

        }

        $('body').on('click', '.qty-right-plus2', function() {
            var plusButton = document.querySelector('.qty-right-plus2');
            var quantityInput = document.getElementById('product_details_cart_qty');
            // Add event listener for the plus button
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });

        $('body').on('click', '.qty-left-minus2', function() {
            var minusButton = document.querySelector('.qty-left-minus2');
            var quantityInput = document.getElementById('product_details_cart_qty');
            // Add event listener for the minus button
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });


        $('body').on('click', '.addToCartWithQty', function() {
            var id = $(this).data('id');

            let color_id = null;
            let size_id = null;
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.options.timeOut = 1000;

            // color
            let colorFields = document.getElementsByName("color_id[]");
            for (let i = 0; i < colorFields.length; i++) {
                if (colorFields[i].checked) {
                    color_id = colorFields[i].value;
                }
            }
            if (colorFields.length > 0 && color_id == null) {
                toastr.error("Please Select Color");
                return false;
            }

            // size
            let sizeFields = document.getElementsByName("size_id[]");
            for (let i = 0; i < sizeFields.length; i++) {
                if (sizeFields[i].checked) {
                    size_id = sizeFields[i].value;
                }
            }
            if (sizeFields.length > 0 && size_id == null) {
                toastr.error("Please Select Size");
                return false;
            }


            // sending request
            var formData = new FormData();
            formData.append("product_id", Number($("#product_id").val()));
            formData.append("qty", Number($("#product_details_cart_qty").val()));
            formData.append("price", Number($("#product_price").val()));
            formData.append("discount_price", Number($("#product_discount_price").val()));
            formData.append("color_id", color_id);
            formData.append("size_id", size_id);


            $.ajax({
                data: formData,
                url: "{{ url('add/to/cart/with/qty') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.success("Added to Cart");
                    $("a.bag-icon small.badge-number").html(data.cartTotalQty);
                    // $("#dropdown_box_sidebar_cart").html(data.rendered_cart);
                    // $("span.cart-count").html(data.cartTotalQty);

                },
                error: function(data) {
                    toastr.error("Something Went Wrong");
                }
            });

            $(this).html("Remove from Cart");
            $(this).removeClass("addToCartWithQty");
            $(this).removeClass("bg-dark");
            $(this).addClass("bg-danger");
            $(this).addClass("removeFromCartQty");
            $(this).blur();
        });

        $('body').on('click', '.removeFromCartQty', function() {
            var id = $(this).data('id');
            $.get("{{ url('remove/cart/item') }}" + '/' + id, function(data) {

                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.error("Removed from cart");
                $("a.bag-icon small.badge-number").html(data.cartTotalQty);

            })

            $("#product_details_cart_qty").val(1);
            $(this).html("Add to cart");
            $(this).removeClass("removeFromCartQty");
            $(this).addClass("addToCartWithQty");
            $(this).removeClass("bg-danger");
            $(this).addClass("bg-dark");
            $(this).blur();
        });
    </script>
@endsection
