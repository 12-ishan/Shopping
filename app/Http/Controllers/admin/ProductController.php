<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\Attribute;
use App\Models\Admin\AttributeOptions;
use App\Models\Admin\ProductVariationAttribute;
use App\Models\Admin\ProductAttribute;
use App\Models\Admin\ProductVariation;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;


class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->accountId = Auth::user()->accountId;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data["products"] = Product::orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Manage Product';
        $data["activeMenu"] = 'Product';
        return view('admin.product.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["productCategory"] = ProductCategory::where('status',1)->orderBy('sortOrder')->get();
        // $data["editStatus"] = 0;
       // $data['product'] = null;
       // $data["editStatus"] = 0;
        $data['attributes'] = Attribute::where('status', 1)->orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Add Product';
        $data["activeMenu"] = 'Product';
        return view('admin.product.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // echo '<pre>';
        // print_r($request->all());
        // die();
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required'
        ]);
    
        if (session()->has('TEMPPRODUCTID') && $request->input('type') == 1) {
            $checkProduct = session('TEMPPRODUCTID');
            $product = Product::find($checkProduct);

        } else {   
            $product = new Product();
        }
    
        if ($request->hasFile('image')) { 

            $mediaId = imageUpload($request->image, $product->imageId, $this->userId, "uploads/productImage/"); 
            $product->imageId = $mediaId;
         }
    
        $product->category_id = $request->input('categoryId');
        $product->name = $request->input('name');
        $product->slug = Str::slug($request->input('name'));
        $product->price = $request->input('price');
        $product->type = $request->input('type');
        $product->description = $request->input('description');
        $product->status = 1;
        $product->sortOrder = 1;
        $product->increment('sortOrder');
        $product->save();

    
        if ($request->input('type') == 1) {
            if ($request->has('variation')) {
                foreach ($request->variation as $variationData) {
                
                    $variant = new ProductVariation();
                    $variant->product_id = $product->id;
                    $variant->sku = $variationData['sku'];
                    $variant->price = $variationData['price'];
                    $variant->stock = $variationData['stock'];
                    $variant->status = 1;
                    $variant->sort_order = 1;
                    $variant->increment('sort_order');
                    $variant->save();
    
                    foreach ($variationData['attributeOptions'] as $attributeValueId) {
                        $variationAttribute = new ProductVariationAttribute();
                        $variationAttribute->product_variation_id = $variant->id;
                        $variationAttribute->attributes_options_id = $attributeValueId;
                        $variationAttribute->status = 1;
                        $variationAttribute->sort_order = 1;
                        $variationAttribute->increment('sort_order');
                        $variationAttribute->save();
                    }
                }
            }
        }
    
        return redirect()->route('product.index')->with('message', 'Product Added/Updated Successfully');
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $data = array();
    
        $data['product'] = Product::with([
            'productAttributes.attribute.options',
            'productVariation.attributes.attributeOption'
        ])->find($id);
       // $data['index'] = $index;
        // echo '<pre>';
        // print_r($data['product']);
        // die();
     
        $data['rowcount'] = ProductVariation::where('product_id', $id)->count();
        // echo '<pre>';
        // print_r($data['rowcount']);
        // die();
     
        $data["productCategory"] = ProductCategory::orderBy('sortOrder')->get();
        $data["attributes"] = Attribute::orderBy('sortOrder')->get();
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Product';
        $data["activeMenu"] = 'Product';
        return view('admin.product.create')->with($data);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required',
        ]);
    
        $product = Product::find($id);
    
        if ($request->hasFile('image')) {
            $mediaId = imageUpload($request->image, $product->imageId, $this->userId, "uploads/productImage/");
            $product->imageId = $mediaId;
        }
    
        $product->category_id = $request->input('categoryId');
        $product->name = $request->input('name');
        $product->slug = Str::slug($request->input('name'));
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->status = 1;
        $product->save();
    
        if ($request->input('type') == 1) {
            $requestVariations = $request->input('variation');
            
            $requestedSkus = array_map(function($variation) {
                return $variation['sku'];
            }, $requestVariations);
    
            $existingVariations = ProductVariation::where('product_id', $id)->get();
            $existingSkus = $existingVariations->pluck('sku')->toArray();
    
            $newSkus = array_diff($requestedSkus, $existingSkus);
            $removedSkus = array_diff($existingSkus, $requestedSkus);

            foreach ($requestVariations as $variation) {
                $variationData = [
                    'sku' => $variation['sku'],
                    'price' => $variation['price'],
                    'stock' => $variation['stock'],
                    'status' => 1, 
                    'sort_order' => ProductVariation::where('product_id', $id)->max('sort_order') + 1, 
                ];
    
                $existingVariation = $existingVariations->firstWhere('sku', $variation['sku']);
    
                if ($existingVariation) {
                  
                    $existingVariation->update($variationData);
                    
                    if (isset($variation['attributeOptions'])) {
                       
                        $existingVariation->attributes()->delete();
                     
                        foreach ($variation['attributeOptions'] as $attribute) {
                            ProductVariationAttribute::create([
                                'product_variation_id' => $existingVariation->id,
                                'attributes_options_id' => $attribute,
                                'status' => 1, 
                                'sort_order' => ProductVariationAttribute::where('product_variation_id', $existingVariation->id)->max('sort_order') + 1, 
                            ]);
                        }
                    }
                } else {
                    
                    $variationData['product_id'] = $id;
                    $newVariation = ProductVariation::create($variationData);
    
                    if (isset($variation['attributeOptions'])) {
                        foreach ($variation['attributeOptions'] as $attribute) {
                            ProductVariationAttribute::create([
                                'product_variation_id' => $newVariation->id,
                                'attributes_options_id' => $attribute,
                                'status' => 1, 
                                'sort_order' => 1, 
                            ]);
                        }
                    }
                }
            }
    
            if (!empty($removedSkus)) {
                $variationsToRemove = ProductVariation::where('product_id', $id)
                    ->whereIn('sku', $removedSkus)
                    ->get();
                    
                foreach ($variationsToRemove as $variationToRemove) {
                    $variationToRemove->attributes()->delete(); 
                    $variationToRemove->delete();
                }
            }
        }
    
        return redirect()->route('product.index')->with('message', 'Product Updated Successfully');
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        $product->delete($id);

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => $request->id
        ]);
    }

    /**
     * Remove all selected resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {

        $record = $request->input('deleterecords');

        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $product = Product::find($id);
                $product->delete();
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => ''
        ]);
    }

    /**
     * Update SortOrder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSortorder(Request $request)
    {
        $data = $request->records;
        $decoded_data = json_decode($data);
        $result = 0;

        if (is_array($decoded_data)) {
            foreach ($decoded_data as $values) {

                $id = $values->id;
                $product = Product::find($id);
                $product->sortOrder = $values->position;
                $result = $product->save();
            }
        }

        if ($result) {
            $response = array('status' => 1, 'message' => 'Sort order updated', 'response' => $data);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => $data);
        }

        return response()->json($response);
    }

    /**
     * Update Status resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;

        $product = Product::find($id);
        $product->status = $status;
        $result = $product->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

//     public function getAttributeOptions(Request $request)
// {
//     $attributes = $request->input('attributes');
    
//     // Assuming you fetch attribute options based on the attribute IDs
//     $attributeOptions = []; 

//     foreach ($attributes as $attributeId) {
//         $options = AttributeOptions::find($attributeId)->options; 
//         $attributeOptions[$attributeId] = $options;
//     }

//     return response()->json([
//         'success' => true,
//         'attributeOptions' => $attributeOptions
//     ]);
// }

    // public function getAttributeOptions(Request $request)
    // {
    // //     $attributes = $request->input('attributes', []);
    // //    $attributeOptions = [];

    //     $page = $request->input('editStatus'); //1/0
    //     $productId = $request->input('productId');
       
    //     if(empty($productId) && $page == 0){
    //         $product = new Product();
    //         $product->name = 'temp-product';
    //         $product->status = 0;
    //         $product->sortOrder = 1;
    //         $product->increment('sortOrder');
    //         $product->save();
    //         $productId = $product->id;

    //         Session::put('TEMPPRODUCTID', $productId);

          
    //     }
    //     $selectedAttributes = $request->input('attributes', []);

    //     foreach ($selectedAttributes as $attributeId) {
           
    //         $attribute = new ProductAttribute();
    //         $attribute->attribute_id = $attributeId;
    //         $attribute->product_id = $productId;
    //         $attribute->status = 1;
    //         $attribute->sort_order = 1;
    //         $attribute->increment('sort_order');
    //         $attribute->save();
    //     }


    //     $response = array();

    //     if($page == 0){
    //         $response = array('page' => $page, 'selectedAttributes' => $selectedAttributes, 'productId' => $productId);
          
    //     }
      
    //     return response()->json(['success' => true, 'response' => $response]);
    // }
    public function getAttributeOptions(Request $request)
    {
        $selectedAttributes = $request->input('attributes', []);
        $page = $request->input('editStatus'); // 1/0
        $productId = $request->input('productId');
        $index = $request->input('index');
       
        $prevAttributes = ProductAttribute::where('product_id', $productId)->pluck('attribute_id')->toArray();
        
        $newAttributes = array_diff($selectedAttributes, $prevAttributes);
        // echo '<pre>';
        // print_r($newAttributes);
        // die();
        $attributesToRemove = array_diff($prevAttributes, $selectedAttributes);

       // $attributesToRemove = array_values($attributesToRemove);
        // echo '<pre>';
        // print_r($attributesToRemove);
        // die();
        
        if (empty($productId) && $page == 0) {
            $product = new Product();
            $product->name = 'temp-product';
            $product->status = 0;
            $product->sortOrder = 1;
            $product->increment('sortOrder');
            $product->save();
        
            $productId = $product->id;
            Session::put('TEMPPRODUCTID', $productId);
        }
    
        if (!empty($attributesToRemove)) {
            ProductAttribute::where('product_id', $productId)
                ->whereIn('attribute_id', $attributesToRemove)
                ->delete();
        }
       
        foreach ($selectedAttributes as $attributeId) {
            $exists = ProductAttribute::where('product_id', $productId)
                ->where('attribute_id', $attributeId)
                ->exists();
    
            if (!$exists) {
                $attribute = new ProductAttribute();
                $attribute->attribute_id = $attributeId;
                $attribute->product_id = $productId;
                $attribute->status = 1;
                $attribute->sort_order = 1;
                $attribute->increment('sort_order');
                $attribute->save();
            }
        }
        
        $options = ProductAttribute::where('product_id', $productId)
            ->whereIn('attribute_id', $newAttributes)
            ->orderBy('sort_order')
            ->with('attributeOptions', 'attribute')
            ->get()
            ->groupBy('attribute_id')
            ->toArray();
            // echo '<Pre>';
            // print_r($options);
            // die();
        
        $attributeIds = ProductAttribute::where('product_id', $productId)
            ->whereIn('attribute_id', $newAttributes)
            ->pluck('attribute_id')
            ->toArray();

        if(isset($newAttributes)){
        $html = $this->addAttributesdropdowns($newAttributes, $options, $index);
        }

        
        $response = [
            'page' => $page,
            'attributeOptions' => $options,
            'selectedAttributes' => $selectedAttributes,
            'productId' => $productId,
            'prevAttributes' => $prevAttributes,
            'newSelectedAttribute' => array_values($newAttributes),
            'attributeId' => $attributeIds,
            'index' => $index,
            'html' => $html,
            'attributesToRemove' => array_values($attributesToRemove)
           
        ];
        // echo '<pre>';
        // print_r($response);
        // die();
    
        return response()->json(['success' => true, 'response' => $response]);
    }
    
    
    


    // public function addVariation(Request $request)
    // {
    //     $productId = Session::get('TEMPPRODUCTID');
    //     $productAttributes = ProductAttribute::where('product_id', $productId)
    //     ->orderBy('sort_order')
    //     ->with('attribute', 'attributeOptions')
    //     ->get();
       
    //     $data = [];
    //     foreach ($productAttributes as $productAttribute) {
    //         $attributeId = $productAttribute->attribute->id;
    //         $attributeOptions = $productAttribute->attributeOptions;
        
    //         if (!isset($data[$attributeId])) {
    //             $data[$attributeId] = [];
    //         }
        
    //         foreach ($attributeOptions as $option) {
    //             $data[$attributeId][] = [
    //                 'id' => $option->id,
    //                 'value' => $option->value
    //             ];
    //         }
    //     }
        
    //     $response = [
    //         'status' => 1,
    //         'message' => 'Option list',
    //         'attributeOptions' => $data 

    //     ];

    //     return response()->json(['success' => true, 'response' => $response]);

    // }


    public function addVariation(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // die();
       $productId = Session::get('TEMPPRODUCTID');

       $page = $request->input('editStatus');

       if($page == 1){
       $productId = $request->input('productId');
       }
        // echo '<pre>';
        // print_r($productId);
        // die();
      
        $productAttributes = ProductAttribute::where('product_id', $productId)
        ->orderBy('sort_order')
        ->with(['attribute', 'attributeOptions'])
        ->get();
        // echo '<pre>';
        // print_r($productAttributes);
        // die();
        
        $attributeIndex = $request->input('index', 0); 
    
        $html = '
            <tr class="variation_'.$attributeIndex.'" data-index="'.$attributeIndex.'">
                <td class="col-md-3 col-sm-6 p-1" style="margin-right: 0;">
                    <input class="form-control form-control-sm" name="variation['.$attributeIndex.'][sku]" placeholder="Enter SKU"/>
                </td>
                <td class="col-md-3 col-sm-6 p-1" style="margin-right: 0;">
                    <input class="form-control form-control-sm" name="variation['.$attributeIndex.'][price]" placeholder="Enter Product Price"/>
                </td>
                <td class="col-md-3 col-sm-6 p-1" style="margin-right: 0;">
                    <input class="form-control form-control-sm" name="variation['.$attributeIndex.'][stock]" placeholder="Enter Stock"/>
                </td>';
    
        foreach ($productAttributes as $productAttribute) {
            $attributeOptions = $productAttribute->attributeOptions;
            // echo '<pre>';
            // print_r($attributeOptions);
            // die();
            $attributeName = $productAttribute->attribute;
    
            if ($attributeOptions->isNotEmpty()) {
                $html .= '<td class="col-md-3 col-sm-6 p-1" style="margin-right: 0;">
                            <select name="variation['.$attributeIndex.'][attributeOptions][]" class="form-control form-control-sm selectpicker attributes_'.$productAttribute->attribute_id.'">
                                <option value="">Select '.$attributeName->name.'</option>';
    
                foreach ($attributeOptions as $option) {
                    $html .= '<option value="'.$option->id.'">'.$option->value.'</option>';
                }
    
                $html .= '   </select>
                          </td>';
            }
        }
    
        $html .= '<td class="col-md-3 col-sm-6 p-1 delete-row" style="margin-right: 0;">
                    <i class="fa fa-trash fa-2x delete-icon cursor-pointer" aria-hidden="true"></i>
                  </td>
              </tr>';
    
        $attributeIndex++; 
    
        $response = [
            'status' => 1,
            'message' => 'Option list',
            'html' => $html,
            'index' => $attributeIndex 
        ];
    
        return response()->json(['success' => true, 'response' => $response]);
    }
    

    private function addAttributesdropdowns($newAttributes, $options, $index)
    {
        $html = '';
        foreach ($newAttributes as $attributeId) {
            $html .= '<td class="col-md-3 col-sm-6 p-1" style="margin-right: 0;">';
            $html .= '<select name="variation['.$index.'][attributeOptions][]" class="form-control form-control-sm selectpicker attributes_'.$attributeId.'">';
            $html .= '<option value="">Select '.$options[$attributeId][0]['attribute']['name'].'</option>';
            
            if (isset($options[$attributeId])) {
                foreach ($options[$attributeId] as $optionGroup) {
                    foreach ($optionGroup['attribute_options'] as $option) {
                        $html .= '<option value="'.$option['id'].'">'.$option['value'].'</option>';
                    }
                }
            }

            $html .= '</select>';
            $html .= '</td>';
            $index++;
        }
        return $html;
    }


}
