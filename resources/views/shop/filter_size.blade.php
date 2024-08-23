<div class="accordion-item">
    <h2 class="accordion-header" id="headingFive">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false"
            aria-controls="collapseFive">
            <span>Size</span>
        </button>
    </h2>
    <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive">
        <div class="accordion-body">
            <ul class="category-list custom-padding custom-height">
                @foreach ($sizes as $size)
                <li>
                    <div class="form-check ps-0 m-0 category-list-box">
                        <input type="checkbox" id="{{$size->slug}}" value="{{$size->slug}}" name="filter_size[]" @if(isset($sizeSlug) && in_array($size->slug, explode(",", $sizeSlug))) checked @endif onchange="filterProducts()">
                        <label class="form-check-label" for="{{$size->slug}}">
                            <span class="name">{{ $size->name }}</span>
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
