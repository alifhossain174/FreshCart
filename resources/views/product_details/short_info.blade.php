<div class="pickup-box">
    <div class="product-title">
        <h4>Product Information</h4>
    </div>

    <div class="product-info">
        <ul class="product-info-list product-info-list-2">
            <li>
                Category : <a href="javascript:void(0)">{{$product->category_name}}</a>
            </li>
            <li>
                Code : <a href="javascript:void(0)">{{$product->code}}</a>
            </li>
            @if($product->brand_name)
            <li>
                Brand : <a href="javascript:void(0)">{{$product->brand_name}}</a>
            </li>
            @endif
            <li>
                Stock : <a href="javascript:void(0)">{{$totalStockAllVariants}} Items Left</a>
            </li>
            @if($product->tags)
            <li>
                Tags : <a href="javascript:void(0)">{{$product->tags}}</a>
            </li>
            @endif
        </ul>
    </div>
</div>
