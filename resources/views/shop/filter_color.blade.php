<div class="accordion-item">
    <h2 class="accordion-header" id="headingSix">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true"
            aria-controls="collapseSix">
            <span>Color</span>
        </button>
    </h2>
    <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix">
        <div class="accordion-body">
            <ul class="category-list custom-padding custom-height">
                @foreach ($colors as $color)
                <li>
                    <div class="form-check ps-0 m-0 category-list-box">
                        <input type="checkbox" id="{{$color->code}}" value="{{$color->id}}" name="filter_color[]" @if(isset($colorId) && in_array($color->id, explode(",", $colorId))) checked @endif onchange="filterProducts()">
                        <label class="form-check-label" for="{{$color->code}}">
                            <span class="name">{{ $color->name }}</span>
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
