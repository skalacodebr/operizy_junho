<?php

namespace App\Http\Controllers;

use App\Models\ProductCollection;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductCollectionController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $user = \Auth::user();
            $store = Store::where('id', $user->current_store)->first();
            $collections = ProductCollection::where('store_id', $store->id)->orderBy('id', 'DESC')->get();
            return view('product.collections.index', compact('collections'));
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
            return view('product.collections.create');
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
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $collection = new ProductCollection();
            $collection->name = $request->name;
            $collection->description = $request->description;
            $collection->is_active = $request->has('is_active');
            $collection->created_by = \Auth::user()->creatorId();
            $collection->store_id = \Auth::user()->current_store;

            if($request->hasFile('image'))
            {
                $image = $request->file('image');
                $name = 'collection_'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/collections');
                $image->move($destinationPath, $name);
                $collection->image = $name;
            }

            $collection->save();

            return redirect()->route('product.collections.index')->with('success', __('Collection successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(ProductCollection $collection)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            return view('product.collections.edit', compact('collection'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, ProductCollection $collection)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $collection->name = $request->name;
            $collection->description = $request->description;
            $collection->is_active = $request->has('is_active');

            if($request->hasFile('image'))
            {
                if($collection->image)
                {
                    $path = public_path('/uploads/collections/'.$collection->image);
                    if(file_exists($path))
                    {
                        unlink($path);
                    }
                }

                $image = $request->file('image');
                $name = 'collection_'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/collections');
                $image->move($destinationPath, $name);
                $collection->image = $name;
            }

            $collection->save();

            return redirect()->route('product.collections.index')->with('success', __('Collection successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(ProductCollection $collection)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            if($collection->image)
            {
                $path = public_path('/uploads/collections/'.$collection->image);
                if(file_exists($path))
                {
                    unlink($path);
                }
            }

            $collection->delete();

            return redirect()->route('product.collections.index')->with('success', __('Collection successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
} 