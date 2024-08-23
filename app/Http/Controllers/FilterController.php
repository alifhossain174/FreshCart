<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function filterProducts(Request $request){

        // main query
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


        // ========== filter parameters query start ============
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
        $pathName = $request->path_name;
        $parameters = '';

        if($categorySlug){
            $query->whereIn('categories.slug', explode(",",$categorySlug));
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
        if($min_price && $min_price > 0){
            $query->where(function($query) use ($min_price) {
                $query->where('products.price', '>=', $min_price)->orWhere('products.discount_price', '>=', $min_price);
            });
            $parameters == '' ? $parameters .= '?min_price=' . $min_price : $parameters .= '&min_price=' . $min_price;
        }
        if($max_price && $max_price > 0){
            $query->where(function($query) use ($max_price) {
                $query->where([['products.discount_price', '<=', $max_price], ['products.discount_price', '>', 0]])->orWhere([['products.price', '<=', $max_price], ['products.price', '>', 0]]);
            });
            $parameters == '' ? $parameters .= '?max_price=' . $max_price : $parameters .= '&max_price=' . $max_price;
        }
        if($search_keyword){
            $query->where('products.name', 'LIKE', '%'.$search_keyword.'%');
            $parameters == '' ? $parameters .= '?search_keyword=' . $search_keyword : $parameters .= '&search_keyword=' . $search_keyword;
        }
        // store
        $storeInfo = null;
        if($storeSlug){
            $storeInfo = DB::table('stores')->where('slug', $storeSlug)->first();
            $query->where('stores.slug', $storeSlug);
            $parameters == '' ? $parameters .= '?store=' . $storeSlug : $parameters .= '&store=' . $storeSlug;
        }
        // ========== filter parameters query end ============

        // fetch data with pagination
        $products = $query->paginate(16);
        $products->withPath($pathName.$parameters);

        // return response
        $showingResults = "Showing ".(($products->currentpage()-1)*$products->perpage()+1)." - ".$products->currentpage()*$products->perpage()." of ".$products->total()." results";
        $returnHTML = view('shop.products', compact('products', 'showingResults'))->render();
        return response()->json(['rendered_view' => $returnHTML, 'showingResults' => $showingResults]);

    }
}
