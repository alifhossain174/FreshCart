<div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
            aria-controls="collapseOne">
            <span>Categories</span>
        </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
        <div class="accordion-body">
            <ul class="category-list custom-padding custom-height">
                @foreach ($categories as $category)
                <li>
                    <div class="form-check ps-0 m-0 category-list-box">
                        <input class="checkbox_animated" type="checkbox" id="{{$category->slug}}" value="{{$category->slug}}" name="filter_category[]" @if(isset($categorySlug) && in_array($category->slug, explode(",", $categorySlug))) checked @endif onchange="filterProducts()">
                        <label class="form-check-label" for="{{$category->slug}}">
                            <span class="name">{{ $category->name }}</span>
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
