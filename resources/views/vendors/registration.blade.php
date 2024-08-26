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
    <link rel="stylesheet" type="text/css" href="{{ url('assets') }}/css/select2.css" />
    <style>
        .select2-selection {
            max-height: 48px;
            height: 48px;
            min-height: 34px !important;
            border: 1px solid transparent !important;
        }

        .select2 {
            width: 100% !important;
        }

        .bootstrap-tagsinput .badge {
            margin: 2px 2px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: #1B69D1;
            border-color: #1B69D1;
            color: white;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2 class="mb-2">Vendor Register</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Vendor Register</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Vendor Register -->
    <div class="vendor-register">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6 col-md-8 col-12">
                    <form class="vendor-register-form" action="{{url('submit/vendor/registration/request')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @honeypot
                        <div class="v-register-form-widget">
                            <h4>Business Information:</h4>
                            <div class="form-group">
                                <label>Business Name *</label>
                                <input type="text" id="business_name" value="{{ old('business_name') }}" name="business_name" class="form-control" placeholder="Business Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="business_category">Business Category<span class="text-danger">*</span></label>
                                <select id="business_category" name="business_category[]" class="select2 form-control" multiple required>
                                    <option value="">Select One</option>
                                    <option value="Apparel & Accessories">Apparel & Accessories</option>
                                    <option value="Automotive">Automotive</option>
                                    <option value="Baby & Toddler">Baby & Toddler</option>
                                    <option value="Beauty & Personal Care">Beauty & Personal Care</option>
                                    <option value="Books & Media">Books & Media</option>
                                    <option value="Food & Beverage">Food & Beverage</option>
                                    <option value="Furniture">Furniture</option>
                                    <option value="Home Appliances">Home Appliances</option>
                                    <option value="Jewelry & Watches">Jewelry & Watches</option>
                                    <option value="Kitchen & Dining">Kitchen & Dining</option>
                                    <option value="Office Supplies">Office Supplies</option>
                                    <option value="Pet Supplies">Pet Supplies</option>
                                    <option value="Sporting Goods & Outdoor">Sporting Goods & Outdoor</option>
                                    <option value="Toys & Games">Toys & Games</option>
                                    <option value="Travel & Luggage">Travel & Luggage</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="trade_license_no">Business Trade License Number</label>
                                <input type="text" id="trade_license_no" value="{{ old('trade_license_no') }}" name="trade_license_no" class="form-control" placeholder="Business Trade License Number"/>
                            </div>
                            <div class="form-group">
                                <label for="business_address">Business Address<span class="text-danger">*</span></label>
                                <input type="text" id="business_address" value="{{ old('business_address') }}" name="business_address" class="form-control" placeholder="Business Address" required/>
                            </div>
                        </div>

                        <div class="v-register-form-widget">
                            <h4>Owner Information:</h4>
                            <div class="form-group">
                                <label for="name">Full Name<span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Full Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone<span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="+8801" required/>
                            </div>
                            <div class="form-group">
                                <label for="email">Login Email<span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="demo@email.com" required/>
                                <div class="invalid-feedback" style="display: block;">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Login Password<span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="*******" required/>
                            </div>
                        </div>

                        <div class="v-register-form-widget">
                            <h4>Attachment:</h4>
                            <div class="form-group">
                                <label for="nid_card">Upload Owner NID card<span class="text-danger">*</span></label>
                                <input type="file" style="padding-left: 20px;" id="nid_card" name="nid_card" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <label for="trade_license">Upload Business Trade License</label>
                                <input type="file" style="padding-left: 20px;" id="trade_license" name="trade_license" class="form-control"/>
                            </div>
                        </div>

                        <button type="submit" class="primary__btn btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Vendor Register -->
@endsection

@section('footer_js')
    <script src="{{ url('assets') }}/js/select2.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endsection
