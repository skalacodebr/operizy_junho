<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Models\Blog;
use App\Models\PageOption;
use App\Models\Store;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\CustomerPasswordResetMail;
use App\Models\Customer;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class CustomerForgotPasswordController extends Controller
{
    public function __construct()
    {
        $lang = session()->get('lang');
        \App::setLocale(isset($lang) ? $lang : 'en');
    }

    
    public function showLinkRequestForm($slug)
    {
        $store = Store::where('slug', $slug)->where('is_store_enabled', '1')->first();
        if (empty($store)) {
            return redirect()->back()->with('error', __('Store not available'));
        }
        $page_slug_urls = PageOption::where('store_id', $store->id)->get();
        $blog           = Blog::where('store_id', $store->id)->first();
        $cart = session()->get($slug);
        $total_item = 0;
        if(isset($cart['products']))
        {
            if(isset($cart) && !empty($cart['products']))
            {
                $total_item = count($cart['products']);
            }
            else
            {
                $total_item = 0;
            }
        }

        if(empty($store))
        {
            return redirect()->back()->with('error', __('Store not available'));
        }

        if (Utility::CustomerAuthCheck($slug) == true){
            return redirect()->route('customer.home',$slug);
        }
        else{
            return view('storefront.' . $store->theme_dir . '.auth.forgot-password', compact('blog','total_item', 'store', 'slug', 'page_slug_urls'));
        }
    }

    public function postCustomerEmail(Request $request,$slug)
    {
        try{
            $store = Store::where('slug', $slug)->where('is_store_enabled', '1')->first();
            if (empty($store)) {
                return redirect()->back()->with('error', __('Store not available'));
            }

            $request->validate(
                [
                    'email' => 'required|email|exists:customers',
                ]
            );

            $token = \Str::random(60);

            DB::table('password_resets')->insert(
                [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]
            );
            if (isset($store->mail_driver) && !empty($store->mail_driver))
            {
                config(
                    [
                        'mail.driver' => $store->mail_driver,
                        'mail.host' => $store->mail_host,
                        'mail.port' => $store->mail_port,
                        'mail.encryption' => $store->mail_encryption,
                        'mail.username' => $store->mail_username,
                        'mail.password' => $store->mail_password,
                        'mail.from.address' => $store->mail_from_address,
                        'mail.from.name' => $store->mail_from_name,
                    ]
                );
            }else{
                $settings = Utility::getSMTPDetails(1);
            }
            Mail::to(
                [
                    $request->email,
                ]
            )->send(new CustomerPasswordResetMail($token, $slug));

            return back()->with('success', __('We have e-mailed your password reset link!'));
        } catch(\Exception $e) {
            return redirect()->back()->with('error',__('E-Mail has been not sent due to SMTP configuration'));
        }
    }

    public function resetPassword($slug,$token = null)
    {
        $store          = Store::where('slug', $slug)->first();
        if(empty($store))
        {
            return redirect()->route('customer.loginform',$slug)->with('error', __('Store not available'));
        }
        $page_slug_urls = PageOption::where('store_id', $store->id)->get();
        $blog           = Blog::where('store_id', $store->id)->first();
        $cart = session()->get($slug);
        $total_item = 0;
        if(isset($cart['products']))
        {
            if(isset($cart) && !empty($cart['products']))
            {
                $total_item = count($cart['products']);
            }
            else
            {
                $total_item = 0;
            }
        }
        return view('storefront.' . $store->theme_dir . '.auth.reset-password', compact('token','blog','total_item', 'store', 'slug', 'page_slug_urls'));
    }

    public function updateCustomerPassword(Request $request,$slug)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:customers',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',

            ]
        );

        $updatePassword = DB::table('password_resets')->where(
            [
                'email' => $request->email,
                'token' => $request->token,
            ]
        )->first();

        if(!$updatePassword)
        {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = Customer::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('customer.loginform',$slug)->with('success', __('Password has been changed Successfully!'));

    }
}
