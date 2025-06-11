<?php

namespace App\Http\Controllers;

use App\Models\ProductTag;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductTagController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $user = \Auth::user();
            $store = Store::where('id', $user->current_store)->first();
            $tags = ProductTag::where('store_id', $store->id)->orderBy('id', 'DESC')->get();
            return view('product.tags.index', compact('tags'));
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
            return view('product.tags.create');
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
                    'type' => 'required|in:tag,seal'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $tag = new ProductTag();
            $tag->name = $request->name;
            $tag->type = $request->type;
            $tag->color = $request->color;
            $tag->icon = $request->icon;
            $tag->is_active = $request->has('is_active');
            $tag->created_by = \Auth::user()->creatorId();
            $tag->store_id = \Auth::user()->current_store;
            $tag->save();

            return redirect()->route('product.tags.index')->with('success', __('Tag successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(ProductTag $tag)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            return view('product.tags.edit', compact('tag'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, ProductTag $tag)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'type' => 'required|in:tag,seal'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $tag->name = $request->name;
            $tag->type = $request->type;
            $tag->color = $request->color;
            $tag->icon = $request->icon;
            $tag->is_active = $request->has('is_active');
            $tag->save();

            return redirect()->route('product.tags.index')->with('success', __('Tag successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(ProductTag $tag)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $tag->delete();
            return redirect()->route('product.tags.index')->with('success', __('Tag successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
} 