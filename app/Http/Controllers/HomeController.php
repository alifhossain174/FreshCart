<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function submitProductReview(Request $request){

        $purchaseStatus = DB::table('order_details')
                            ->join('orders', 'order_details.order_id', 'orders.id')
                            ->where('orders.order_status', 3)
                            ->where('orders.user_id', Auth::user()->id)
                            ->where('product_id', $request->review_product_id)
                            ->first();

        if(!$purchaseStatus){
            Toastr::error('Approved order is required for submitting a review.');
            return back();
        }

        $alreadyReviewSubmitted = DB::table('product_reviews')
                                    ->where('user_id', Auth::user()->id)
                                    ->where('product_id', $request->review_product_id)
                                    ->count();

        if($alreadyReviewSubmitted >= 1){
            Toastr::warning('You have Already submitted a review');
            return back();
        }

        DB::table('product_reviews')->insert([
            'product_id' => $request->review_product_id,
            'user_id' => Auth::user()->id,
            'rating' => $request->rarting,
            'review' => $request->review,
            'slug' => str::random(5) . time(),
            'status' => 1,
            'created_at' => Carbon::now()
        ]);

        Toastr::success('Successfully Submitted Review');
        return back();
    }

    public function addToWishlist($slug){

        $productInfo = DB::table('products')->where('slug', $slug)->first();

        if(DB::table('wish_lists')->where('product_id', $productInfo->id)->where('user_id', Auth::user()->id)->exists()){
            Toastr::warning('Already in Wishlist');
            return back();
        } else {
            DB::table('wish_lists')->insert([
                'product_id' => $productInfo->id,
                'user_id' => Auth::user()->id,
                'slug' => str::random(5) . time(),
                'created_at' => Carbon::now()
            ]);
            Toastr::success('Added to Wishlist');
            return back();
        }

    }

}
