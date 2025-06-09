<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Plan;
use App\Models\PlanOrder;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('Manage Plans')){
            $objUser = \Auth::user();
            // if ($objUser->type == 'super admin' || $objUser->type == 'Owner') {
                if ($objUser->type == 'super admin') {
                    $orders = PlanOrder::select(
                        [
                            'plan_orders.*',
                            'users.name as user_name',
                        ]
                    )->join('users', 'plan_orders.user_id', '=', 'users.id')->orderBy('plan_orders.created_at', 'DESC')->get();

                    $userOrders = PlanOrder::select('*')
                        ->whereIn('id', function ($query) {
                            $query->selectRaw('MAX(id)')
                                ->from('plan_orders')
                                ->groupBy('user_id');
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
                    
                    $plans = Plan::get();
                    $admin_payments_setting = Utility::getAdminPaymentSetting();
                    return view('plans.index', compact('plans', 'orders', 'admin_payments_setting', 'userOrders'));
                } else {
                    $orders = PlanOrder::select(
                        [
                            'plan_orders.*',
                            'users.name as user_name',
                        ]
                    )->join('users', 'plan_orders.user_id', '=', 'users.id')->orderBy('plan_orders.created_at', 'DESC')->where('users.id', '=', $objUser->id)->get();
                    $plans = Plan::where('is_active',1)->get();
                    $admin_payments_setting = Utility::getAdminPaymentSetting();
                    return view('plans.index', compact('plans', 'orders', 'admin_payments_setting'));
                }
    
            // } else {
            //     return redirect()->route('dashboard');
            // }
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('Create Plans')){
            if (\Auth::user()->type == 'super admin') {
                $arrDuration = Plan::$arrDuration;

                return view('plans.create', compact('arrDuration'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Plans')){
            if (\Auth::user()->type == 'super admin') {
                $admin_payments_setting = Utility::getAdminPaymentSetting();
                    $validation = [];
                    $validation['name'] = 'required|unique:plans';
                    $validation['price'] = 'required|numeric|min:0';
                    $validation['duration'] = 'required';
                    $validation['max_stores'] = 'required|numeric';
                    $validation['max_products'] = 'required|numeric';
                    $validation['max_users'] = 'required|numeric';
                    $validation['storage_limit'] = 'required|numeric';

                    if ($request->image) {
                        $validation['image'] = 'required|mimes:jpeg,png,jpg,gif,svg,pdf,doc|max:20480';
                    }

                    $request->validate($validation);
                    $post = $request->all();
                    if ($request->hasFile('image')) {
                        $filenameWithExt = $request->file('image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $fileNameToStore = 'plan_' . time() . '.' . $extension;

                        $dir = storage_path('uploads/plan/');
                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $path = $request->file('image')->storeAs('uploads/plan/', $fileNameToStore);
                        $post['image'] = $fileNameToStore;
                    }

                    if (!isset($request->enable_custdomain)) {
                        $post['enable_custdomain'] = 'off';
                    }
                    if (!isset($request->enable_custsubdomain)) {
                        $post['enable_custsubdomain'] = 'off';
                    }
                    if (!isset($request->additional_page)) {
                        $post['additional_page'] = 'off';
                    }
                    if (!isset($request->blog)) {
                        $post['blog'] = 'off';
                    }
                    if (!isset($request->shipping_method)) {
                        $post['shipping_method'] = 'off';
                    }
                    if (!isset($request->enable_chatgpt)) {
                        $post['enable_chatgpt'] = 'off';
                    }
                    if (!isset($request->pwa_store)) {
                        $post['pwa_store'] = 'off';
                    }

                    if($request->trial == 1)
                    {
                        $post['trial'] = 'on';
                        $post['trial_days'] = !empty($request->trial_days) ? $request->trial_days : 0;
                    } else {
                        $post['trial'] = 'off';
                    }

                    if (Plan::create($post)) {
                        return redirect()->back()->with('success', __('Plan created Successfully!'));
                    } else {
                        return redirect()->back()->with('error', __('Something is wrong'));
                    }
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($plan_id)
    {
        if(\Auth::user()->can('Edit Plans')){
            if (\Auth::user()->type == 'super admin') {
                $arrDuration = Plan::$arrDuration;
                $plan = Plan::find($plan_id);

                return view('plans.edit', compact('plan', 'arrDuration'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function update($planID, Request $request)
    {
        if(\Auth::user()->can('Edit Plans')){
            if (\Auth::user()->type == 'super admin') {
                $admin_payments_setting = Utility::getAdminPaymentSetting();
                    $plan = Plan::find($planID);
                    if ($plan) {
                        if ($plan->price > 0) {
                            $validator = \Validator::make(
                                $request->all(), [
                                    'name' => 'required|unique:plans,name,' . $planID,
                                    'price' => 'required|numeric|min:0',
                                    'duration' => 'required',
                                    'max_stores' => 'required|numeric',
                                    'max_products' => 'required|numeric',
                                    'max_users' => 'required|numeric',
                                ]
                            );
                        } else {
                            $validator = \Validator::make(
                                $request->all(), [
                                    'name' => 'required|unique:plans,name,' . $planID,
                                    'duration' => 'required',
                                    'max_stores' => 'required|numeric',
                                    'max_products' => 'required|numeric',
                                    'max_users' => 'required|numeric',
                                    'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc|max:20480',
                                ]
                            );
                        }
                        {

                        }
                        if ($validator->fails()) {
                            $messages = $validator->getMessageBag();

                            return redirect()->back()->with('error', $messages->first());
                        }

                        $post = $request->all();
                        if (!isset($request->enable_custdomain)) {
                            $post['enable_custdomain'] = 'off';
                        }
                        if (!isset($request->enable_custsubdomain)) {
                            $post['enable_custsubdomain'] = 'off';
                        }
                        if (!isset($request->additional_page)) {
                            $post['additional_page'] = 'off';
                        }
                        if (!isset($request->blog)) {
                            $post['blog'] = 'off';
                        }
                        if (!isset($request->shipping_method)) {
                            $post['shipping_method'] = 'off';
                        }
                        if (!isset($request->enable_chatgpt)) {
                            $post['enable_chatgpt'] = 'off';
                        }
                        if (!isset($request->pwa_store)) {
                            $post['pwa_store'] = 'off';
                        }

                        if ($request->hasFile('image')) {
                            $filenameWithExt = $request->file('image')->getClientOriginalName();
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension = $request->file('image')->getClientOriginalExtension();
                            $fileNameToStore = 'plan_' . time() . '.' . $extension;

                            $dir = storage_path('uploads/plan/');
                            if (!file_exists($dir)) {
                                mkdir($dir, 0777, true);
                            }
                            $image_path = $dir . '/' . $plan->image; // Value is not URL but directory file path
                            if (\File::exists($image_path)) {
                                chmod($image_path, 0755);
                                \File::delete($image_path);
                            }

                            $path = $request->file('image')->storeAs('uploads/plan/', $fileNameToStore);
                            $post['image'] = $fileNameToStore;
                        }

                        if($request->trial == 1)
                        {
                            $post['trial'] = 'on';
                            $post['trial_days'] = !empty($request->trial_days) ? $request->trial_days : 0;
                        } else {
                            $post['trial'] = 'off';
                        }

                        if ($plan->update($post)) {
                            return redirect()->back()->with('success', __('Plan updated Successfully!'));
                        } else {
                            return redirect()->back()->with('error', __('Something is wrong'));
                        }
                    } else {
                        return redirect()->back()->with('error', __('Plan not found'));
                    }
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($planID)
    {
        if(\Auth::user()->can('Edit Plans')){
            if (\Auth::user()->type == 'super admin') {
                $userPlan = User::where('plan' , $planID)->first();
                if($userPlan != null)
                {
                    return redirect()->back()->with('error', __('The company has subscribed to this plan, so it cannot be deleted.'));
                }
                Plan::where('id',$planID)->delete();
                return redirect()->route('plans.index')->with('success', __('Plan deleted Successfully!'));
            }
            else{
                return redirect()->back()->with('error', 'Permission denied.');
            } 
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        } 
    }

    public function userPlan(Request $request)
    {
        $objUser = \Auth::user();
        $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->code);
        $plan = Plan::find($planID);
        if ($plan) {
            if ($plan->monthly_price <= 0) {
                $objUser->assignPlan($plan->id);

                return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } else {
            return redirect()->back()->with('error', __('Plan not found'));
        }
    }

    public function payment($code)
    {
        $planID = \Illuminate\Support\Facades\Crypt::decrypt($code);
        $plan = Plan::find($planID);
        if ($plan) {
            return view('plans.payment', compact('plan'));
        } else {
            return redirect()->back()->with('error', __('Plan is deleted.'));
        }
    }

    public function planPrepareAmount(Request $request)
    {

        $plan = Plan::find(\Illuminate\Support\Facades\Crypt::decrypt($request->plan_id));

        if ($plan) {
            $original_price = number_format($plan->price);
            $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
            $coupon_id = null;
            if (!empty($coupons)) {
                $usedCoupun = $coupons->used_coupon();
                if ($coupons->limit == $usedCoupun) {
                } else {
                    $discount_value = ($plan->price / 100) * $coupons->discount;
                    $plan_price = $plan->price - $discount_value;
                    $price = $plan->price - $discount_value;
                    $discount_value = '-' . $discount_value;
                    $coupon_id = $coupons->id;
                    return response()->json(
                        [
                            'is_success' => true,
                            'discount_price' => $discount_value,
                            'final_price' => $price,
                            'price' => $plan_price,
                            'coupon_id' => $coupon_id,
                            'message' => __('Coupon code has applied successfully.'),
                        ]
                    );
                }
            } else {
                return response()->json(
                    [
                        'is_success' => true,
                        'final_price' => $original_price,
                        'coupon_id' => $coupon_id,
                        'price' => $plan->price,
                    ]
                );
            }
        }
    }
    public function planorderdestroy($id)
    {
        $planorder = PlanOrder::find($id);
        $planorder->delete();
        return redirect()->back()->with('success', __('Plan Order Deleted!'));
    }

    public function planTrial($plan)
    {
        $objUser = \Auth::user();
        $planID  = \Illuminate\Support\Facades\Crypt::decrypt($plan);
        $plan    = Plan::find($planID);

        if($plan)
        {
            if($plan->price > 0)
            {
                $user = User::find($objUser->id);
                $user->trial_plan = $planID;
                $currentDate = date('Y-m-d');
                $numberOfDaysToAdd = $plan->trial_days;

                $newDate = date('Y-m-d', strtotime($currentDate . ' + ' . $numberOfDaysToAdd . ' days'));
                $user->trial_expire_date = $newDate;
                $user->save();

                $objUser->assignPlan($planID);

                return redirect()->route('plans.index')->with('success', __('Plan successfully activated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Plan not found.'));
        }
    }

    public function planActive(Request $request)
    {
        $userPlan = User::where('plan' , $request->id)->first();
        if($userPlan != null)
        {
            return response()->json(['error' =>__('The company has subscribed to this plan, so it cannot be disabled.')]);
        }

        Plan::where('id', $request->id)->update(['is_active' => $request->is_active]);

        if ($request->is_active == 1) {            
            return response()->json(['success' => __('Plan successfully enable.')]);

        } else {
            return response()->json(['success' => __('Plan successfully disable.')]);
        }
    }

    public function refund(Request $request , $id , $user_id)
    {
        PlanOrder::where('id', $id)->update(['is_refund' => 1]);

        $user = User::find($user_id);

        $user->assignPlan(1);

        return redirect()->back()->with('success' , __('We successfully planned a refund and assigned a free plan.'));
    }

}
