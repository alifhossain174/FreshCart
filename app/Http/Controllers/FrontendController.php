<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $sliders = DB::table('banners')->where('type', 1)->where('status', 1)->orderBy('serial', 'asc')->get();
        $topBanners = DB::table('banners')->where('type', 2)->where('position', 'top')->where('status', 1)->orderBy('serial', 'asc')->get();
        $middleBanners = DB::table('banners')->where('type', 2)->where('position', 'middle')->where('status', 1)->orderBy('serial', 'asc')->get();
        $bottomBanners = DB::table('banners')->where('type', 2)->where('position', 'bottom')->where('status', 1)->orderBy('serial', 'asc')->get();
        $categories = DB::table('categories')->where('status', 1)->where('show_on_navbar', 1)->orderBy('serial', 'asc')->get();
        $featuredCategories = DB::table('categories')->where('status', 1)->where('featured', 1)->orderBy('serial', 'asc')->get();
        $promoOffers = DB::table('promo_codes')->where('status', 1)->where('effective_date', '<=', date("Y-m-d"))->where('expire_date', '>=', date("Y-m-d"))->get();
        $offerProducts = DB::table('products')->where('special_offer', 1)->where('offer_end_time', '>', date("Y-m-d H:i:s"))->inRandomOrder()->skip(0)->limit(5)->get();
        $flags = DB::table('flags')->where('status', 1)->where('featured', 1)->orderBy('serial', 'asc')->get();
        $blogs = DB::table('blogs')->where('status', 1)->orderBy('id', 'desc')->skip(0)->limit(10)->get();
        return view('index', compact('sliders', 'topBanners', 'categories', 'featuredCategories', 'promoOffers', 'offerProducts', 'flags', 'middleBanners', 'bottomBanners', 'blogs'));
    }

    public function searchForProducts(Request $request){
        $searchKeyword = $request->search_keyword;
        return redirect('shop?search_keyword='.$searchKeyword);
    }

    public function productQuickView(Request $request){
        $product = DB::table('products')
                        ->leftJoin('brands', 'products.id', 'brands.id')
                        ->leftJoin('categories', 'products.category_id', 'categories.id')
                        ->select('products.*', 'brands.name as brand_name', 'categories.name as category_name')
                        ->where('products.slug', $request->product_slug)
                        ->first();

        $configSetup = DB::table('config_setups')->get();
        $returnHTML = view('quick_view.modal_body', compact('product', 'configSetup'))->render();
        return response()->json([
            'rendered_quick_view' => $returnHTML
        ]);
    }

    public function checkProductVariant(Request $request){

        $query = DB::table('product_variants')->where('product_id', $request->product_id);

        if($request->color_id > 0){
            $query->where('color_id', $request->color_id);
        }
        if($request->size_id > 0){
            $query->where('size_id', $request->size_id);
        }

        $data = $query->where('stock', '>', 0)->orderBy('discounted_price', 'asc')->orderBy('price', 'asc')->first();
        if($data){

            // $product = DB::table('products')->where('id', $request->product_id)->first();
            // $returnHTML = view('product_details.cart_buy_button', compact('product'))->render();

            return response()->json([
                // 'rendered_button' => $returnHTML,
                'price' => $data->price,
                'discounted_price' => $data->discounted_price,
                'stock' => $data->stock
            ]);

        }else {
            return response()->json(['price' => 0, 'discounted_price' => 0, 'save' => 0, 'stock' => 0]);
        }

    }

    public function checkProductDetailsVariant(Request $request){

        $query = DB::table('product_variants')->where('product_id', $request->product_id);
        if($request->color_id != 'null'){
            $query->where('color_id', $request->color_id);
        }
        if($request->size_id != 'null'){
            $query->where('size_id', $request->size_id);
        }

        $data = $query->where('stock', '>', 0)->orderBy('discounted_price', 'asc')->orderBy('price', 'asc')->first();
        if($data){

            $product = DB::table('products')->where('id', $request->product_id)->first();
            $returnHTML = view('product_details.cart_buy_button', compact('product'))->render();
            return response()->json([
                'rendered_button' => $returnHTML,
                'price' => $data->price,
                'discounted_price' => $data->discounted_price,
                'stock' => $data->stock
            ]);

        }else {
            return response()->json(['price' => 0, 'discounted_price' => 0, 'save' => 0, 'stock' => 0]);
        }

    }

    public function shop(Request $request){

        $categories = DB::table('categories')->where('status', 1)->orderBy('serial', 'asc')->get();
        $flags = DB::table('flags')->where('status', 1)->orderBy('id', 'desc')->get();
        $brands = DB::table('brands')->where('status', 1)->orderBy('serial', 'asc')->get();
        $sizes = DB::table('product_sizes')->where('status', 1)->orderBy('serial', 'asc')->get();
        $shopBanners = DB::table('banners')->where('type', 2)->where('position', 'shop')->orderBy('serial', 'asc')->get();
        $colors = DB::table('product_variants')
                    ->join('colors', 'product_variants.color_id', 'colors.id')
                    ->select('colors.*')
                    ->groupBy('product_variants.color_id')
                    ->orderBy('colors.name', 'asc')
                    ->get();
        $policies = DB::table('terms_and_policies')->where('id', 1)->first();

        $query = DB::table('products')
            ->leftJoin('stores', 'products.store_id', '=', 'stores.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('child_categories', 'products.childcategory_id', '=', 'child_categories.id')
            ->leftJoin('flags', 'products.flag_id', 'flags.id')
            ->leftJoin('brands', 'products.brand_id', 'brands.id')
            ->leftJoin('product_variants', 'products.id', 'product_variants.product_id')
            ->leftJoin('product_sizes', 'product_variants.size_id', 'product_sizes.id')
            ->leftJoin('colors', 'product_variants.color_id', 'colors.id')
            ->select('products.image', 'products.name', 'products.price', 'products.discount_price', 'products.id', 'products.slug', 'products.stock', 'has_variant', 'flags.name as flag_name', 'categories.name as category_name')
            ->groupBy('products.id')
            ->where('products.status', 1);


        // ============== applying filters from url parameter start ================
        $parameters = '';
        $categorySlug = isset($request->category) ? $request->category : '';
        $subcategorySlug = isset($request->subcategory) ? $request->subcategory : '';
        $childcategorySlug = isset($request->childcategory) ? $request->childcategory : '';
        $flagSlug = isset($request->flag) ? $request->flag : '';
        $brandSlug = isset($request->brand) ? $request->brand : '';
        $sizeSlug = isset($request->size) ? $request->size : '';
        $colorId = isset($request->color) ? $request->color : '';
        $sort_by = isset($request->sort_by) ? $request->sort_by : '';
        $min_price = isset($request->min_price) ? $request->min_price : '';
        $max_price = isset($request->max_price) ? $request->max_price : '';
        $search_keyword = isset($request->search_keyword) ? $request->search_keyword : '';
        $storeSlug = isset($request->store) ? $request->store : '';
        $parameters = '';

        if($categorySlug){
            $query->whereIn('categories.slug', explode(",", $categorySlug));
            $parameters == '' ? $parameters .= '?category=' . $categorySlug : $parameters .= '&category=' . $categorySlug;
        }
        if($subcategorySlug){
            $query->where('subcategories.slug', $subcategorySlug);
            $parameters == '' ? $parameters .= '?subcategory=' . $subcategorySlug : $parameters .= '&subcategory=' . $subcategorySlug;
        }
        if($childcategorySlug){
            $query->where('child_categories.slug', $childcategorySlug);
            $parameters == '' ? $parameters .= '?childcategory=' . $childcategorySlug : $parameters .= '&childcategory=' . $childcategorySlug;
        }
        if($flagSlug){
            $query->whereIn('flags.slug', explode(",",$flagSlug));
            $parameters == '' ? $parameters .= '?flag=' . $flagSlug : $parameters .= '&flag=' . $flagSlug;
        }
        if($brandSlug){
            $query->whereIn('brands.slug', explode(",",$brandSlug));
            $parameters == '' ? $parameters .= '?brand=' . $brandSlug : $parameters .= '&brand=' . $brandSlug;
        }
        if($sizeSlug){
            $query->whereIn('product_sizes.slug', explode(",",$sizeSlug));
            $parameters == '' ? $parameters .= '?size=' . $sizeSlug : $parameters .= '&size=' . $sizeSlug;
        }
        if($colorId){
            $query->whereIn('colors.id', explode(",",$colorId));
            $parameters == '' ? $parameters .= '?color=' . $colorId : $parameters .= '&color=' . $colorId;
        }

        // sorting
        if($sort_by && $sort_by > 0){
            if($sort_by == 1){
                $query->orderBy('products.id', 'desc');
            }
            if($sort_by == 2){
                $query->orderBy('products.discount_price', 'asc')->orderBy('products.price', 'asc');
            }
            if($sort_by == 3){
                $query->orderBy('products.discount_price', 'desc')->orderBy('products.price', 'desc');
            }
            $parameters == '' ? $parameters .= '?sort_by=' . $sort_by : $parameters .= '&sort_by=' . $sort_by;
        } else {
            $query->orderBy('products.id', 'desc');
        }

        // min price
        if($min_price && $min_price > 0){
            $query->where(function($query) use ($min_price) {
                $query->where('products.discount_price', '>=', $min_price)->orWhere('products.price', '>=', $min_price);
            });
            $parameters == '' ? $parameters .= '?min_price=' . $min_price : $parameters .= '&min_price=' . $min_price;
        }
        // max price
        if($max_price && $max_price > 0){
            $query->where(function($query) use ($max_price) {
                $query->where([['products.discount_price', '<=', $max_price], ['products.discount_price', '>', 0]])->orWhere([['products.price', '<=', $max_price], ['products.price', '>', 0]]);
            });
            $parameters == '' ? $parameters .= '?max_price=' . $max_price : $parameters .= '&max_price=' . $max_price;
        }

        // search keyword
        if($search_keyword){
            $query->where('products.name', 'LIKE', '%'.$search_keyword.'%');
            $parameters == '' ? $parameters .= '?search_keyword=' . $search_keyword : $parameters .= '&search_keyword=' . $search_keyword;
        }

        // store
        $storeInfo = null;
        $productReviewsOfStore = null;
        if($storeSlug){
            $storeInfo = DB::table('stores')->where('slug', $storeSlug)->first();
            $query->where('stores.slug', $storeSlug);
            $parameters == '' ? $parameters .= '?store=' . $storeSlug : $parameters .= '&store=' . $storeSlug;

            $productReviewsOfStore = DB::table('product_reviews')
                                    ->leftJoin('products', 'product_reviews.product_id', 'products.id')
                                    ->leftJoin('users', 'product_reviews.user_id', 'users.id')
                                    ->select('product_reviews.*', 'products.name', 'products.image', 'users.image as customer_image', 'users.name as customer_name')
                                    ->where('products.store_id', $storeInfo->id)
                                    ->paginate(10);
        }

        // setting pagination with custom path and parameters
        $products = $query->paginate(16);
        $products->withPath('/shop'.$parameters);
        $showingResults = "Showing ".(($products->currentpage()-1)*$products->perpage()+1)." - ".$products->currentpage()*$products->perpage()." of ".$products->total()." results";
        return view('shop.shop', compact('policies', 'productReviewsOfStore', 'shopBanners', 'sizes', 'showingResults', 'products', 'categories', 'flags', 'brands', 'colors',  'categorySlug', 'subcategorySlug', 'childcategorySlug', 'flagSlug', 'brandSlug', 'sizeSlug', 'colorId', 'sort_by', 'min_price', 'max_price', 'search_keyword', 'storeInfo'));
    }

    public function productDetails($slug){

        $product = DB::table('products')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', 'brands.id')
            ->leftJoin('product_models', 'products.model_id', 'product_models.id')
            ->select('products.*', 'categories.name as category_name', 'categories.slug as category_slug', 'brands.name as brand_name', 'brands.logo as brand_logo', 'product_models.name as model_name')
            ->where('products.slug', $slug)
            ->first();

        if($product->store_id){
            $vendorProducts = DB::table('products')
                        ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant')
                        ->where('store_id', $product->store_id)
                        ->where('id', '!=', $product->id)
                        ->inRandomOrder()
                        ->skip(0)
                        ->limit(12)
                        ->get();
        } else{
            $vendorProducts = array();
        }

        $relatedProducts = DB::table('products')
                            ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant')
                            ->where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->inRandomOrder()
                            ->skip(0)
                            ->limit(12)
                            ->get();

        $mayLikedProducts = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('flags', 'products.flag_id', 'flags.id')
            ->select('products.image', 'products.name', 'price', 'discount_price', 'products.id', 'products.slug', 'stock', 'has_variant', 'flags.name as flag_name', 'categories.name as category_name', 'subcategories.name as subcategory_name')
            ->where('products.id', '!=', $product->id)
            ->inRandomOrder()
            ->skip(0)
            ->limit(10)
            ->get();

        $productReviews = DB::table('product_reviews')
            ->leftJoin('users', 'product_reviews.user_id', 'users.id')
            ->select('product_reviews.rating', 'product_reviews.review', 'product_reviews.reply', 'product_reviews.created_at', 'product_reviews.updated_at', 'product_reviews.status', 'users.name as username', 'users.image as user_image')
            ->where('product_reviews.product_id', $product->id)
            ->where('product_reviews.status', 1)
            ->orderBy('product_reviews.id', 'desc')
            ->paginate(10);

        $totalReviews = $productReviews->total();
        $totalRating = DB::table('product_reviews')->where('product_reviews.product_id', $product->id)->where('product_reviews.status', 1)->sum('rating');
        $averageRating = $totalReviews > 0 ? $totalRating/$totalReviews : 0;

        $productMultipleImages = DB::table('product_images')->select('image')->where('product_id', $product->id)->get();
        $variants = DB::table('product_variants')
            ->leftJoin('colors', 'product_variants.color_id', 'colors.id')
            ->leftJoin('product_sizes', 'product_variants.size_id', 'product_sizes.id')
            ->select('product_variants.*', 'colors.id as color_id', 'colors.name as color_name', 'colors.code as color_code', 'product_sizes.name as size_name')
            ->where('product_variants.product_id', $product->id)
            ->get();

        $configSetup = DB::table('config_setups')->get();

        return view('product_details.details', compact('vendorProducts', 'relatedProducts', 'mayLikedProducts', 'product', 'averageRating', 'totalReviews', 'productReviews', 'productMultipleImages', 'variants', 'configSetup'));
    }

    public static function generateRandomHexColor() {
        $red = rand(0, 128);   // Range from min to mid
        $green = rand(0, 128); // Range from min to mid
        $blue = rand(0, 128);  // Range from min to mid
        $redHex = str_pad(dechex($red), 2, '0', STR_PAD_LEFT);
        $greenHex = str_pad(dechex($green), 2, '0', STR_PAD_LEFT);
        $blueHex = str_pad(dechex($blue), 2, '0', STR_PAD_LEFT);
        $hexColor = '#' . $redHex . $greenHex . $blueHex;
        return $hexColor;
    }

    public static function lightenHexColor($hex, $percent) {
        $hex = ltrim($hex, '#');
        $red = hexdec(substr($hex, 0, 2));
        $green = hexdec(substr($hex, 2, 2));
        $blue = hexdec(substr($hex, 4, 2));
        $red = min(255, $red + ($red * $percent / 100));
        $green = min(255, $green + ($green * $percent / 100));
        $blue = min(255, $blue + ($blue * $percent / 100));
        $redHex = str_pad(dechex($red), 2, '0', STR_PAD_LEFT);
        $greenHex = str_pad(dechex($green), 2, '0', STR_PAD_LEFT);
        $blueHex = str_pad(dechex($blue), 2, '0', STR_PAD_LEFT);
        $lightenedHex = '#' . $redHex . $greenHex . $blueHex;
        return $lightenedHex;
    }
}
