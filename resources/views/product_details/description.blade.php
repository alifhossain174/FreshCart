<div class="product-section-box">
    <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                data-bs-target="#description" type="button" role="tab"
                aria-controls="description" aria-selected="true">
                Description
            </button>
        </li>

        @if($product->specification)
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="false">
                Specification
            </button>
        </li>
        @endif

        @if($product->warrenty_policy)
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="care-tab" data-bs-toggle="tab" data-bs-target="#care" type="button" role="tab" aria-controls="care" aria-selected="false">
                Warrenty Policy
            </button>
        </li>
        @endif

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">
                Review
            </button>
        </li>
    </ul>

    <div class="tab-content custom-tab" id="myTabContent">
        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
            <div class="product-description">
                {!! $product->description !!}
            </div>
        </div>

        @if($product->specification)
        <div class="tab-pane fade" id="info" role="tabpanel"  aria-labelledby="info-tab">
            {!! $product->specification !!}
        </div>
        @endif

        @if($product->warrenty_policy)
        <div class="tab-pane fade" id="care" role="tabpanel" aria-labelledby="care-tab">
            {!! $product->warrenty_policy !!}
        </div>
        @endif

        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
            @include('product_details.review')
        </div>
    </div>
</div>
