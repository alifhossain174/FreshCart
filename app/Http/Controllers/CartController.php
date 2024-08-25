<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart($id){

        $product = DB::table('products')
                    ->leftJoin('categories', 'products.category_id', 'categories.id') // joining for data layer info
                    ->leftJoin('brands', 'products.brand_id', 'brands.id') // joining for data layer info
                    ->select('products.*', 'categories.name as category_name', 'brands.name as brand_name')
                    ->where('products.id', $id)
                    ->first();

        $minVariant = DB::table('product_variants')->where('stock', '>', 0)->where('product_id', $id)->orderBy('price', 'asc')->first();
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "slug" => $product->slug,
                "quantity" => 1,
                "price" => $minVariant ? ($minVariant->price > 0 ? $minVariant->price : 0) : ($product->price > 0 ? $product->price : 0),
                "discount_price" => $minVariant ? ($minVariant->discounted_price > 0 ? $minVariant->discounted_price : 0) : ($product->discount_price > 0 ? $product->discount_price : 0),
                "image" => $product->image,
                // variant
                "color_id" => $minVariant ? $minVariant->color_id : null,
                "size_id" => $minVariant ? $minVariant->size_id : null,
                "region_id" => $minVariant ? $minVariant->region_id : null,
                "sim_id" => $minVariant ? $minVariant->sim_id : null,
                "storage_id" => $minVariant ? $minVariant->storage_type_id : null,
                "warrenty_id" => $minVariant ? $minVariant->warrenty_id : null,
                "condition_id" => $minVariant ? $minVariant->device_condition_id : null,
            ];
        }

        session()->put('cart', $cart);

        // $returnHTML = view('sidebar_cart')->render();
        return response()->json([
            // 'rendered_cart' => $returnHTML,
            'cartTotalQty' => count(session('cart')),
        ]);
    }

    public function removeCartTtem($id){
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        // $returnHTML = view('sidebar_cart')->render();
        $viewCartItems = view('cart.cart_items')->render();
        // $viewCartCalculation = view('cart.cart_calculation')->render();
        // $checkoutCartItems = view('checkout.cart_items')->render();
        // $checkoutTotalAmount = view('checkout.order_total')->render();
        return response()->json([
            // 'rendered_cart' => $returnHTML,
            'viewCartItems' => $viewCartItems,
            // 'viewCartCalculation' => $viewCartCalculation,
            // 'checkoutCartItems' => $checkoutCartItems,
            // 'checkoutTotalAmount' => $checkoutTotalAmount,
            'cartTotalQty' => count(session('cart'))
        ]);
    }

    public function updateCartQty(Request $request){
        $cart = session()->get('cart');
        if(isset($cart[$request->cart_id])) {
            $cart[$request->cart_id]['quantity'] = $request->cart_qty;
            session()->put('cart', $cart);
        }

        // $returnHTML = view('sidebar_cart')->render();
        $viewCartItems = view('cart.cart_items')->render();
        // $viewCartCalculation = view('cart.cart_calculation')->render();
        // $checkoutCartItems = view('checkout.cart_items')->render();
        // $checkoutTotalAmount = view('checkout.order_total')->render();
        return response()->json([
            // 'rendered_cart' => $returnHTML,
            'viewCartItems' => $viewCartItems,
            // 'viewCartCalculation' => $viewCartCalculation,
            // 'checkoutCartItems' => $checkoutCartItems,
            // 'checkoutTotalAmount' => $checkoutTotalAmount,
            'success' => 'Cart Qty Updated'
        ]);
    }


    public function addToCartWithQty(Request $request){

        $product = DB::table('products')->where('products.id', $request->product_id)->first();

        $cart = session()->get('cart', []);

        if(isset($cart[$request->product_id])) {

            $cart[$request->product_id]['quantity'] = (int) $request->qty;
            $cart[$request->product_id]['price'] = $request->price;
            $cart[$request->product_id]['discount_price'] = $request->discount_price;
            $cart[$request->product_id]['color_id'] = $request->color_id != 'null' ? $request->color_id : null;
            $cart[$request->product_id]['size_id'] = $request->size_id != 'null' ? $request->size_id : null;

        } else {
            $cart[$request->product_id] = [
                "name" => $product->name,
                "slug" => $product->slug,
                "quantity" => (int) $request->qty,
                "price" => $request->price,
                "discount_price" => $request->discount_price,
                "image" => $product->image,
                // variant
                "color_id" => $request->color_id != 'null' ? $request->color_id : null,
                "size_id" => $request->size_id != 'null' ? $request->size_id : null,
            ];
        }

        session()->put('cart', $cart);

        // $returnHTML = view('sidebar_cart')->render();
        return response()->json([
            // 'rendered_cart' => $returnHTML,
            'cartTotalQty' => count(session('cart'))
        ]);
    }

    public function viewCart(){
        return view('cart.view_cart');
    }
    public function clearCart(){
        session()->put('cart', []);
        Toastr::success('All items removed from Cart', 'Success');
        return back();
    }
}
