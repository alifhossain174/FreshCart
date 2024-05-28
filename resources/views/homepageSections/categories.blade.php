<!-- Category Section Start -->
<section class="category-section-3">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Shop By Categories</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="category-slider-1 arrow-slider wow fadeInUp">

                    @foreach($categories as $category)
                    <div>
                        <div class="category-box-list">
                            <a href="{{url('shop')}}" class="category-name">
                                <h4>{{$category->name}}</h4>
                                <h6>{{DB::table('products')->where('category_id', $category->id)->count()}} items</h6>
                            </a>
                            <div class="category-box-view">
                                <a href="{{url('shop')}}">
                                    <img src="{{env('ADMIN_URL')."/".$category->icon}}" class="img-fluid blur-up lazyload" alt="" />
                                </a>
                                <button onclick="location.href = '{{url('shop')}}';"
                                    class="btn shop-button">
                                    <span>Shop Now</span>
                                    <i class="fas fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Category Section End -->
