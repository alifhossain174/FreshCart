<div>
    <div class="category-menu">
        <h3>Products you may like</h3>

        <ul class="product-list product-right-sidebar border-0 p-0">

            @foreach($mayLikedProducts as $mayLikedProduct)
            <li>
                <div class="offer-product">
                    <a href="product-left-thumbnail.html" class="offer-image">
                        <img src="{{env('ADMIN_URL')."/".$mayLikedProduct->image}}" class="img-fluid blur-up lazyload" alt="" />
                    </a>
                    <div class="offer-detail">
                        <div>
                            <a href="product-left-thumbnail.html">
                                <h6 class="name">{{$mayLikedProduct->name}}</h6>
                            </a>
                            <span>{{$mayLikedProduct->category_name}}</span>
                            <h6 class="price theme-color">@if($mayLikedProduct->discount_price > 0)৳{{$mayLikedProduct->discount_price}} <del><small>৳{{$mayLikedProduct->price}}</small></del>@else৳{{$mayLikedProduct->price}}@endif</h6>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach

        </ul>
    </div>
</div>
