<div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true"
            aria-controls="collapseThree">
            <span>Price</span>
        </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree">
        <div class="accordion-body">
            <div class="price-range">
                <input type="number" style="width: 40%; padding: 5px 2px;" name="filter_min_price" id="filter_min_price" type="number" @if(isset($min_price)) value="{{$min_price}}" @endif class="min_price text-center" placeholder="min" />
                <span class="delimiter">-</span>
                <input type="number" style="width: 40%; padding: 5px 2px;" name="filter_max_price" id="filter_max_price" @if(isset($max_price)) value="{{$max_price}}" @endif class="max_price text-center" placeholder="max" />
                <button style="width: 85%; padding: 5px 5px; margin-top: 10px; background: var(--theme-color); color: white;" class="btn btn-sm btn-rounded" onclick="filterProducts()">Filter</button>
            </div>
        </div>
    </div>
</div>
