<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerificationMail;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{
    public function userForgetPassword(){
        return view('forget_password');
    }

    public function sendForgetPasswordCode(Request $request){
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
        ]);

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {

            $randomCode = rand(100000, 999999);
            $userInfo = User::where('email', $request->username)->first();
            if($userInfo){
                User::where('id', $userInfo->id)->update([
                    'verification_code' => $randomCode
                ]);

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
                        'mail.mailers.name' => "Fejmo",
                    ]);

                    try {
                        Mail::to(trim($userInfo->email))->send(new UserVerificationMail($mailData));
                    } catch(\Exception $e) {
                        // write code for handling error from here
                    }
                }


                session(['username' => $request->username]);

                Toastr::success('Password Reset Code Sent', 'Code Sent Successfully');
                // return view('frontend.change_password');
                return redirect('/new/password');
            } else {
                Toastr::error('No Account Found', '! Failed');
                return back();
            }

        } else {

            $randomCode = rand(100000, 999999);
            $userInfo = User::where('phone', $request->username)->first();
            if($userInfo){
                User::where('id', $userInfo->id)->update([
                    'verification_code' => $randomCode
                ]);

                $smsGateway = DB::table('sms_gateways')->where('status', 1)->first();
                if($smsGateway && $smsGateway->provider_name == 'Reve'){
                    $response = Http::get($smsGateway->api_endpoint, [
                        'apikey' => $smsGateway->api_key,
                        'secretkey' => $smsGateway->secret_key,
                        "callerID" => $smsGateway->sender_id,
                        "toUser" => $userInfo->phone,
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
                        "contacts" => $userInfo->phone, //“88017xxxxxxxx,88018xxxxxxxx”
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

                session(['username' => $request->username]);

                Toastr::success('Password Reset Code Sent', 'Code Sent Successfully');
                // return view('frontend.change_password');
                return redirect('/new/password');
            } else {
                Toastr::error('No Account Found', '! Failed');
                return back();
            }
        }
    }

    public function newPasswordPage(){
        return view('change_password');
    }

    public function changeForgetPassword(Request $request){

        $request->validate([
            'code' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255', 'min:8'],
        ]);

        $username = session('username');
        $code = $request->code;
        $password = $request->password;

        $userInfo = User::where('email', $username)->where('verification_code', $code)->first();
        if($userInfo){
            $userInfo->password = Hash::make($password);
            $userInfo->email_verified_at = Carbon::now();
            $userInfo->save();
            Auth::login($userInfo);

            Toastr::success('Successfully Changed the Password', 'Password Changed');
            return redirect('/home');
        } else {

            $userInfo = User::where('phone', $username)->where('verification_code', $code)->first();
            if($userInfo){
                $userInfo->password = Hash::make($password);
                $userInfo->email_verified_at = Carbon::now();
                $userInfo->save();
                Auth::login($userInfo);

                Toastr::success('Successfully Changed the Password', 'Password Changed');
                return redirect('/home');
            } else {
                Toastr::error('Wrong Verification Code', 'Try Again');
                return back();
            }
        }

    }
}
