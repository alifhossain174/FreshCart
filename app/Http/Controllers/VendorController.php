<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorRegistrationMail;
use App\Mail\VendorRegistrationSuccessMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function vendorShops(Request $request){
        $stores = DB::table('stores')->where('status', 1)->orderBy('id', 'asc')->paginate(9);
        return view('vendors.shops', compact('stores'));
    }

    public function vendorRegistration(){
        return view('vendors.registration');
    }

    public function submitVendorRegistration(Request $request){

        if(DB::table('users')->where('email', $request->email)->exists()){
            Toastr::error('Email Already Exists', 'Failed to Register');
            return back();
        }

        $verificationCode = rand(100000,999999);
        session([
            'vendor_name' => $request->name,
            'verification_code' => $verificationCode,
            'vendor_email' => $request->email,
            'login_password' => $request->password
        ]);

        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'email_verified_at' => null,
            'verification_code' => $verificationCode,
            'user_type' => 4, //vendor
            'status' => 0,
            'created_at' => Carbon::now()
        ]);

        $nidCard = NULL;
        if ($request->hasFile('nid_card')){
            $get_attachment = $request->file('nid_card');
            $attachment_name = str::random(5) . time() . '.' . $get_attachment->getClientOriginalExtension();
            $location = public_path('vendor_attachments/');
            $get_attachment->move($location, $attachment_name);
            $nidCard = "vendor_attachments/" . $attachment_name;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => env('ADMIN_URL').'/api/upload/vendor/nid',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'attachment'=> new CURLFile(public_path($nidCard))
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }

        $tradeLicense = NULL;
        if ($request->hasFile('trade_license')){
            $get_attachment = $request->file('trade_license');
            $attachment_name = str::random(5) . time() . '.' . $get_attachment->getClientOriginalExtension();
            $location = public_path('vendor_attachments/');
            $get_attachment->move($location, $attachment_name);
            $tradeLicense = "vendor_attachments/" . $attachment_name;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => env('ADMIN_URL').'/api/upload/vendor/license',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'attachment'=> new CURLFile(public_path($tradeLicense))
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }

        DB::table('vendors')->insert([
            'user_id' => $userId,
            'vendor_no' => time(). str::random(5),
            'business_name' => $request->business_name,
            'business_category' => $request->business_category ? implode(",", $request->business_category) : null,
            'trade_license_no' => $request->trade_license_no,
            'business_address' => $request->business_address,
            'nid_card' => $nidCard,
            'trade_license' => $tradeLicense,
            'created_at' => Carbon::now()
        ]);

        $mailData = array();
        $mailData['vendor_name'] = $request->name;
        $mailData['verification_code'] = $verificationCode;
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
                Mail::to(trim($request->email))->send(new VendorRegistrationMail($mailData));
            } catch(\Exception $e) {
                // write code for handling error from here
            }
        }

        Toastr::success('Verification email is sent', 'Check Your Email');
        return redirect('vendor/verification');
    }

    public function vendorVerification(){
        return view('vendors.verification');
    }

    public function vendorVerificationCheck(Request $request){

        $verificationCode = session('verification_code');
        $vendorEmail = session('vendor_email');
        $loginPassword = session('login_password');
        $vendorName = session('vendor_name');

        $submittedVerificationCode = '';
        foreach($request->code as $code){
            $submittedVerificationCode .= $code;
        }

        if($verificationCode != $submittedVerificationCode){

            Toastr::error('Wrong Verification Code');
            return back();

        } else {

            User::where('email', $vendorEmail)->update([
                'email_verified_at' => Carbon::now()
            ]);


            $mailData = array();
            $mailData['vendor_name'] = $vendorName;
            $mailData['vendor_email'] = $vendorEmail;
            $mailData['login_password'] = $loginPassword;
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
                    Mail::to(trim($vendorEmail))->send(new VendorRegistrationSuccessMail($mailData));
                } catch(\Exception $e) {
                    // write code for handling error from here
                }
            }

            session()->forget('verification_code');
            session()->forget('vendor_email');
            session()->forget('login_password');
            session()->forget('vendor_name');

            Toastr::success('Vendor Registration Request Submitted', 'Check Your Email');
            return redirect('/');

        }

    }
}
