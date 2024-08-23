<div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <span>Product Flag</span>
        </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo">
        <div class="accordion-body">
            <ul class="category-list custom-padding custom-height">
                @foreach ($flags as $flags)
                <li>
                    <div class="form-check ps-0 m-0 category-list-box">
                        <input class="checkbox_animated" type="checkbox" id="{{$flags->slug}}" value="{{$flags->slug}}" name="filter_flag[]" @if(isset($flagSlug) && in_array($flags->slug, explode(",", $flagSlug))) checked @endif onchange="filterProducts()">
                        <label class="form-check-label" for="{{$flags->slug}}">
                            <span class="name">{{ $flags->name }}</span>
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
