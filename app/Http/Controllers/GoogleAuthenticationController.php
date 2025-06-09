<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class GoogleAuthenticationController extends Controller
{
    public function generate2faSecret()
    {
        $user = Auth::user();
        if(isset($user) && ($user->type == 'super admin' || $user->type == 'Owner')){
            $google2fa = new Google2FA();
            $secret = $google2fa->generateSecretKey();

            if (!$user->google2fa_secret) {
                $user->google2fa_enable = 0;
                $user->google2fa_secret = $secret;
                $user->save();
            }

            return redirect()->route('profile')->with('success', __('Secret key generated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function enable2fa(Request $request)
    {
        $user = Auth::user();
        if(isset($user) && ($user->type == 'super admin' || $user->type == 'Owner')){
            $google2fa = new Google2FA();
            $secret = $request->input('secret');
            $verify = $google2fa->verifyKey($user->google2fa_secret, $secret);
            if ($verify) {
                $user->google2fa_enable = 1;
                $user->save();
                return redirect()->route('profile')->with('success', __('2FA is enabled successfully.'));
            } else {
                return redirect()->back()->with('error', __('Invalid verification code, Please try again.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function disable2fa()
    {
        $user = Auth::user();
        if(isset($user) && ($user->type == 'super admin' || $user->type == 'Owner')){
            $validator = \Validator::make(
                request()->all(),
                [
                    'password' => 'required',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            if (! (\Hash::check(request()->password, $user->password))) {
                return redirect()->route('profile')->with('error', __('Your password does not matches with your account password. Please try again.'));
            }
            $user->google2fa_enable = 0;
            $user->save();
            return redirect()->route('profile')->with('success', __('2FA is now disabled.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
