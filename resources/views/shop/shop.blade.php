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
        nav.custome-pagination ul.pagination {
            justify-content: center !important;
        }
        .category-list li .category-list-box input{
            margin-top: 0px;
        }
    </style>
@endsection

@section('content')

    @include('shop.breadcrumb')
    @include('shop.banner')

    <input type="hidden" id="filter_store_slug" @if ($storeInfo) value="{{ $storeInfo->slug }}" @endif>

    <!-- Shop Section Start -->
    <section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-custome-3">
                    <div class="left-box wow fadeInUp">
                        <div class="shop-left-sidebar">
                            <div class="back-button">
                                <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                            </div>

                            <div class="accordion custome-accordion" id="accordionExample">

                                @include('shop.filter_category')
                                @include('shop.filter_flag')
                                @include('shop.filter_price')
                                @include('shop.filter_brand')
                                @include('shop.filter_size')
                                @include('shop.filter_color')

                                <input type="hidden" id="filter_subcategory_slug" @if (isset($subcategorySlug)) value="{{ $subcategorySlug }}" @endif>
                                <input type="hidden" id="filter_childcategory_slug" @if (isset($childcategorySlug)) value="{{ $childcategorySlug }}" @endif>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-custome-9">
                    <div class="show-button">
                        <div class="filter-button-group mt-0">
                            <div class="filter-button d-inline-block d-lg-none">
                                <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                            </div>
                        </div>

                        <div class="top-filter-menu">
                            @include('shop.filter_sorting')
                            @include('shop.grid_option')
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12" id="product_wrapper">
                            @include('shop.products')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

@endsection


@section('footer_js')
    <script>
        function filterProducts() {

            // fetching filter values
            let category_array = [];
            let flag_array = [];
            let brand_array = [];
            let size_array = [];
            let color_array = [];

            $("input[name='filter_category[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!category_array.includes($(this).val())) {
                        category_array.push($(this).val());
                    }
                }
            });
            $("input[name='filter_flag[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!flag_array.includes($(this).val())) {
                        flag_array.push($(this).val());
                    }
                }
            });
            $("input[name='filter_brand[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!brand_array.includes($(this).val())) {
                        brand_array.push($(this).val());
                    }
                }
            });
            $("input[name='filter_size[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!size_array.includes($(this).val())) {
                        size_array.push($(this).val());
                    }
                }
            });
            $("input[name='filter_color[]']").each(function() {
                if ($(this).is(':checked')) {
                    if (!color_array.includes($(this).val())) {
                        color_array.push($(this).val());
                    }
                }
            });

            let category_slugs = String(category_array);
            let subcategory_slug = $("#filter_subcategory_slug").val();
            let childcategory_slug = $("#filter_childcategory_slug").val();
            let flag_slugs = String(flag_array);
            let brand_slugs = String(brand_array);
            let size_slugs = String(size_array);
            let color_ids = String(color_array);
            var sort_by = Number($("#filter_sort_by").val());
            var min_price_range = Number($("#filter_min_price").val());
            var max_price_range = Number($("#filter_max_price").val());
            var search_keyword = $("#search_keyword").val();
            var store_slug = $("#filter_store_slug").val();


            // setting up get url with filter parameters
            var baseUrl = window.location.pathname;

            if (store_slug) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&store=' + store_slug : baseUrl += '?store=' + store_slug;
            }
            if (category_slugs) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&category=' + category_slugs : baseUrl += '?category=' +
                    category_slugs;
            }
            if (subcategory_slug) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&subcategory=' + subcategory_slug : baseUrl += '?subcategory=' +
                    subcategory_slug;
            }
            if (childcategory_slug) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&childcategory=' + childcategory_slug : baseUrl +=
                    '?childcategory=' + childcategory_slug;
            }
            if (flag_slugs) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&flag=' + flag_slugs : baseUrl += '?flag=' + flag_slugs;
            }
            if (brand_slugs) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&brand=' + brand_slugs : baseUrl += '?brand=' + brand_slugs;
            }
            if (size_slugs) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&size=' + size_slugs : baseUrl += '?size=' + size_slugs;
            }
            if (color_ids) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&color=' + color_ids : baseUrl += '?color=' + color_ids;
            }
            if (sort_by && sort_by > 0) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&sort_by=' + sort_by : baseUrl += '?sort_by=' + sort_by;
            }
            if (min_price_range && min_price_range > 0) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&min_price=' + min_price_range : baseUrl += '?min_price=' +
                    min_price_range;
            }
            if (max_price_range && max_price_range > 0) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&max_price=' + max_price_range : baseUrl += '?max_price=' +
                    max_price_range;
            }
            if (search_keyword) {
                baseUrl.indexOf('?') !== -1 ? baseUrl += '&search_keyword=' + search_keyword : baseUrl +=
                    '?search_keyword=' + search_keyword;
            }
            history.pushState(null, null, baseUrl);


            // sending request
            var formData = new FormData();
            formData.append("category", category_slugs);
            formData.append("subcategory", subcategory_slug);
            formData.append("childcategory", childcategory_slug);
            formData.append("flag", flag_slugs);
            formData.append("brand", brand_slugs);
            formData.append("size", size_slugs);
            formData.append("color", color_ids);
            formData.append("sort_by", sort_by);
            formData.append("min_price", min_price_range);
            formData.append("max_price", max_price_range);
            formData.append("search_keyword", search_keyword);
            formData.append("store", store_slug);
            formData.append("path_name", window.location.pathname);


            $.ajax({
                data: formData,
                url: "{{ url('filter/products') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#product_wrapper').fadeOut(function() {
                        $(this).html(data.rendered_view);
                        $(this).fadeIn();
                        renderLazyImage()
                    });
                },
                error: function(data) {
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Something Went Wrong");
                }
            });
        }

        $(".filter-button").click(function () {
            $(".bg-overlay, .left-box").addClass("show");
        });
        $(".back-button, .bg-overlay").click(function () {
            $(".bg-overlay, .left-box").removeClass("show");
        });

        $(document).ready(function () {
            $(".sort-by-button").click(function () {
                $(".top-filter-menu").toggleClass("show");
            });
        });
    </script>
@endsection
