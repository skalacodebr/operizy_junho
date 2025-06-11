<?php

namespace App\Http\Controllers;

use App\Models\ProductFilter;
use App\Models\ProductFilterValue;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductFilterController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $user = \Auth::user();
            $store = Store::where('id', $user->current_store)->first();
            $filters = ProductFilter::where('store_id', $store->id)->orderBy('id', 'DESC')->get();
            return view('product.filters.index', compact('filters'));
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
            return view('product.filters.create');
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
                    'type' => 'required|in:select,checkbox,radio,color',
                    'values' => 'required|array|min:1',
                    'values.*' => 'required|string|max:120'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $filter = new ProductFilter();
            $filter->name = $request->name;
            $filter->type = $request->type;
            $filter->is_active = $request->has('is_active');
            $filter->created_by = \Auth::user()->creatorId();
            $filter->store_id = \Auth::user()->current_store;
            $filter->save();

            foreach($request->values as $key => $value)
            {
                $filterValue = new ProductFilterValue();
                $filterValue->filter_id = $filter->id;
                $filterValue->value = $value;
                $filterValue->color = $request->colors[$key] ?? null;
                $filterValue->order = $key;
                $filterValue->save();
            }

            return redirect()->route('product.filters.index')->with('success', __('Filter successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(ProductFilter $filter)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            return view('product.filters.edit', compact('filter'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, ProductFilter $filter)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'type' => 'required|in:select,checkbox,radio,color',
                    'values' => 'required|array|min:1',
                    'values.*' => 'required|string|max:120'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $filter->name = $request->name;
            $filter->type = $request->type;
            $filter->is_active = $request->has('is_active');
            $filter->save();

            // Remove valores antigos
            $filter->values()->delete();

            // Adiciona novos valores
            foreach($request->values as $key => $value)
            {
                $filterValue = new ProductFilterValue();
                $filterValue->filter_id = $filter->id;
                $filterValue->value = $value;
                $filterValue->color = $request->colors[$key] ?? null;
                $filterValue->order = $key;
                $filterValue->save();
            }

            return redirect()->route('product.filters.index')->with('success', __('Filter successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(ProductFilter $filter)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            // Remove valores do filtro
            $filter->values()->delete();
            
            // Remove o filtro
            $filter->delete();

            return redirect()->route('product.filters.index')->with('success', __('Filter successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
} 