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
