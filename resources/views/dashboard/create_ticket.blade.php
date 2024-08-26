@extends('master')

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
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/user-pannel.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/uicons.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/icofont.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('user-dashboard-assets') }}/assets/css/plugins/nice-select.css" />
    <style>
        .pagination{
            justify-content: center;
            align-items: center;
        }
        .create-ticket-inner select.form-control{
            font-size: 16px !important;
            height: 45px !important;
            padding: .6rem .8rem !important;
        }
        .create-ticket-inner input.form-control{
            font-size: 16px !important;
            height: 45px !important;
            padding: .6rem .8rem !important;
        }
        .create-ticket-inner button.theme-btn{
            font-size: 14px;
        }
    </style>
@endsection

@push('user_dashboard_menu')
    @include('dashboard.mobile_menu_offcanvus')
@endpush

@section('content')
    <section class="getcom-user-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="getcom-user-body-bg">
                        <img alt="" src="{{ url('assets') }}/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('dashboard.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">

                    <div class="dashboard-create-ticket mgTop24">
                        <div class="dashboard-head-widget style-2 m-0">
                            <h5 class="dashboard-head-widget-title">Create ticket</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn secondary-btn icon-right" href="{{ url('support/tickets') }}"><i class="fi-rr-arrow-left"></i>Back to tickets</a>
                            </div>
                        </div>
                        <div class="create-ticket-inner" style="margin-top: 0px">
                            <form action="{{ url('save/support/ticket') }}" method="post" class="create-ticket-form" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label" for="ticketTitle">Ticket title</label>
                                    <input name="subject" placeholder="Ticket title here" required="" type="text" id="ticketTitle" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="selectTopic">Select topic</label>
                                    <select name="topic" required="" id="selectTopic" class="form-control">
                                        <option value="Select">Select</option>
                                        <option value="General Support">General Support</option>
                                        <option value="Technical Issue">Technical Issue</option>
                                        <option value="Order Issue">Order Issue</option>
                                        <option value="Payment Issue">Payment Issue</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="description">Ticket description</label>
                                    <textarea name="description" rows="3" placeholder="Describe your issues.." required="" id="description" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Upload attachment</label>
                                    <div class="create-ticket-form-upload-image">
                                        <div class="library-photo-input">
                                            <input type="file" name="image" accept="image/*" id="library-photo-input" class="hidden" onchange="uploadLibraryPhoto()">
                                            <label for="library-photo-input">
                                                <i class="fi fi-rr-upload"></i>
                                                <span>Upload photo</span>
                                            </label>
                                        </div>
                                        <div class="upload-image-list upload-img-input">
                                            <div style="position: relative">
                                                <div class="remove-icon" id="remove-icon" style="display: none" onclick="removeImage()">
                                                    <i class="fi fi-rr-cross"></i>
                                                </div>
                                                <img id="uploaded-image" style="display: none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="create-ticket-form-btn">
                                    <button type="submit" class="theme-btn icon-right btn btn-primary">
                                        <i class="fi-br-plus"></i> &nbsp; Create ticket
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer_js')
    <script type="text/javascript">
        function uploadLibraryPhoto() {
            // Get the file that the user selected.
            const fileInput = document.getElementById("library-photo-input");
            const file = fileInput.files[0];

            // Check if a file was selected
            if (file) {
                // Create a new FileReader
                const reader = new FileReader();

                // Set up the onload event handler for the reader
                reader.onload = function() {
                    // Get the element where you want to display the uploaded image.
                    const imageElement = document.getElementById("uploaded-image");

                    // Get the remove icon element
                    const removeIcon = document.getElementById("remove-icon");

                    // Set the source of the image element to the data URL from the FileReader.
                    imageElement.src = reader.result;

                    // Show the image element.
                    imageElement.style.display = "block";

                    // Show the remove icon.
                    removeIcon.style.display = "block";
                };

                // Read the file as a data URL
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            // Get the image element
            const imageElement = document.getElementById("uploaded-image");

            // Get the remove icon element
            const removeIcon = document.getElementById("remove-icon");

            // Hide the image element
            imageElement.style.display = "none";

            // Clear the source (removes the image)
            imageElement.src = "";

            // Hide the remove icon again
            removeIcon.style.display = "none";

            // Reset the file input
            const fileInput = document.getElementById("library-photo-input");
            fileInput.value = "";
        }
    </script>
@endsection
