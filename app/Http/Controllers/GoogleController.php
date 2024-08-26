<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $socialLoginCredentials = DB::table('social_logins')->where('id', 1)->first();
        if($socialLoginCredentials && $socialLoginCredentials->gmail_client_id && $socialLoginCredentials->gmail_secret_id){
            config([
                'services.google.client_id' => $socialLoginCredentials->gmail_client_id,
                'services.google.client_secret' => $socialLoginCredentials->gmail_secret_id,
            ]);
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $socialLoginCredentials = DB::table('social_logins')->where('id', 1)->first();
        if($socialLoginCredentials && $socialLoginCredentials->gmail_client_id && $socialLoginCredentials->gmail_secret_id){
            config([
                'services.google.client_id' => $socialLoginCredentials->gmail_client_id,
                'services.google.client_secret' => $socialLoginCredentials->gmail_secret_id,
            ]);
        }

        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::where('provider_id', $user->id)->first();

            if($finduser){
                Auth::login($finduser);

                if(session('last_visited_url') != ''){
                    return redirect(session('last_visited_url'));
                }

                if(session('cart') && count(session('cart')) > 0){
                    return redirect('/checkout');
                } else {
                    return redirect('/home');
                }

            } else{

                $newUserId = User::insertGetId([
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider_name' => 'google',
                    'provider_id'=> $user->id,
                    'password' => Hash::make('GetMarried1234'),
                    'user_type' => 3,
                    'status' => 1,
                    'email_verified_at' => Carbon::now()
                ]);

                $userInfo = User::where('id', $newUserId)->first();

                Auth::login($userInfo);

                if(session('cart') && count(session('cart')) > 0){
                    return redirect('/checkout');
                } else {
                    return redirect('/home');
                }
            }

        } catch (Exception $e) {
            // dd($e->getMessage());
            Toastr::error('Manual Account Created with this Email', 'Try Login with Password');
            return redirect(env('APP_URL'));
        }

    }
}
