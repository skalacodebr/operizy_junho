<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Imports\ProductImport;
use App\Models\Plan;
use App\Models\Product;
use App\Models\ProductCategorie;
use App\Models\ProductTax;
use App\Models\ProductVariantOption;
use App\Models\Product_images;
use App\Models\Ratting;
use App\Models\Expresscheckout;
use App\Models\Store;
use App\Models\User;
use App\Models\Utility;
use App\Models\SalesChannel;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function __construct()
    {
        if (Auth::check()) {
            $userlang = \Auth::user()->lang;
            \App::setLocale($userlang);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Auth::user()->can('Manage Products'))
        {
            $user = \Auth::user();
            $products = Product::where('created_by', \Auth::user()->creatorId());

            // Filtrar por canal se especificado
            if ($request->has('channel')) {
                $channel = SalesChannel::where('slug', $request->channel)->firstOrFail();
                $products = $products->whereHas('salesChannels', function($query) use ($channel) {
                    $query->where('sales_channels.id', $channel->id);
                });
            }

            $products = $products->get();
            
            $productImg = \App\Models\Utility::get_file('uploads/is_cover_image/');

            return view('product.index', compact('products', 'productImg'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('Create Products'))
        {
            $user = \Auth::user();
            $store_id = Store::where('id', $user->current_store)->first();
            $productcategorie = ProductCategorie::where('store_id', $store_id->id)->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $producttax = ProductTax::where('store_id', $store_id->id)->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $brands = ProductBrand::where('store_id', $store_id->id)->where('created_by', \Auth::user()->creatorId())->where('is_active', true)->get();
            return view('product.create', compact('productcategorie', 'producttax', 'brands'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
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
        if(\Auth::user()->can('Create Products'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'product_categorie' => 'required',
                    'price' => 'required|numeric|min:0',
                    'quantity' => 'required|integer|min:0',
                    'brand_id' => 'nullable|exists:product_brands,id'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $product = new Product();
            $product->name = $request->name;
            $product->product_categorie = implode(',', $request->product_categorie);
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->brand_id = $request->brand_id;
            $product->created_by = \Auth::user()->creatorId();
            $product->store_id = \Auth::user()->current_store;
            $product->save();

            return redirect()->route('product.index')->with('success', __('Product successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if(\Auth::user()->can('Show Products')){
            $user = \Auth::user();
            $store = Store::where('id', $user->current_store)->first();

            if($user->current_store == $product->store_id){
                $product_image = Product_images::where('product_id', $product->id)->get();

                $product_tax = ProductTax::where('store_id', $store->id)->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $product_ratings = Ratting::where('product_id', $product->id)->get();

                $ratting = Ratting::where('product_id', $product->id)->where('rating_view', 'on')->sum('ratting');
                $user_count = Ratting::where('product_id', $product->id)->where('rating_view', 'on')->count();
                if ($user_count > 0) {
                    $avg_rating = number_format($ratting / $user_count, 1);
                } else {
                    $avg_rating = number_format($ratting / 1, 1);
                }

                $variant_name = json_decode($product->variants_json);
                $product_variant_names = $variant_name;

                $expresscheckout = Expresscheckout::where('store_id',$store->id)->where('product_id',$product->id)->with('product')->get();

                return view('product.view', compact('product', 'product_image', 'product_tax', 'product_ratings', 'store', 'avg_rating', 'user_count', 'product_variant_names','expresscheckout'));
            }else{
                return redirect()->back()->with('error', 'Permission denied.');
            }
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id)
    {
        if(\Auth::user()->can('Edit Products'))
        {
            $user = \Auth::user();
            $store_id = Store::where('id', $user->current_store)->first();
            $product = Product::find($product_id);
            $productcategorie = ProductCategorie::where('store_id', $store_id->id)->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $producttax = ProductTax::where('store_id', $store_id->id)->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $brands = ProductBrand::where('store_id', $store_id->id)->where('created_by', \Auth::user()->creatorId())->where('is_active', true)->get();
            return view('product.edit', compact('product', 'productcategorie', 'producttax', 'brands'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        if(\Auth::user()->can('Edit Products'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'product_categorie' => 'required',
                    'price' => 'required|numeric|min:0',
                    'quantity' => 'required|integer|min:0',
                    'brand_id' => 'nullable|exists:product_brands,id'
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $product = Product::find($product_id);
            $product->name = $request->name;
            $product->product_categorie = implode(',', $request->product_categorie);
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->brand_id = $request->brand_id;
            $product->save();

            return redirect()->route('product.index')->with('success', __('Product successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(\Auth::user()->can('Delete Products')){
            Ratting::where('product_id', $product->id)->delete();
            $Product_images = Product_images::where('product_id', $product->id)->get();
            $pro_img = new ProductController();

            // $dir = storage_path('uploads/is_cover_image/');
            // if (!empty($product->is_cover)) {
            //     unlink($dir . $product->is_cover);
            // }
            if(isset($product->is_cover) && !empty($product->is_cover)){
                $fileName = $product->is_cover !== 'default.jpg' ? $product->is_cover : '' ;
                $filePath ='uploads/is_cover_image/'. $fileName;

                Utility::changeStorageLimit(\Auth::user()->creatorId(),$filePath);
            }
            if(isset($product->attachment) && !empty($product->attachment)){
                $fileName = $product->attachment !== 'default.jpg' ? $product->attachment : '' ;
                $filePath ='uploads/is_cover_image/'. $fileName;

                Utility::changeStorageLimit(\Auth::user()->creatorId(),$filePath);
            }
            if(isset($product->downloadable_prodcut) && !empty($product->downloadable_prodcut)){
                $fileName = $product->downloadable_prodcut !== 'default.jpg' ? $product->downloadable_prodcut : '' ;
                $filePath ='uploads/downloadable_prodcut/'. $fileName;
                Utility::changeStorageLimit(\Auth::user()->creatorId(),$filePath);
            }
            foreach ($Product_images as $pro) {
                if(isset($pro->product_images)){
                    $fileName = $pro->product_images !== 'default.jpg' ? $pro->product_images : '' ;
                    $filePath ='uploads/product_image/'. $fileName;

                    Utility::changeStorageLimit(\Auth::user()->creatorId(),$filePath);
                }
            }

            foreach ($Product_images as $pro) {
                $pro_img->fileDelete($pro->id);
            }
            ProductVariantOption::where('product_id', $product->id)->forceDelete();
            $product->delete();

            return redirect()->back()->with('success', __('Product successfully deleted.'));
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function grid()
    {
        $user = \Auth::user();
        $store_id = Store::where('id', $user->current_store)->first();
        $products = Product::where('store_id', $store_id->id)->orderBy('id', 'DESC')->get();

        return view('product.grid', compact('products'));
    }

    public function fileDelete($id)
    {
        $product_img_id = Product_images::find($id);

        if (!empty($product_img_id->product_images)) {
            $fileName = $product_img_id->product_images !== 'default.jpg' ? $product_img_id->product_images : '' ;
            $filePath ='uploads/product_image/'. $fileName;

            Utility::changeStorageLimit(\Auth::user()->creatorId(),$filePath);
            Product_images::where('id', '=', $id)->delete();

            return response()->json(
                [
                    'success' => __('Record deleted successfully!'),
                    'id' => $id,
                ]
            );
        }

        return response()->json(
            [
                'success' => __('Record deleted successfully!'),
                'id' => $id,
            ]
        );
    }

    public function productVariantsCreate(Request $request)
    {
        if(\Auth::user()->can('Create Variants')){
            return view('product.variants.create')->render();
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function productVariantsEdit(Request $request, $product_id)
    {
        if(\Auth::user()->can('Edit Variants')){
            $product = Product::getProductById($product_id);
            $productVariantOption = json_decode($product->variants_json, true);
            if (empty($productVariantOption)) {
                return view('product.variants.create')->render();
            } else {
                return view('product.variants.edit', compact('product', 'productVariantOption', 'product_id'))->render();
            }
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function getProductVariantsPossibilities(Request $request, $product_id = 0)
    {
        $variant_edit = $request->variant_edit;
        if (!empty($variant_edit) && $variant_edit == 'edit') {
            $variant_option123 = json_decode($request->hiddenVariantOptions, true);
            foreach ($variant_option123 as $key => $value) {
                $new_key = array_search($value['variant_name'], array_column($request->variant_edt, 'variant_name'));
                if (!empty($request->variant_edt[$new_key]['variant_options'])) {
                    $new_val = explode('|', $request->variant_edt[$new_key]['variant_options']);
                    $variant_option123[$key]['variant_options'] = array_merge($variant_option123[$key]['variant_options'], $new_val);
                }
            }
            $request['hiddenVariantOptions'] = json_encode($variant_option123);
        }
        $variant_name = $request->variant_name;
        $variant_options = $request->variant_options;
        $hiddenVariantOptions = $request->hiddenVariantOptions;
        $hiddenVariantOptions = json_decode($hiddenVariantOptions, true);
        $variants = [
            [
                'variant_name' => $variant_name,
                'variant_options' => explode('|', $variant_options),
            ],
        ];
        if (empty($variant_edit) && $variant_edit != 'edit') {
            $hiddenVariantOptions = array_merge($hiddenVariantOptions, $variants);
        }
        $hiddenVariantOptions = array_map("unserialize", array_unique(array_map("serialize", $hiddenVariantOptions)));
        $optionArray = $variantArray = [];

        foreach ($hiddenVariantOptions as $variant) {
            $variantArray[] = $variant['variant_name'];
            $optionArray[] = $variant['variant_options'];
        }
        $deleted_variants = ProductVariantOption::onlyTrashed()->where('product_id', $product_id)->get();
        $possibilities = Product::possibleVariants($optionArray);
        foreach ($deleted_variants as $key => $dv) {
            $deleted_variant = $dv->name;
            if (in_array($deleted_variant, $possibilities)) {
                $indexKay = array_search($deleted_variant, $possibilities, true);
                unset($possibilities[$indexKay]);
            }
        }

        $variantArray = array_unique($variantArray);
        if (!empty($variant_edit) && $variant_edit == 'edit') {
            $varitantHTML = view('product.variants.edit_list', compact('possibilities', 'variantArray', 'product_id'))->render();
        } else {
            $varitantHTML = view('product.variants.list', compact('possibilities', 'variantArray'))->render();
        }

        $result = [
            'status' => false,
            'hiddenVariantOptions' => json_encode($hiddenVariantOptions),
            'varitantHTML' => $varitantHTML,
        ];

        return response()->json($result);
    }

    public function getProductsVariantQuantity(Request $request)
    {

        $status = false;
        $quantity = $variant_id = 0;
        $quantityHTML = '<strong>' . __('Please select variants to get available quantity.') . '</strong>';
        $priceHTML = '';
        $product = Product::find($request->product_id);
        $price = \App\Models\Utility::priceFormat(0);
        //dd($request->variants);
        $status = false;

        if ($product && $request->variants != '') {
            $variant = ProductVariantOption::where('product_id', $product['id'])->where('name', $request->variants)->first();

            if ($variant) {
                $status = true;
                $quantity = $variant->quantity - (isset($cart[$variant->id]['quantity']) ? $cart[$variant->id]['quantity'] : 0);
                $price = \App\Models\Utility::priceFormat($variant->price);
                $variant_id = $variant->id;
            }
        }

        return response()->json(
            [
                'status' => $status,
                'price' => $price,
                'quantity' => $quantity,
                'variant_id' => $variant_id
            ]
        );

    }

    public function VariantDelete(Request $request, $id, $product_id)
    {
        if(\Auth::user()->can('Delete Variants')){
            $product = Product::find($product_id);
            if (!empty($product->variants_json) && ProductVariantOption::find($id)->exists()) {
                $var_json = json_decode($product->variants_json, true);

                $i = 0;
                foreach ($var_json[0] as $key => $value) {
                    $var_ops = explode(' : ', ProductVariantOption::find($id)->name);
                    $count = ProductVariantOption::where('product_id', $product->id)->where('name', 'LIKE', '%' . $var_ops[0] . '%')->count();
                    if ($count == 1 && $i == 0) {
                        $unsetIndex = array_search($var_ops[0], $var_json[0]['variant_options'], true);
                        unset($var_json[0]['variant_options'][$unsetIndex]);
                    }
                    $i++;
                }
                $variants = ProductVariantOption::where('product_id',$product->id)->count();
                if($variants == 1){
                    $product->variants_json = '{}';
                    $product->update();
                }else{
                    $product->variants_json = json_encode($var_json);
                    $product->update();
                }

            }
            ProductVariantOption::where('id',$id)->forceDelete();
            return redirect()->back()->with('success', __('Variant successfully deleted.'));
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function fileExport()
    {
        $name = 'product_' . date('Y-m-d i:h:s');
        $data = Excel::download(new ProductExport(), $name . '.xlsx');

        return $data;
    }

    public function fileImportExport()
    {
        if(\Auth::user()->can('Create Products')){
            return view('product.import');
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function fileImport(Request $request)
    {
        if(\Auth::user()->can('Create Products')){
            $rules = [
                'file' => 'required|mimes:csv,txt,xlsx',
            ];
            $user = \Auth::user();
            $store_id = Store::where('id', $user->current_store)->first();

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $products = (new ProductImport())->toArray(request()->file('file'))[0];

            $totalproduct = count($products) - 1;

            $errorArray = [];
            for ($i = 1; $i <= count($products) - 1; $i++) {
                $product = $products[$i];
                $productBySku = Product::where('SKU', $product[2])->where('store_id',$store_id->id)->first();

                if (!empty($productByname)) {
                    $productData = $productBySku;
                } else {
                    $productData = new Product();
                }

                $productData->name = $product[0];
                $productData->description = $product[1];
                $productData->SKU = $product[2];
                $productData->price = $product[3];
                $productData->quantity = $product[4];
                $productData->product_display = 'on';
                $productData->is_active = 1;
                $productData->store_id = $store_id->id;
                $productData->created_by = \Auth::user()->creatorId();

                if (empty($productData->name) ||
                    empty($productData->price) ||
                    empty($productData->quantity))
                {
                    $errorArray[] = [
                        'name'       => $productData->name,
                        'price'      => $productData->price,
                        'quantity'   => $productData->quantity,
                    ];
                } else {
                    $productData->save();
                }
            }

            $errorRecord = [];
            if (empty($errorArray)) {
                $data['status'] = 'success';
                $data['msg'] = __('Record successfully imported');
            } else {
                $data['status'] = 'error';
                $data['msg'] = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalproduct . ' ' . 'record');

                foreach ($errorArray as $errorData) {

                    $errorRecord[] = implode(',', $errorData);
                }

                \Session::put('errorArray', $errorRecord);
            }
            return redirect()->back()->with($data['status'], $data['msg']);
        }
        else{
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
    public function searchProducts(Request $request)
    {
        $lastsegment = $request->session_key;
        if ($request->ajax() && isset($lastsegment) && !empty($lastsegment)) {
            $output = "";
            if ($request->cat_id !== '' && $request->search == '') {
                if($request->cat_id == '0'){//->where('enable_product_variant','off')
                    $products = Product::where('store_id',$request->store_id)->get();

                }else{

                    $products = Product::where('product_categorie', $request->cat_id)->where('store_id',$request->store_id)->get();
                }

            } else {
                if($request->cat_id == '0'){
                    $products = Product::where('name', 'LIKE', "%{$request->search}%")->where('store_id',$request->store_id)->get();

                }else{
                    $products = Product::where('name', 'LIKE', "%{$request->search}%")->where('store_id',$request->store_id)->Where('product_categorie', $request->cat_id)->get();

                }
            }
            if (count($products)>0)
            {
                foreach ($products as $key => $product)
                {
                    if($product->enable_product_variant == 'off'){
                        $quantity = $product->quantity;
                        if(!empty($product->is_cover)){
                            // $image_url =('uploads/is_cover_image').'/'.$product->is_cover;
                            $image_url =\App\Models\Utility::get_file('uploads/is_cover_image').'/'.$product->is_cover;
                        }else{
                            // $image_url =('uploads/is_cover_image').'/default.jpg';
                            $image_url =\App\Models\Utility::get_file('uploads/is_cover_image').'/default.jpg';
                        }
                        if ($request->session_key == 'purchases')
                        {
                            $productprice = $product->price != 0 ? $product->price : 0;
                        }
                        else if ($request->session_key == 'pos')
                        {
                            $productprice = $product->price != 0 ? $product->price : 0;
                        }
                        else
                        {
                            $productprice = $product->price != 0 ? $product->price : $product->price;
                        }


                        $output .= '

                                <div class="col-xxl-4 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-12">
                                    <div class="tab-pane fade show active toacart w-100" data-url="' . url('addToCart/' . $product->id . '/' . $lastsegment) .'">
                                        <div class="position-relative border border-primary card mb-0">
                                            <img alt="Image placeholder" src="' . $image_url/*asset(Storage::url($image_url))*/ . '" class="card-image avatar hover-shadow-lg" style=" height: 6rem; width: 100%;">
                                            <div class="p-0 custom-card-body card-body d-flex ">
                                                <div class="card-body my-2 p-2 text-center card-bottom-content">
                                                    <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>
                                                    <small class="text-primary fs-6 fw-bold">' . Utility::priceFormat($productprice) . '</small>

                                                    <small class="top-badge badge badge-danger mb-0">'. $quantity. ' '. __("QTY") .'</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        ';
                    }else{
                        if(!empty($product->is_cover)){
                            $image_url =\App\Models\Utility::get_file('uploads/is_cover_image').'/'.$product->is_cover;
                        }else{
                            $image_url =\App\Models\Utility::get_file('uploads/is_cover_image').'/default.jpg';
                        }

                        $output .= '

                                <div class="col-xxl-4 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-12">
                                    <div class="tab-pane fade show active w-100" data-url="' . url('pos-productVariant/' . $product->id . '/' . $lastsegment) .'" data-ajax-popup="true" data-size="lg" data-align="centered" data-title="' . __("Product Variant") . '">
                                        <div class="position-relative border border-primary card mb-0">
                                            <img alt="Image placeholder" src="' . $image_url/*asset(Storage::url($image_url))*/ . '" class="card-image avatar hover-shadow-lg" style=" height: 6rem; width: 100%;">
                                            <div class="p-0 custom-card-body card-body d-flex ">
                                                <div class="card-body my-2 p-2 text-center card-bottom-content">
                                                    <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>
                                                    <small class="text-primary fs-6 fw-bold">'. __("In Variant") .'</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        ';
                    }

                }

                return Response($output);
            } else {
                $output='<div class="card card-body col-12 text-center">
                    <h5>'.__("No Product Available").'</h5>
                    </div>';
                return Response($output);
            }
        }
    }

    public function productVariant(Request $request, $id, $session_key)
    {
        $products = Product::where('id', $id)->first();
        $variant_name = json_decode($products->variants_json);
        $product_variant_names = $variant_name;

        return view('pos.product_variant', compact('products', 'product_variant_names', 'session_key'));
    }
    public function addToCartVariant(Request $request, $id,$session_key,$variant_id = 0)
    {

        $variant = ProductVariantOption::find($variant_id);
        $product = Product::find($id);
        if ($product) {
            $productquantity = $product->quantity;
        }
        if ($variant_id > 0) {
            $quantity = $variant->quantity;
        }else{
            $quantity = 0;
        }
        if ($session_key == 'pos' && $quantity <= 0) {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ],
                404
            );
        }

        $productname = $product->name;

        if  ($session_key == 'pos') {

            $productprice = $product->price != 0 ? $product->price : 0;
        }

        $originalquantity = (int)$productquantity;

        $taxes=Utility::tax($product->product_tax);
        $totalTaxRate=Utility::totalTaxRate($product->product_tax);
        $product_tax='';
        $producttax = [];
        $itemTaxes = [];
        $totalTax = 0;
        $product_tax_id=[];
        if (!empty($taxes)) {
            foreach ($taxes as $tax) {

                if (!empty($tax)) {
                    $producttax = Utility::taxRate($tax->rate, $product->price, 1);
                    $product_tax.= !empty($tax)?"<span class='badge bg-primary'>". $tax->name.' ('.$tax->rate.'%)'."</span><br>":'';
                    $totalTax += $producttax;
                    $itemTax['tax_name'] = $tax->name;
                    $itemTax['tax'] = $tax->rate;
                    $itemTaxes[] = $itemTax;
                    $subtotal = $productprice + $totalTax;
                }
                else{
                    $subtotal = $productprice;
                    $product_tax = '-';
                }

            }
        }

        $cart            = session()->get($session_key);
        if(!empty($product->is_cover)){
            // $image_url =('uploads/is_cover_image').'/'.$product->is_cover;
            $image_url =\App\Models\Utility::get_file('uploads/is_cover_image').'/'.$product->is_cover;
        }else{
            // $image_url =('uploads/is_cover_image').'/default.jpg';
            $image_url =\App\Models\Utility::get_file('uploads/is_cover_image').'/default.jpg';
        }

        if ($variant_id > 0) {
            $variant_itemTaxes = [];
            $variant_name = $variant->name;
            $variant_price = $variant->price;
            $originalvariantquantity = (int) $variant->quantity;
            //variant count tax
            $variant_taxes = Utility::tax($product->product_tax);
            $variant_producttax = 0;

            if (!empty($variant_taxes)) {
                foreach ($variant_taxes as $variant_tax) {
                    if (!empty($variant_tax)) {
                        $variant_producttax = Utility::taxRate($variant_tax->rate, $variant_price, 1);
                        $itemTax['tax_name'] = $variant_tax->name;
                        $itemTax['tax'] = $variant_tax->rate;
                        $variant_itemTaxes[] = $itemTax;
                    }
                }
            }
            // $variant_subtotal = Utility::priceFormat($variant_price * $variant->quantity);
            $variant_subtotal = $variant_price + $variant_producttax;
        }

        $time = time();

        $model_delete_id = 'delete-form-' . $time;

        $carthtml = '';

        $carthtml .= '<tr data-product-id="' . $time . '" id="product-variant-id-' . $variant_id . '">
                        <td class="cart-images">
                            <img alt="Image placeholder" src="' . $image_url/*asset(Storage::url($image_url))*/ . '" class="card-image avatar border border-2 border-primary rounded shadow hover-shadow-lg">
                        </td>

                        <td class="name">' . $productname . '-' . $variant_name . '</td>

                        <td class="">
                                <span class="quantity buttons_added">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" max="" name="quantity" title="' . __('Quantity') . '" class="input-number" size="4" data-url="' . url('update-cart/') . '" data-id="' . $time . '">
                                        <input type="button" value="+" class="plus">
                                </span>
                        </td>


                        <td class="tax">' . $product_tax . '</td>

                        <td class="price">' .  Utility::priceFormat($variant_price) . '</td>

                        <td class="subtotal">' . Utility::priceFormat($variant_subtotal) . '</td>

                        <td class="">
                                <a href="#" class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" data-confirm="' . __("Are You Sure?") . '" data-text="' . __("This action can not be undone. Do you want to continue?") . '" data-confirm-yes=' . $model_delete_id . ' title="' . __('Delete') . '}" data-id="' . $time . '" title="' . __('Delete') . '"   >
                                <span class=""><i class="ti ti-trash"></i></span>
                                </a>
                                <form method="post" action="' . url('remove-from-cart') . '"  accept-charset="UTF-8" id="' . $model_delete_id . '">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="' . csrf_token() . '">
                                    <input type="hidden" name="session_key" value="' . $session_key . '">
                                    <input type="hidden" name="id" value="' . $time . '">
                                </form>

                        </td>
                    </td>';

        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $time => [
                    "product_id" => $product->id,
                    "product_name" => $productname,
                    "image" => $product->is_cover,
                    "quantity" => 1,
                    "price" => $productprice,
                    "id" => $id,
                    "downloadable_prodcut" => $product->downloadable_prodcut,
                    "tax" => $variant_itemTaxes,
                    "subtotal" => $subtotal,
                    "originalquantity" => $originalquantity,
                    "variant_name" => $variant_name,
                    "variant_price" => $variant_price,
                    "variant_qty" => $variant->quantity,
                    "variant_subtotal" => $variant_subtotal,
                    "originalvariantquantity" => $originalvariantquantity,
                    'variant_id' => $variant_id,
                ],
            ];

            if ($originalvariantquantity < $cart[$time]['quantity'] && $session_key == 'pos') {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$time],
                    'carthtml' => $carthtml,
                ]
            );
        }

        // if cart not empty then check if this product exist then increment quantity
        if ($variant_id > 0) {
        $key = false;
        foreach ($cart as $k => $value) {
            if ($variant_id == $value['variant_id']) {
                $key = $k;
            }
        }

        if ($key !== false && isset($cart[$key]['variant_id']) && $cart[$key]['variant_id'] != 0) {
            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $cart[$key]['quantity'] + 1;
                $cart[$key]['variant_subtotal'] = $cart[$key]['variant_price'] * $cart[$key]['quantity'];

                $variant_producttax1 = 0;

                if (!empty($variant_taxes)) {
                    foreach ($variant_taxes as $variant_tax1) {
                        if (!empty($variant_tax1)) {
                            $variant_producttax1 = Utility::taxRate($variant_tax1->rate, $variant_price, $cart[$key]['quantity']);
                        }
                    }
                }
                $cart[$key]['variant_subtotal'] = $cart[$key]['variant_subtotal'] + $variant_producttax1;

                if ($originalvariantquantity < $cart[$key]['quantity']) {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ]
                    );
                }

                session()->put($session_key, $cart);

                return response()->json(
                    [
                        'code' => 200,
                        'status' => 'Success',
                        'success' => $productname . __('added to cart successfully!'),
                        'product' => $cart[$key],
                        'carttotal' => $cart,
                    ]
                );
            }
        }
    }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$time] = [
            "product_id" => $product->id,
            "product_name" => $productname,
            "image" => $product->is_cover,
            "quantity" => 1,
            "price" => $productprice,
            "id" => $id,
            "downloadable_prodcut" => $product->downloadable_prodcut,
            "tax" => $variant_itemTaxes,
            "subtotal" => $subtotal,
            "originalquantity" => $originalquantity,
            "variant_name" => $variant->name,
            "variant_price" => $variant->price,
            "variant_qty" => $variant->quantity,
            "variant_subtotal" => $variant_subtotal,
            "originalvariantquantity" => $originalvariantquantity,
            'variant_id' => $variant_id,
        ];

        if ($originalvariantquantity < $cart[$time]['quantity'] && $session_key == 'pos') {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ],
                404
            );
        }

        session()->put($session_key, $cart);
        return response()->json(
            [
                'code' => 200,
                'status' => 'Success',
                'success' => $productname . __(' added to cart successfully!'),
                'product' => $cart[$time],
                'carthtml' => $carthtml,
                'carttotal' => $cart,
            ]
        );
    }

    public function addToCart(Request $request, $id,$session_key)
    {


        $product = Product::find($id);
        if ($product) {
            $productquantity = $product->quantity;
        }
        if (!$product || ($session_key == 'pos' && $productquantity == 0)) {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ],
                404
            );
        }

        $productname = $product->name;

        if  ($session_key == 'pos') {

            $productprice = $product->price != 0 ? $product->price : 0;
        }

        $originalquantity = (int)$productquantity;

        $taxes=Utility::tax($product->product_tax);
        $totalTaxRate=Utility::totalTaxRate($product->product_tax);
        $product_tax='';
        $producttax = [];
        $itemTaxes = [];
        $totalTax = 0;
        $product_tax_id=[];
        if (!empty($taxes)) {
            foreach ($taxes as $tax) {

                if (!empty($tax)) {
                    $producttax = Utility::taxRate($tax->rate, $product->price, 1);
                    $product_tax.= !empty($tax)?"<span class='badge bg-primary'>". $tax->name.' ('.$tax->rate.'%)'."</span><br>":'';
                    $totalTax += $producttax;
                    $itemTax['tax_name'] = $tax->name;
                    $itemTax['tax'] = $tax->rate;
                    $itemTaxes[] = $itemTax;
                    $subtotal = $productprice + $totalTax;
                }
                else{
                    $subtotal = $productprice;
                    $product_tax = '-';
                }

            }
        }

        $cart            = session()->get($session_key);
        if(!empty($product->is_cover)){
            // $image_url =('uploads/is_cover_image').'/'.$product->is_cover;
            $image_url =\App\Models\Utility::get_file('uploads/is_cover_image').'/'.$product->is_cover;
        }else{
            // $image_url =('uploads/is_cover_image').'/default.jpg';
            $image_url =\App\Models\Utility::get_file('uploads/is_cover_image').'/default.jpg';
        }

        $time = time();

        $model_delete_id = 'delete-form-' . $time;

        $carthtml = '';

        $carthtml .= '<tr data-product-id="' . $time . '" id="product-id-' . $id . '">
                        <td class="cart-images">
                            <img alt="Image placeholder" src="' . $image_url/*asset(Storage::url($image_url))*/ . '" class="card-image avatar shadow border border-2 border-primary rounded hover-shadow-lg">
                        </td>

                        <td class="name">' . $productname . '</td>

                        <td class="">
                                <span class="quantity buttons_added">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" max="" name="quantity" title="' . __('Quantity') . '" class="input-number" size="4" data-url="' . url('update-cart/') . '" data-id="' . $time . '">
                                        <input type="button" value="+" class="plus">
                                </span>
                        </td>


                        <td class="tax">' . $product_tax . '</td>

                        <td class="price">' .  Utility::priceFormat($productprice) . '</td>

                        <td class="subtotal">' . Utility::priceFormat($subtotal) . '</td>

                        <td class="">
                                <a href="#" class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" data-confirm="' . __("Are You Sure?") . '" data-text="' . __("This action can not be undone. Do you want to continue?") . '" data-confirm-yes=' . $model_delete_id . ' title="' . __('Delete') . '}" data-id="' . $time . '" title="' . __('Delete') . '"   >
                                <span class=""><i class="ti ti-trash"></i></span>
                                </a>
                                <form method="post" action="' . url('remove-from-cart') . '"  accept-charset="UTF-8" id="' . $model_delete_id . '">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="' . csrf_token() . '">
                                    <input type="hidden" name="session_key" value="' . $session_key . '">
                                    <input type="hidden" name="id" value="' . $time . '">
                                </form>

                        </td>
                    </td>';

        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $time => [
                    "product_id" => $product->id,
                    "product_name" => $productname,
                    "image" => $product->is_cover,
                    "quantity" => 1,
                    "price" => $productprice,
                    "id" => $id,
                    "downloadable_prodcut" => $product->downloadable_prodcut,
                    "tax" => $itemTaxes,
                    "subtotal" => $subtotal,
                    "originalquantity" => $originalquantity,
                    'variant_id' => 0,
                ],
            ];


            if ($originalquantity < $cart[$time]['quantity'] && $session_key == 'pos') {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$time],
                    'carthtml' => $carthtml,
                ]
            );
        }

        // if cart not empty then check if this product exist then increment quantity
        $key = false;
        foreach ($cart as $k => $value) {
            if ($product->id == $value['product_id']) {
                $key = $k;
            }
        }

        if ($key !== false) {
            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $cart[$key]['quantity'] + 1;
                $cart[$key]['subtotal'] = $cart[$key]['price'] * $cart[$key]['quantity'];
                $tax = 0;
                if(!empty($cart[$key]["tax"])){
                    foreach($cart[$key]["tax"] as $t){
                        $beforeTax = Utility::taxRate($t['tax'], $cart[$key]['price'], $cart[$key]["quantity"]);
                        $tax += $beforeTax;
                    }
                }
                else{
                    $tax      = 0;
                }
                $cart[$key]["subtotal"]         = $cart[$key]['subtotal'] + $tax;

                if ($originalquantity < $cart[$key]['quantity'] && $session_key == 'pos') {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ]
                    );
                }

                session()->put($session_key, $cart);
                return response()->json(
                    [
                        'code' => 200,
                        'status' => 'Success',
                        'success' => $productname . __('added to cart successfully!'),
                        'product' => $cart[$key],
                        'carttotal' => $cart,
                    ]
                );
            }
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$time] = [
            "product_id" => $product->id,
            "product_name" => $productname,
            "image" => $product->is_cover,
            "quantity" => 1,
            "price" => $productprice,
            "id" => $id,
            "downloadable_prodcut" => $product->downloadable_prodcut,
            "tax" => $itemTaxes,
            "subtotal" => $subtotal,
            "originalquantity" => $originalquantity,
            'variant_id' => 0,
        ];

        if ($originalquantity < $cart[$time]['quantity'] && $session_key == 'pos') {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ],
                404
            );
        }

        session()->put($session_key, $cart);
        return response()->json(
            [
                'code' => 200,
                'status' => 'Success',
                'success' => $productname . __(' added to cart successfully!'),
                'product' => $cart[$time],
                'carthtml' => $carthtml,
                'carttotal' => $cart,
            ]
        );
    }
    public function updateCart(Request $request)
    {
        $id          = $request->id;
        $quantity    = $request->quantity;
        $discount    = $request->discount;
        $session_key = $request->session_key;

        if ($request->ajax() && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);

            if (isset($cart[$id]) && $quantity == 0) {
                unset($cart[$id]);
            }

            if($cart[$id]['variant_id'] == 0){
                if ($quantity) {

                    $cart[$id]["quantity"] = $quantity;
                    $taxes            = !empty($cart[$id]["tax"]) ? $cart[$id]["tax"]:'';
                    $producttax = 0;
                    if (!empty($taxes)) {
                        foreach ($taxes as $tax) {
                            if (!empty($tax)) {
                                $totalTax = Utility::taxRate($tax['tax'], $cart[$id]['price'], $quantity);
                                $producttax += $totalTax;
                                $itemTax['tax_name'] = $tax['tax_name'];
                                $itemTax['tax'] = $tax['tax'];
                                $itemTaxes[] = $itemTax;
                            }
                        }
                        $productprice          = $cart[$id]["price"] *  (float)$quantity;
                        $subtotal = $productprice +  $producttax;
                    }
                    else{

                        $productprice          = $cart[$id]["price"];
                        $subtotal = $productprice  *  (float)$quantity ;
                    }


                    $cart[$id]["subtotal"] = $subtotal ;
                }

                if ( isset($cart[$id]) && isset($cart[$id]["originalquantity"]) < $cart[$id]['quantity'] && $session_key == 'pos') {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ],
                        404
                    );
                }
            }else{
                if ($quantity) {

                    $cart[$id]["quantity"] = $quantity;
                    $taxes            = !empty($cart[$id]["tax"]) ? $cart[$id]["tax"]:'';
                    $producttax = 0;
                    if (!empty($taxes)) {
                        foreach ($taxes as $tax) {
                            if (!empty($tax)) {
                                $totalTax = Utility::taxRate($tax['tax'], $cart[$id]['variant_price'], $quantity);
                                $producttax += $totalTax;
                                $itemTax['tax_name'] = $tax['tax_name'];
                                $itemTax['tax'] = $tax['tax'];
                                $itemTaxes[] = $itemTax;
                            }
                        }
                        $productprice          = $cart[$id]["variant_price"] *  (float)$quantity;
                        $subtotal = $productprice +  $producttax;
                    }
                    else{

                        $productprice          = $cart[$id]["variant_price"];
                        $subtotal = $productprice  *  (float)$quantity ;
                    }


                    $cart[$id]["variant_subtotal"] = $subtotal ;
                }

                if ( isset($cart[$id]) && isset($cart[$id]["originalvariantquantity"]) < $cart[$id]['quantity'] && $session_key == 'pos') {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ],
                        404
                    );
                }
            }

            $subtotal1 = 0;
            foreach($cart as $id => $value){
                if($value['variant_id'] == 0){
                    $subtotal1 += $value['subtotal'];
                }else{
                    $subtotal1 += $value['variant_subtotal'];
                }
            }
            $subtotal = $subtotal1;
            $discount = $request->discount;
            $total = $subtotal - (float)$discount;
            $totalDiscount = Utility::priceFormat($total);
            $discount = $totalDiscount;

            session()->put($session_key, $cart);
            return response()->json(
                [
                    'code' => 200,
                    'success' => __('Cart updated successfully!'),
                    'product' => $cart,
                    'discount' => $discount,
                ]
            );
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This Product is not found!'),
                ],
                404
            );
        }
    }
    public function removeFromCart(Request $request)
    {
        $id          = $request->id;
        $session_key = $request->session_key;
        if (isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put($session_key, $cart);
            }

            return redirect()->back()->with('error', __('Product removed from cart!'));
        } else {
            return redirect()->back()->with('error', __('This Product is not found!'));
        }
    }
    public function emptyCart(Request $request)
    {
        $session_key = $request->session_key;
        if (isset($session_key) && !empty($session_key))
        {
            $cart = session()->get($session_key);
            if (isset($cart) && count($cart) > 0)
            {
                session()->forget($session_key);
            }

            return redirect()->back()->with('error', __('Cart is empty!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Cart cannot be empty!.'));

        }
    }
}
