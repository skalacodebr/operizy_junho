<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utility;
use App\Models\Store;

class themeController extends Controller
{
    public function index(){
        if(\Auth::user()->can('Manage Themes')){
            $user = \Auth::user();
            $store_settings = Store::where('id', $user->current_store)->first();
            $theme_json = \App\Models\Utility::themeOne();
            return view('themes.themes',compact('store_settings', 'theme_json'));
        }
        else{
            return redirect()->back()->with('error',__('Permission Denied.'));
        }
    }
}
