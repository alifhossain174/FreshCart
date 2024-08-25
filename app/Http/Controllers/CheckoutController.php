<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(){

        if(!session('cart') || (session('cart') && count(session('cart')) <= 0)){
            Toastr::error('No Products Found in Cart', 'Failed to Checkout');
            return redirect('/');
        }

        return view('checkout.checkout');
    }

    public function applyCoupon(Request $request){

        $couponCode = $request->coupon_code;
        $couponInfo = DB::table('promo_codes')->where('code', $couponCode)->first();
        if($couponInfo){

            if(Auth::user() && DB::table('orders')->where('coupon_code', $couponInfo->code)->where('user_id', Auth::user()->id)->exists()){
                session([
                    'coupon' => $couponCode,
                    'discount' => 0
                ]);
                $checkoutTotalAmount = view('checkout.order_total')->render();
                $appliedCoupon = view('checkout.applied_coupon')->render();
                return response()->json(['message' => 'Coupon Already Used', 'status' => 0, 'checkoutTotalAmount' => $checkoutTotalAmount, 'appliedCoupon' => $appliedCoupon]);
            }

            if($couponInfo->expire_date < date("Y-m-d")){
                session([
                    'coupon' => $couponCode,
                    'discount' => 0
                ]);
                $checkoutTotalAmount = view('checkout.order_total')->render();
                $appliedCoupon = view('checkout.applied_coupon')->render();
                return response()->json(['message' => 'Coupon is Expired', 'status' => 0, 'checkoutTotalAmount' => $checkoutTotalAmount, 'appliedCoupon' => $appliedCoupon]);
            }

            $subTotal = 0;
            foreach((array) session('cart') as $id => $details){
                $subTotal += ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'];
            }

            if($couponInfo->minimum_order_amount && $couponInfo->minimum_order_amount > $subTotal){
                session([
                    'coupon' => $couponCode,
                    'discount' => 0
                ]);
                $checkoutTotalAmount = view('checkout.order_total')->render();
                $appliedCoupon = view('checkout.applied_coupon')->render();
                return response()->json(['message' => 'Sorry! Minimum Order Amount is '.$couponInfo->minimum_order_amount, 'status' => 0, 'checkoutTotalAmount' => $checkoutTotalAmount, 'appliedCoupon' => $appliedCoupon]);
            }

            $discount = 0;
            if($couponInfo->type == 1){
                $discount = $couponInfo->value;
            } else {
                $discount = ($subTotal*$couponInfo->value)/100;
            }

            session([
                'coupon' => $couponCode,
                'discount' => $discount
            ]);

            $checkoutTotalAmount = view('checkout.order_total')->render();
            $appliedCoupon = view('checkout.applied_coupon')->render();
            return response()->json(['message' => 'Coupon Applied Successfully', 'status' => 1, 'checkoutTotalAmount' => $checkoutTotalAmount, 'appliedCoupon' => $appliedCoupon]);


        } else {
            session([
                'coupon' => $couponCode,
                'discount' => 0
            ]);
            $checkoutTotalAmount = view('checkout.order_total')->render();
            $appliedCoupon = view('checkout.applied_coupon')->render();
            return response()->json(['message' => 'Sorry No Coupon Found', 'status' => 0, 'checkoutTotalAmount' => $checkoutTotalAmount, 'appliedCoupon' => $appliedCoupon]);
        }
    }

    public function applyForRewardPoints(Request $request){
        if($request->reward_points <= Auth::user()->balance){

            $total = 0;
            foreach((array) session('cart') as $id => $details){
                $total += ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'];
            }
            $discount = session('discount') ? session('discount') : 0;
            $totalOrderAmountWithoutDelivery = $total-$discount;

            if($request->reward_points <= $totalOrderAmountWithoutDelivery){

                session(['reward_points' => $request->reward_points]);
                $checkoutTotalAmount = view('checkout.order_total')->render();
                return response()->json([
                    'message' => $request->reward_points.' Reward Points Used',
                    'status' => 1,
                    'checkoutTotalAmount' => $checkoutTotalAmount,
                ]);

            } else{
                session(['reward_points' => 0]);
                $checkoutTotalAmount = view('checkout.order_total')->render();
                return response()->json([
                    'message' => 'Use Less Points than Order Amount (Without Delivery)',
                    'status' => 0,
                    'checkoutTotalAmount' => $checkoutTotalAmount,
                ]);
            }

        } else {
            session(['reward_points' => 0]);
            $checkoutTotalAmount = view('checkout.order_total')->render();
            return response()->json([
                'message' => 'Dont have enough Reward Points',
                'status' => 0,
                'checkoutTotalAmount' => $checkoutTotalAmount,
            ]);
        }
    }

    public function removeAppliedCoupon(){
        session()->forget('coupon');
        session()->forget('discount');
        $checkoutTotalAmount = view('checkout.order_total')->render();
        $appliedCoupon = view('checkout.applied_coupon')->render();
        return response()->json(['checkoutTotalAmount' => $checkoutTotalAmount, 'appliedCoupon' => $appliedCoupon]);
    }

    public function districtWiseThana(Request $request){

        $districtWiseDeliveryCharge = 0;
        $districtInfo = DB::table('districts')->where('id', $request->district_id)->first();
        if($districtInfo){
            $districtWiseDeliveryCharge = $districtInfo->delivery_charge;
        }

        session(['delivery_cost' => $districtWiseDeliveryCharge]);

        $data = DB::table('upazilas')->where("district_id", $request->district_id)->select('name', 'id')->orderBy('name', 'asc')->get();
        $checkoutTotalAmount = view('checkout.order_total')->render();
        return response()->json(['data' => $data, 'checkoutTotalAmount' => $checkoutTotalAmount]);
    }

    function changeDeliveryMethod(Request $request){
        if($request->delivery_method == 1){ //home delivery and charge applicable
            $districtInfo = DB::table('districts')->where('id', $request->district_id)->first();
            if($districtInfo){
                session(['delivery_cost' => $districtInfo->delivery_charge]);
            } else {
                session(['delivery_cost' => 0]);
            }
        } else {
            session(['delivery_cost' => 0]);
        }
        $checkoutTotalAmount = view('checkout.order_total')->render();
        return response()->json(['checkoutTotalAmount' => $checkoutTotalAmount]);
    }

    public function placeOrder(Request $request){

        if(!session('cart') || (session('cart') && count(session('cart')) <= 0)){
            Toastr::error('No Products Found in Checkout', 'Failed to Place Order');
            return redirect('/');
        }

        if(!Auth::check() && isset($request->account_password) && $request->account_password){
            $newUserId = User::insertGetId([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->account_password),
                'user_type' => 3,
                'address' => $request->shipping_address,
                'status' => 1,
                'created_at' => Carbon::now()
            ]);
            $finduser = User::where('id', $newUserId)->first();
            Auth::login($finduser);
        }


        if($request->payment_method == 'cod'){

            date_default_timezone_set("Asia/Dhaka");
            $total = 0;
            foreach((array) session('cart') as $id => $details){
                $total += ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'];
            }
            $discount = session('discount') ? session('discount') : 0;
            $reward_points = session('reward_points') ? session('reward_points') : 0;
            $deliveryCost = session('delivery_cost') ? session('delivery_cost') : 0;
            $couponCode = session('coupon') ? session('coupon') : 0;

            $orderId = DB::table('orders')->insertGetId([
                'order_no' => time().rand(100,999),
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'order_date' => date("Y-m-d H:i:s"),
                'estimated_dd' => date('Y-m-d', strtotime("+7 day", strtotime(date("Y-m-d")))),
                'delivery_method' => $request->delivery_method,
                'payment_method' => 1,
                'payment_status' => 0,
                'order_from' => 1,
                'trx_id' => time().str::random(5),
                'order_status' => 0,
                'sub_total' => $total,
                'coupon_code' => $couponCode,
                'discount' => $discount,
                'reward_points_used' => $reward_points,
                'delivery_fee' => $deliveryCost,
                'vat' => 0,
                'tax' => 0,
                'total' => ($total+$deliveryCost)-($discount+$reward_points),
                'order_note' => $request->special_note,
                'complete_order' => 1,
                'slug' => str::random(5) . time(),
                'created_at' => Carbon::now()
            ]);

            DB::table('order_progress')->insert([
                'order_id' => $orderId,
                'order_status' => 0,
                'created_at' => Carbon::now()
            ]);

            foreach(session('cart') as $id => $details){

                // decrement the stock
                $productInfo = DB::table('products')->where('id', $id)->first();
                DB::table('products')->where('id', $id)->update([
                    'stock' => $productInfo->stock - $details['quantity'],
                ]);

                DB::table('order_details')->insert([
                    'order_id' => $orderId,
                    'product_id' => $id,

                    // VARIANT
                    'color_id' => $details['color_id'],
                    'region_id' => null,
                    'sim_id' => null,
                    'size_id' => $details['size_id'],
                    'storage_id' => null,
                    'warrenty_id' => null,
                    'device_condition_id' => null,

                    'qty' => $details['quantity'],
                    'unit_id' => $productInfo->unit_id,
                    'unit_price' => $details['discount_price'] > 0 ? $details['discount_price'] : $details['price'],
                    'total_price' => ($details['discount_price'] > 0 ? $details['discount_price'] : $details['price']) * $details['quantity'],
                    'reward_points' => $productInfo->reward_points*$details['quantity'],
                    'created_at' => Carbon::now()
                ]);
            }

            $shippingDistrictInfo = DB::table('districts')->where('id', $request->shipping_district_id)->first();
            $shippingThanaInfo = DB::table('upazilas')->where('id', $request->shipping_thana_id)->first();
            DB::table('shipping_infos')->insert([
                'order_id' => $orderId,
                'full_name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'gender' => null,
                'address' => $request->shipping_address,
                'thana' => $shippingThanaInfo->name,
                'post_code' => $request->shipping_postal_code,
                'city' => $shippingDistrictInfo->name,
                'country' => 'Bangladesh',
                'created_at' => Carbon::now()
            ]);


            // if user logged in
            if(Auth::user()){

                DB::table('users')->where('id', Auth::user()->id)->update([
                    'balance' => Auth::user()->balance - $reward_points
                ]);

                // updating null phone number after first registration
                if(Auth::user()->phone == '' || Auth::user()->phone == null){
                    DB::table('users')->where('id', Auth::user()->id)->update([
                        'phone' => $request->phone,
                    ]);
                }

                // updating null address after first registration
                if(DB::table('user_addresses')->where('user_id', Auth::user()->id)->count() <= 0){
                    DB::table('user_addresses')->insert([
                        'user_id' => Auth::user()->id,
                        'address_type' => 'Home',
                        'name' => $request->name,
                        'address' => $request->shipping_address,
                        'country' => 'Bangladesh',
                        'city' => $shippingDistrictInfo ? $shippingDistrictInfo->name : '',
                        'state' => $shippingThanaInfo ? $shippingThanaInfo->name : '',
                        'post_code' => $request->shipping_postal_code,
                        'phone' => $request->phone,
                        'slug' => str::random(5) . time(),
                        'created_at' => Carbon::now()
                    ]);
                }
            }

            DB::table('billing_addresses')->insert([
                'order_id' => $orderId,
                'address' => $request->shipping_address, //$request->billing_address,
                'post_code' => $request->shipping_postal_code, //$request->billing_postal_code,
                'thana' => $shippingThanaInfo->name, //$billingThanaInfo->name,
                'city' => $shippingDistrictInfo->name, //$billingDistrictInfo->name,
                'country' => 'Bangladesh',
                'created_at' => Carbon::now()
            ]);

            if($request->email){
                DB::table('subscribed_users')->insert([
                    'email' => $request->email,
                    'created_at' => Carbon::now()
                ]);
            }

            $orderInfo = DB::table('orders')->where('id', $orderId)->first();
            DB::table('order_payments')->insert([
                'order_id' => $orderId,
                'payment_through' => "COD",
                'tran_id' => $orderInfo->trx_id,
                'val_id' => NULL,
                'amount' => $orderInfo->total,
                'card_type' => NULL,
                'store_amount' => $orderInfo->total,
                'card_no' => NULL,
                'status' => "VALID",
                'tran_date' => date("Y-m-d H:i:s"),
                'currency' => "BDT",
                'card_issuer' => NULL,
                'card_brand' => NULL,
                'card_sub_brand' => NULL,
                'card_issuer_country' => NULL,
                'created_at' => Carbon::now()
            ]);


            // sending order email
            try {

                $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();
                $userEmail = $request->email;

                if($emailConfig && $userEmail){
                    $decryption = "";
                    if($emailConfig){

                        $ciphering = "AES-128-CTR";
                        $options = 0;
                        $decryption_iv = '1234567891011121';
                        $decryption_key = "GenericCommerceV1";
                        $decryption = openssl_decrypt ($emailConfig->password, $ciphering, $decryption_key, $options, $decryption_iv);

                        config([
                            'mail.mailers.smtp.host' => $emailConfig->host,
                            'mail.mailers.smtp.port' => $emailConfig->port,
                            'mail.mailers.smtp.username' => $emailConfig->email,
                            'mail.mailers.smtp.password' => $decryption != "" ? $decryption : '',
                            'mail.mailers.smtp.encryption' => $emailConfig ? ($emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : '')) : '',
                        ]);

                        Mail::to(trim($userEmail))->send(new OrderPlacedEmail($orderInfo));
                    }
                }

            } catch(\Exception $e) {
                // write code for handling error from here
            }
            // sending order email done

            session()->forget('coupon');
            session()->forget('discount');
            session()->forget('delivery_cost');
            session()->forget('cart');
            session()->forget('reward_points');

            return redirect('order/'.$orderInfo->slug);
        }


        // if($request->payment_method == 'sslcommerz'){
        //     $orderData = array();
        //     $orderData['delivery_method'] = $request->delivery_method;
        //     $orderData['special_note'] = $request->special_note;
        //     $orderData['shipping_district_id'] = $request->shipping_district_id;
        //     $orderData['shipping_thana_id'] = $request->shipping_thana_id;
        //     $orderData['name'] = $request->name;
        //     $orderData['phone'] = $request->phone;
        //     $orderData['email'] = $request->email;
        //     $orderData['shipping_address'] = $request->shipping_address;
        //     $orderData['shipping_postal_code'] = $request->shipping_postal_code;
        //     session(['order_data' => $orderData]);
        //     return redirect('sslcommerz/order');
        // }

    }

    public function orderPreview($slug){

        $orderInfo = DB::table('orders')->where('orders.slug', $slug)->first();

        if($orderInfo){

            // for data layer start
            $orderdItems = DB::table('order_details')
                            ->join('orders', 'order_details.order_id', 'orders.id')
                            ->join('products', 'order_details.product_id', 'products.id')
                            ->leftJoin('brands', 'products.brand_id', 'brands.id')
                            ->leftJoin('categories', 'products.category_id', 'categories.id')
                            ->select('products.name as product_name', 'order_details.product_id', 'order_details.total_price', 'brands.name as brand_name', 'categories.name as category_name', 'order_details.qty')
                            ->where('orders.id', $orderInfo->id)
                            ->get();

            $shippingInfo = DB::table('shipping_infos')->where('order_id', $orderInfo->id)->first();
            $billingInfo = DB::table('billing_addresses')->where('order_id', $orderInfo->id)->first();
            // for data layer end

            return view('order_preview', compact('orderInfo', 'orderdItems', 'shippingInfo', 'billingInfo'));
        } else {
            Toastr::error('No Order Found');
            return redirect('/');
        }
    }
}
