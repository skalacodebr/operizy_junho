<?php

namespace App\Http\Controllers;

use App\Models\ProductBrand;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductBrandController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $user = \Auth::user();
            $store = Store::where('id', $user->current_store)->first();
            $brands = ProductBrand::where('store_id', $store->id)->orderBy('id', 'DESC')->get();
            return view('product.brands.index', compact('brands'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Manage Products'))
        {
            return view('product.brands.create');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $brand = new ProductBrand();
            $brand->name = $request->name;
            $brand->description = $request->description;
            $brand->is_active = $request->has('is_active');
            $brand->created_by = \Auth::user()->creatorId();
            $brand->store_id = \Auth::user()->current_store;

            if($request->hasFile('logo'))
            {
                $logo = $request->file('logo');
                $name = 'brand_'.time().'.'.$logo->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/brands');
                $logo->move($destinationPath, $name);
                $brand->logo = $name;
            }

            $brand->save();

            return redirect()->route('product.brands.index')->with('success', __('Brand successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(ProductBrand $brand)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            return view('product.brands.edit', compact('brand'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, ProductBrand $brand)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $brand->name = $request->name;
            $brand->description = $request->description;
            $brand->is_active = $request->has('is_active');

            if($request->hasFile('logo'))
            {
                if($brand->logo)
                {
                    $path = public_path('/uploads/brands/'.$brand->logo);
                    if(file_exists($path))
                    {
                        unlink($path);
                    }
                }

                $logo = $request->file('logo');
                $name = 'brand_'.time().'.'.$logo->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/brands');
                $logo->move($destinationPath, $name);
                $brand->logo = $name;
            }

            $brand->save();

            return redirect()->route('product.brands.index')->with('success', __('Brand successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(ProductBrand $brand)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            if($brand->logo)
            {
                $path = public_path('/uploads/brands/'.$brand->logo);
                if(file_exists($path))
                {
                    unlink($path);
                }
            }

            $brand->delete();

            return redirect()->route('product.brands.index')->with('success', __('Brand successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
} 