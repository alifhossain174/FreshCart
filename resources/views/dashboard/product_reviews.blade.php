@extends('master')

@section('header_css')
    <link rel="stylesheet" href="{{ url('frontend_assets') }}/css/user-pannel.css" />
@endsection

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
    <style>
        .pagination {
            justify-content: center;
            align-items: center;
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
                        <img alt="" src="{{ url('frontend_assets') }}/assets/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('dashboard.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">

                    <div class="dashboard-product-review mgTop24 mb-4">
                        <div class="dashboard-head-widget style-2" style="margin-bottom: 32px">
                            <h5 class="dashboard-head-widget-title">Product reviews</h5>
                        </div>
                        <div class="product-review-card-inner">

                            @if(count($productReviews) > 0)
                            @foreach ($productReviews as $productReview)
                                <div class="single-product-review-card">
                                    <div class="product-review-card-info">
                                        <div class="product-review-card-img">
                                            <img alt="" src="{{ url(env('ADMIN_URL') . '/' . $productReview->image) }}">
                                        </div>
                                        <h6>{{ $productReview->name }}</h6>
                                    </div>
                                    <div class="product-review-main text-center">
                                        <ul class="product-review-list">
                                            @for ($i = 1; $i <= $productReview->rating; $i++)
                                                <li>
                                                    <img src="{{ url('frontend_assets') }}/assets/images/icons/star.svg" alt="#">
                                                </li>
                                            @endfor
                                            @for ($i = 1; $i <= 5 - $productReview->rating; $i++)
                                                <li>
                                                    <img src="{{ url('frontend_assets') }}/assets/images/icons/star-light.svg" alt="#">
                                                </li>
                                            @endfor
                                        </ul>
                                        @if ($productReview->rating == 5)
                                            <span>Excellent</span>
                                        @elseif($productReview->rating == 4)
                                            <span>Great</span>
                                        @elseif($productReview->rating == 3)
                                            <span>Average</span>
                                        @elseif($productReview->rating = 2)
                                            <span>Poor</span>
                                        @else
                                            <span>Very Bad</span>
                                        @endif
                                    </div>
                                    <div class="product-review-text">
                                        <p>
                                            {{ $productReview->review }}
                                        </p>
                                        @if($productReview->status == 0)
                                        <p class="text-info">Review Status: Pending</p>
                                        @else
                                        <p class="text-success">Review Status: Published</p>
                                        @endif
                                    </div>
                                    <div class="product-review-buttons-group">
                                        <button type="button" class="my-button product-review-btn edit-btn d-inline-block" data-widget-id="widget{{$productReview->id}}"><i class="fi-ss-pencil"></i></button>
                                        <a href="{{url('delete/product/review')}}/{{$productReview->id}}" class="product-review-btn delete-btn d-inline-block"><i class="fi-ss-trash"></i></a>
                                    </div>

                                    <!-- Product Review Edit Form -->
                                    <style>
                                        .product-review-edit-from .nice-select{
                                            line-height: 45px !important;
                                        }
                                    </style>
                                    <div id="widget{{$productReview->id}}" class="widget-box product-review-edit-widget" style="display: none">
                                        <form action="{{url('update/product/review')}}" method="post" class="product-review-edit-from">
                                            @csrf
                                            <input type="hidden" name="product_review_id" value="{{$productReview->id}}">
                                            <div class="product-review-text">
                                                <label class="form-label">Review Rating</label>
                                                <select name="review_rating" required>
                                                    <option value="">Select One</option>
                                                    <option value="1" @if($productReview->rating == 1) selected @endif>★ Very Bad</option>
                                                    <option value="2" @if($productReview->rating == 2) selected @endif>★★ Poor</option>
                                                    <option value="3" @if($productReview->rating == 3) selected @endif>★★★ Average</option>
                                                    <option value="4" @if($productReview->rating == 4) selected @endif>★★★★ Great</option>
                                                    <option value="5" @if($productReview->rating == 5) selected @endif>★★★★★ Excellent</option>
                                                </select>
                                            </div>
                                            <div class="product-review-text">
                                                <label class="form-label">Review text</label>
                                                <textarea name="review_text" class="form-control" required>{{$productReview->review}}</textarea>
                                            </div>
                                            <div class="product-review-edit-widget-btn">
                                                <button type="button" class="theme-btn secondary-btn btn btn-primary" onclick="hideWidget({{$productReview->id}})">Discard</button>
                                                <button type="submit" class="theme-btn btn btn-primary">Update review</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            @endforeach
                            @else
                                <h5 class="text-center">No Review Found</h5>
                            @endif


                        </div>
                    </div>

                    {{$productReviews->links()}}

                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer_js')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Get all elements with the class 'my-button' and all elements with the class 'widget-box'
            var buttons = document.querySelectorAll(".my-button");
            var widgets = document.querySelectorAll(".widget-box");

            // Add click event listener to each button
            buttons.forEach(function(button) {
                button.addEventListener("click", function() {
                    // Hide all widgets
                    widgets.forEach(function(widget) {
                        widget.style.display = "none";
                    });

                    // Get the widget associated with the clicked button
                    var widgetId = button.getAttribute("data-widget-id");
                    var targetWidget = document.getElementById(widgetId);

                    // Toggle the visibility of the target widget
                    if (
                        targetWidget.style.display === "none" ||
                        targetWidget.style.display === ""
                    ) {
                        targetWidget.style.display = "block";
                    } else {
                        targetWidget.style.display = "none";
                    }
                });
            });
        });

        function hideWidget(id){
            $("#widget"+id).css('display', 'none');
        }
    </script>
@endsection
