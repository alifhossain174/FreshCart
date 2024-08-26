<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerificationMail;
use App\Models\User;
use Carbon\Carbon;
use CURLFile;

class UserDashboardController extends Controller
{
    public function userDashboard(Request $request){

        $order_status = $request->order_status;
        $query = DB::table('orders')->where('user_id', Auth::user()->id);

        if($order_status && $order_status == 1){
            $query->where('order_status', 0)->orderBy('id', 'desc');
        } else if($order_status && $order_status == 2){
            $query->where('order_status', 1)->orderBy('id', 'desc');
        } else if($order_status && $order_status == 3){
            $query->where('order_status', 2)->orderBy('id', 'desc');
        } else if($order_status && $order_status == 4){
            $query->where('order_status', 3)->orderBy('id', 'desc');
        } else if($order_status && $order_status == 5){
            $query->where('order_status', 4)->orderBy('id', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $orders = $query->paginate(10);
        return view('dashboard.my_orders', compact('orders', 'order_status'));
    }

    public function orderDetails($slug){

        $order = DB::table('orders')
                    ->leftJoin('users', 'orders.user_id', 'users.id')
                    ->leftJoin('shipping_infos', 'orders.id', 'shipping_infos.order_id')
                    ->select('orders.*', 'users.name as username', 'users.email as user_email', 'users.phone', 'shipping_infos.address as shipping_address', 'shipping_infos.city as shipping_city', 'shipping_infos.thana as shipping_thana', 'shipping_infos.post_code as shipping_post_code')
                    ->where('slug', $slug)
                    ->first();

        $orderItems = DB::table('order_details')
                    ->join('products', 'order_details.product_id', 'products.id')
                    ->leftJoin('units', 'products.unit_id', 'units.id')
                    ->select('products.name', 'order_details.unit_price as product_price', 'order_details.qty', 'units.name as unit_name', 'products.image as product_image', 'products.slug as product_slug')
                    ->where('order_id', $order->id)
                    ->get();

        return view('dashboard.order_details', compact('order', 'orderItems'));
    }

    public function trackMyOrder($order_no){

        $order = DB::table('orders')->where('order_no', $order_no)->first();
        $totalItems = DB::table('order_details')->where('order_id', $order->id)->count();
        $orderProgress = DB::table('order_progress')->where('order_id', $order->id)->orderBy('order_status', 'asc')->get();

        return view('dashboard.order_tracking', compact('order', 'totalItems', 'orderProgress'));
    }

    public function myWishlists(){
        $wishlistedItems = DB::table('wish_lists')
                            ->join('products', 'wish_lists.product_id', 'products.id')
                            ->leftJoin('units', 'products.unit_id', 'units.id')
                            ->where('wish_lists.user_id', Auth::user()->id)
                            ->select('products.name', 'products.image', 'products.price', 'products.discount_price', 'units.name as unit_name', 'products.slug as product_slug')
                            ->orderBy('products.id', 'desc')
                            ->get();

        return view('dashboard.my_wishlists', compact('wishlistedItems'));
    }

    public function clearAllWishlist(){
        DB::table('wish_lists')->where('user_id', Auth::user()->id)->delete();
        Toastr::success('Removed All Items from Wishlists');
        return back();
    }

    public function changePassword(){
        return view('dashboard.change_password');
    }

    public function updatePassword(Request $request){

        if($request->old_password && !Auth::user()->provider_id && !Hash::check($request->old_password, Auth::user()->password)){
            Toastr::error('Your old password is wrong');
            return back();
        }

        if($request->new_password != $request->confirm_password){
            Toastr::error('Password did not match');
            return back();
        }

        DB::table('users')->where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        Toastr::success('Password Changed Successfully');
        return back();

    }

    public function myPayments(){
        $userId = Auth::user()->id;
        $currentMonthSpent = DB::table('orders')->where('user_id', $userId)->where('created_at', 'like', date("Y-m").'%')->sum('total');
        $lastSixMonthSpent = DB::table('orders')->where('user_id', $userId)->where('created_at', '>=', date("Y-m-d", strtotime("-6 month"))." 23:59:59")->sum('total');
        $totalSpent = DB::table('orders')->where('user_id', $userId)->sum('total');
        $orders = DB::table('orders')->where('user_id', $userId)->orderBy('id', 'desc')->paginate(10);

        return view('dashboard.my_payments', compact('currentMonthSpent', 'lastSixMonthSpent', 'totalSpent', 'orders'));
    }

    public function promoCoupons(){
        $promoCoupons = DB::table('promo_codes')->orderBy('status', 'desc')->get();

        $appliedCoupons = DB::table('orders')
                            ->join('promo_codes', 'orders.coupon_code', 'promo_codes.code')
                            ->select('promo_codes.*')
                            ->where('orders.user_id', Auth::user()->id)
                            ->groupBy('promo_codes.code')
                            ->get();

        return view('dashboard.promo_coupons', compact('promoCoupons', 'appliedCoupons'));
    }

    public function productReviews(){
        $productReviews = DB::table('product_reviews')
            ->join('products', 'product_reviews.product_id', 'products.id')
            ->select('products.name', 'products.image', 'product_reviews.rating', 'product_reviews.review', 'product_reviews.id', 'product_reviews.status')
            ->where('product_reviews.user_id', Auth::user()->id)
            ->orderBy('product_reviews.id', 'desc')
            ->paginate(5);

        return view('dashboard.product_reviews', compact('productReviews'));
    }

    public function deleteProductReview($id){
        DB::table('product_reviews')->where('id', $id)->where('user_id', Auth::user()->id)->delete();
        Toastr::success('Review is Deleted');
        return back();
    }

    public function updateProductReview(Request $request){
        DB::table('product_reviews')->where('id', $request->product_review_id)->where('user_id', Auth::user()->id)->update([
            'rating' => $request->review_rating,
            'review' => $request->review_text,
            'status' => 0
        ]);
        Toastr::success('Successfully Updated the Review');
        return back();
    }

    public function manageProfile(){
        return view('dashboard.manage_profile');
    }

    public function removeUserImage(){
        DB::table('users')->where('id', Auth::user()->id)->update([
            'image' => null,
        ]);
        Toastr::success('Successfully Removed the Image');
        return back();
    }

    public function unlinkGoogleAccount(){
        DB::table('users')->where('id', Auth::user()->id)->update([
            'provider_name' => null,
            'provider_id' => null,
        ]);
        Toastr::success('Successfully Unlinked Google Account');
        return back();
    }

    public function updateProfile(Request $request){

        $image = Auth::user()->image;
        if ($request->hasFile('image')){
            $get_attachment = $request->file('image');
            $attachment_name = str::random(5) . time() . '.' . $get_attachment->getClientOriginalExtension();
            $location = public_path('userProfileImages/');
            $get_attachment->move($location, $attachment_name);
            $image = "userProfileImages/" . $attachment_name;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => env('ADMIN_URL').'/api/upload/profile/photo',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'image' => new CURLFile(public_path($image))
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }


        DB::table('users')->where('id', Auth::user()->id)->update([
            'name' => $request->name,
            'image' => $image,
            'address' => $request->address,

        ]);
        Toastr::success('Successfully Profile Updated');
        return back();
    }

    public function sendOtpProfile(Request $request){
        $randomCode = rand(1000, 9999);
        $userInfo = Auth::user();

        session(['type' => $request->type, 'emailPhone' => $request->emailPhone]);

        DB::table('users')->where('id', $userInfo->id)->update([
            'verification_code' => $randomCode
        ]);

        if($request->type == 'email'){

            $mailData = array();
            $mailData['code'] = $randomCode;

            $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();
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

                    'mail.mailers.from' => $emailConfig->email,
                    'mail.mailers.name' => "TechShop",
                ]);

                try {
                    Mail::to(trim($request->emailPhone))->send(new UserVerificationMail($mailData));
                } catch(\Exception $e) {
                    // write code for handling error from here
                }
            }


        } else {

            $smsGateway = DB::table('sms_gateways')->where('status', 1)->first();
            if($smsGateway && $smsGateway->provider_name == 'Reve'){
                $response = Http::get($smsGateway->api_endpoint, [
                    'apikey' => $smsGateway->api_key,
                    'secretkey' => $smsGateway->secret_key,
                    "callerID" => $smsGateway->sender_id,
                    "toUser" => $request->emailPhone,
                    "messageContent" => "Verification Code is : ". $randomCode
                ]);

                if($response->status() != 200){
                    Toastr::error('Something Went Wrong', 'Failed to send SMS');
                    return back();
                }

            } elseif($smsGateway && $smsGateway->provider_name == 'ElitBuzz'){

                $response = Http::get($smsGateway->api_endpoint, [
                    'api_key' => $smsGateway->api_key,
                    "type" => "text",
                    "contacts" => $request->emailPhone, //“88017xxxxxxxx,88018xxxxxxxx”
                    "senderid" => $smsGateway->sender_id,
                    "msg" => $randomCode . " is your OTP verification code for shadikorun.com"
                ]);

                if($response->status() != 200){
                    Toastr::error('Something Went Wrong', 'Failed to send SMS');
                    return back();
                }

            } else {
                Toastr::error('No SMS Gateway is Active Now', 'Failed to send SMS');
                return back();
            }

        }

        return response()->json(['success' => true, 'message' => 'OTP Sent Successfully']);
    }

    public function verifySentOtp(Request $request){

        $verificationCode = '';
        foreach($request->code as $code){
            $verificationCode .= $code;
        }

        $type = session('type');
        $emailPhone = session('emailPhone');

        $userInfo = Auth::user();
        if($userInfo->verification_code == $verificationCode){
            if($type == 'phone'){

                if(User::where('id', $userInfo->id)->where('phone', $emailPhone)->exists()){
                    Toastr::error('Phone No Already Exists');
                    return redirect('/manage/profile');
                }

                User::where('id', $userInfo->id)->update([
                    'phone' => $emailPhone
                ]);
            } else {

                if(User::where('id', $userInfo->id)->where('email', $emailPhone)->exists()){
                    Toastr::error('Phone No Already Exists');
                    return redirect('/manage/profile');
                }

                User::where('id', $userInfo->id)->update([
                    'email' => $emailPhone
                ]);
            }

            session()->forget('type');
            session()->forget('emailPhone');

            Toastr::success('Profile Updated Successfully', 'Successfully Verified');
            return redirect('/manage/profile');
        } else {
            Toastr::error('Wrong Verification Code', 'Failed');
            return redirect('/manage/profile');
        }

    }

    public function userAddress(){
        $addresses = DB::table('user_addresses')->where('user_id', Auth::user()->id)->get();
        return view('dashboard.user_address', compact('addresses'));
    }

    public function saveUserAddress(Request $request){

        $addressInfo = DB::table('user_addresses')->where('user_id', Auth::user()->id)->where('address_type', $request->address_type)->first();
        if($addressInfo){
            Toastr::error($request->address_type.' Address already Exists', 'Delete the Previous One');
            return back();
        }

        $districtInfo = DB::table('districts')->where('id', $request->shipping_district_id)->first();
        $upazilaInfo = DB::table('upazilas')->where('id', $request->shipping_thana_id)->first();

        DB::table('user_addresses')->insert([
            'user_id' => Auth::user()->id,
            'address_type' => $request->address_type,
            'name' => Auth::user()->name,
            'address' => $request->adress_line,
            'country' => 'Bangladesh',
            'city' => $districtInfo ? $districtInfo->name : '',
            'state' => $upazilaInfo ? $upazilaInfo->name : '',
            'post_code' => $request->postal_code,
            'phone' => Auth::user()->phone,
            'slug' => str::random(5) . time(),
            'created_at' => Carbon::now(),
        ]);

        Toastr::success('New Address Added', 'Saved Successfully');
        return back();

    }

    public function removeUserAddress($slug){
        DB::table('user_addresses')->where('slug', $slug)->delete();
        Toastr::success('Previous Address has Removed', 'Removed Successfully');
        return back();
    }

    public function updateUserAddress(Request $request){

        $districtInfo = DB::table('districts')->where('id', $request->edit_district_id)->first();
        $upazilaInfo = DB::table('upazilas')->where('id', $request->edit_shipping_thana_id)->first();

        DB::table('user_addresses')->where('slug', $request->address_slug)->update([
            'name' => Auth::user()->name,
            'address' => $request->edit_address_line,
            'city' => $districtInfo ? $districtInfo->name : '',
            'state' => $upazilaInfo ? $upazilaInfo->name : '',
            'post_code' => $request->edit_postal_Code,
            'phone' => Auth::user()->phone,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(['success' => 'Updated Successfully.']);
    }
}
