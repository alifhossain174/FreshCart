<div class="accordion-item">
    <h2 class="accordion-header" id="headingFour">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true"
            aria-controls="collapseFour">
            <span>Brand</span>
        </button>
    </h2>
    <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour">
        <div class="accordion-body">
            <ul class="category-list custom-padding custom-height">
                @foreach ($brands as $brand)
                <li>
                    <div class="form-check ps-0 m-0 category-list-box">
                        <input class="checkbox_animated" type="checkbox" id="{{$brand->slug}}" value="{{$brand->slug}}" name="filter_brand[]" @if(isset($brandSlug) && in_array($brand->slug, explode(",", $brandSlug))) checked @endif onchange="filterProducts()">
                        <label class="form-check-label" for="{{$brand->slug}}">
                            <span class="name">{{ $brand->name }}</span>
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
