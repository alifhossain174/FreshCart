<div class="row g-sm-4 g-2">
    <div class="col-lg-6">
        <div class="slider-image">
            <img src="{{ url(env('ADMIN_URL') . '/' . $product->image) }}" class="img-fluid blur-up lazyload" alt="" />
        </div>
    </div>

    <div class="col-lg-6">
        <div class="right-sidebar-modal">
            <h4 class="title-name">
                {{ $product->name }}
            </h4>

            @php
                $variants = DB::table('product_variants')
                    ->leftJoin('colors', 'product_variants.color_id', 'colors.id')
                    ->leftJoin('product_sizes', 'product_variants.size_id', 'product_sizes.id')
                    ->select(
                        'product_variants.*',
                        'colors.id as color_id',
                        'colors.name as color_name',
                        'colors.code as color_code',
                        'product_sizes.name as size_name',
                    )
                    ->where('product_variants.product_id', $product->id)
                    ->get();

                $totalStockAllVariants = $product->stock;
                if ($variants && count($variants) > 0) {
                    $variantMinDiscountPrice = 0;
                    $variantMinPrice = 0;
                    $variantMinDiscountPriceArray = [];
                    $variantMinPriceArray = [];

                    foreach ($variants as $variant) {
                        if($variant->discounted_price > 0){
                            $variantMinDiscountPriceArray[] = $variant->discounted_price;
                        }
                        if($variant->price > 0){
                            $variantMinPriceArray[] = $variant->price;
                        }
                        $totalStockAllVariants = $totalStockAllVariants + (int) $variant->stock;
                    }

                    $variantMinDiscountPrice = min($variantMinDiscountPriceArray);
                    $variantMinPrice = min($variantMinPriceArray);
                }
            @endphp


            @include('quick_view.price')
            @include('quick_view.review')


            <div class="product-detail">
                <h4>Product Details :</h4>
                <p>{{ $product->short_description }}</p>
            </div>

            <ul class="brand-list">

                @if ($product->brand_name)
                    <li>
                        <div class="brand-box">
                            <h5>Brand Name:</h5>
                            <h6>{{ $product->brand_name }}</h6>
                        </div>
                    </li>
                @endif

                @if ($product->code)
                    <li>
                        <div class="brand-box">
                            <h5>Product Code:</h5>
                            <h6>{{ $product->code }}</h6>
                        </div>
                    </li>
                @endif

                @if ($product->category_name)
                    <li>
                        <div class="brand-box">
                            <h5>Category:</h5>
                            <h6>{{ $product->category_name }}</h6>
                        </div>
                    </li>
                @endif

            </ul>


            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
            @if ($variants && count($variants) > 0 && $totalStockAllVariants > 0)

                @php
                    $colorCheckArray = [];
                    $colorChecked = [];
                    $colorArray = [];
                    foreach ($variants as $variant) {
                        if ($variant->color_id) {
                            $colorCheckArray[] = $variant->color_id;
                        }
                        if ($variant->color_id && !in_array($variant->color_id, $colorChecked)) {
                            $colorChecked[] = $variant->color_id;
                        }
                    }
                @endphp

                @if (count($colorCheckArray) > 0)
                    <div class="select-size">
                        <h4 style="width: 85px;">Select Color :</h4>
                        <select class="form-select select-form-size" id="varint_color_id" name="color_id"
                            style="width: 30%" onchange="checkVariantStock()">
                            <option value="" selected>Select Color</option>
                            @foreach ($variants as $variant)
                                @if ($variant->color_code && !in_array($variant->color_code, $colorArray))
                                    @php $colorArray[] = $variant->color_code; @endphp
                                    <option value="{{ $variant->color_id }}"
                                        style="background: {{ $variant->color_code }};">{{ $variant->color_name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif


                @if ($configSetup[0]->status == 1)
                    @php
                        $sizeCheckArray = [];
                        $sizeChecked = [];
                        $sizeArray = [];
                        foreach ($variants as $variant) {
                            if ($variant->size_id) {
                                $sizeCheckArray[] = $variant->size_id;
                            }
                            if ($variant->size_id && !in_array($variant->size_id, $sizeChecked)) {
                                $sizeChecked[] = $variant->size_id;
                            }
                        }
                    @endphp

                    @if (count($sizeCheckArray) > 0)
                        <div class="select-size">
                            <h4 style="width: 85px;">Select Size :</h4>
                            <select class="form-select select-form-size" id="varint_size_id" name="color_id"
                                style="width: 30%" onchange="checkVariantStock()">
                                <option value="" selected>Select Size</option>
                                @foreach ($variants as $variant)
                                    @if ($variant->size_id && !in_array($variant->size_id, $sizeArray))
                                        @php $sizeArray[] = $variant->size_id; @endphp
                                        <option value="{{ $variant->size_id }}">{{ $variant->size_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @endif
                @endif

            @endif

            <div class="modal-button">
                @if($totalStockAllVariants > 0)

                    @if (isset(session()->get('cart')[$product->id]))
                        <a href="javascript:void(0)" data-id="{{ $product->id }}" class="btn btn-md remove-cart-button-qv add-cart-button icon" style="background-color: #ca0000;">Remove Cart</a>
                    @else
                        <a href="javascript:void(0)" data-id="{{ $product->id }}" class="btn btn-md add-cart-button-qv add-cart-button icon">Add To Cart</a>
                    @endif

                @else
                    <a href="javascript:void(0)" class="btn btn-md add-cart-button icon" style="background-color: #ca0000;">Stock Out</a>
                @endif
                <a href="{{ url('product') }}/{{ $product->slug }}" class="btn theme-bg-color view-button icon text-white fw-bold btn-md">View More Details</a>
            </div>

        </div>
    </div>
</div>

<script>
    function checkVariantStock() {

        let color_id = null;
        let size_id = null;

        var colorElement = document.getElementById("varint_color_id");
        if (colorElement) {
            color_id = colorElement.value
        }

        var sizeElement = document.getElementById("varint_size_id");
        if (sizeElement) {
            size_id = sizeElement.value
        }

        // sending request
        var formData = new FormData();
        formData.append("product_id", $("#product_id").val());
        formData.append("color_id", color_id);
        formData.append("size_id", size_id);

        $.ajax({
            data: formData,
            url: "{{ url('check/product/variant') }}",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {

                if (Number(data.discounted_price) > 0) {
                    $("h5.price").html("৳"+data.discounted_price+" <del>৳"+data.price+"</del>")
                    $("#product_discount_price").val(data.discounted_price);
                    $("#product_price").val(data.price);
                } else {
                    $("h5.price").html("৳"+data.price)
                    $("#product_discount_price").val(0);
                    $("#product_price").val(data.price);
                }

                if (data.stock > 0) {
                    $(".add-cart-button").show();
                } else {
                    $(".add-cart-button").hide();
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.options.timeOut = 1000;
                    toastr.error("Stock Out");
                }

            },
            error: function(data) {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.error("Something Went Wrong");
            }
        });

    }

    $('.add-cart-button-qv').click(function () {

        var product_id = $(this).data('id');
        let color_id = null;
        let size_id = null;
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.timeOut = 1000;

        var colorElement = document.getElementById("varint_color_id");
        if (colorElement) {
            if(!colorElement.value){
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Select a Color");
                return false;
            }
            color_id = colorElement.value
        }

        var sizeElement = document.getElementById("varint_size_id");
        if (sizeElement) {
            if(!sizeElement.value){
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.error("Please Select a Size");
                return false;
            }
            size_id = sizeElement.value
        }

        // sending request
        var formData = new FormData();
        formData.append("product_id", product_id);
        formData.append("qty", 1);
        formData.append("price", Number($("#product_price").val()));
        formData.append("discount_price", Number($("#product_discount_price").val()));
        formData.append("color_id", color_id);
        formData.append("size_id", size_id);

        $.ajax({
            data: formData,
            url: "{{ url('add/to/cart/with/qty') }}",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {

                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.timeOut = 1000;
                toastr.success("Added to Cart");
                $("a.bag-icon small.badge-number").html(data.cartTotalQty);

                $(".add-cart-button").addClass("remove-cart-button-qv");
                $(".add-cart-button").html("Remove From Cart");
                $(".add-cart-button").removeClass("add-cart-button-qv");
                $(".add-cart-button").css("background-color", "#ca0000");

                $("#cart_qty_"+product_id).val(1);
                $(".qty-box-"+product_id).addClass("open");

                $('#view').modal('hide');

            },
            error: function(data) {
                toastr.error("Something Went Wrong");
            }
        });
    });


    $('.remove-cart-button-qv').click(function () {

        var id = $(this).data('id');
        $.get("{{ url('remove/cart/item') }}" + '/' + id, function(data) {
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.options.timeOut = 1000;
            toastr.error("Removed from cart")
            $("a.bag-icon small.badge-number").html(data.cartTotalQty);

            $(".add-cart-button").addClass("add-cart-button-qv");
            $(".add-cart-button").html("Add to Cart");
            $(".add-cart-button").removeClass("remove-cart-button-qv");
            $(".add-cart-button").css("background-color", "#1e1e1e");

            $("#cart_qty_"+id).val(0);
            $(".qty-box-"+id).removeClass("open");

            $('#view').modal('hide');
        })

    });

</script>
