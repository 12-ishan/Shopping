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
//use App\Http\Requests\StoreProductRequest;


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

  
    public function index()
    {
        $data = array();
        $data["products"] = Product::where('status', '!=', 2)
        ->orderBy('sortOrder')
        ->get();
        $data["pageTitle"] = 'Manage Product';
        $data["activeMenu"] = 'Product';
        return view('admin.product.manage')->with($data);
    }

    
    public function create()
    {
        $data = array();

        $data["productCategory"] = ProductCategory::where('status',1)->orderBy('sortOrder')->get();
        $data['attributes'] = Attribute::where('status', 1)->orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Add Product';
        $data["activeMenu"] = 'Product';
        return view('admin.product.create')->with($data);
    }

    public function store(Request $request)
    { 
        $this->validate(request(), [
            'name' => 'required',
            'categoryId' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // $rules = [
        //     'name' => 'required',
        //     'price' => 'required',
        //     'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ];

        // if ($request->input('type') == 1) {
        //     $rules['sku'] = 'required|unique:product_variations,sku';
        // }

        // $validatedData = $request->validate($rules, [
        //     'sku.required' => 'Please enter the SKU.',
        //     'sku.unique' => 'The SKU has already been taken. Please choose a different one.',
        // ]);

    
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
                        $variationAttribute->attribute_id = $this->getAttributeByOptionId($attributeValueId);
                        $variationAttribute->product_id = $product->id;
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
    
    
    public function edit($id)
    { 
        $data = array();
    
        $data['product'] = Product::with([
            'productAttributes.attribute.options',
            'productVariation.attributes.attributeOption', 
            'image'
        ])->find($id);
        // $data['product'] = Product::with([
        //     'productAttributes' => function ($query) {
        //         $query->orderBy('sort_order'); 
        //     },
        //     'productAttributes.attribute.options', 
        //     'productVariation' => function ($query) {
        //         $query->where('status', '!=', 2);
        //     },
        //     'productVariation.attributes.attributeOption', 
        //     'image'
        // ])->find($id);
        
     
        $data['rowcount'] = ProductVariation::where('product_id', $id)->count();
     
        $data["productCategory"] = ProductCategory::orderBy('sortOrder')->get();
        $data["attributes"] = Attribute::orderBy('sortOrder')->get();
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Product';
        $data["activeMenu"] = 'Product';
        return view('admin.product.create')->with($data);
    }
    

    public function update(Request $request, $id)
    {
        // $rules = [
        //     'name' => 'required',
        //     'price' => 'required',
        //     'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ];
        // if ($request->input('type') == 1) {
        //     $rules['sku'] = 'required|unique:product_variation,sku';
        // }
        // $validatedData = $request->validate($rules, [
        //     'sku.required' => 'Please enter the SKU.',
        //     'sku.unique' => 'The SKU has already been taken. Please choose a different one.',
        // ]);
        
    
        $product = Product::find($id);
    
        if ($request->hasFile('image')) {
            $mediaId = imageUpload($request->image, $product->imageId, $this->userId, "uploads/productImage/");
            $product->imageId = $mediaId;
        }
    
        $product->category_id = $request->input('categoryId');
        $product->name = $request->input('name');
        $product->slug = Str::slug($request->input('name'));
        $product->type = $request->input('type');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->status = 1;
        $product->save();
    
        if ($request->input('type') == 1 && $request->has('variation')) {

            $requestVariations = $request->input('variation');
        
            $requestedSkus = array_map(function($variation) {
                return $variation['sku'];
            }, $requestVariations);
        
            $existingVariations = ProductVariation::where('product_id', $id)->get();
            $existingSkus = $existingVariations->pluck('sku')->toArray();
        
            $newSkus = array_diff($requestedSkus, $existingSkus);
            
            $removedSkus = array_diff($existingSkus, $requestedSkus);
        

            foreach ($existingSkus as $existingSku) {
                foreach ($requestVariations as $variationToUpdate) {
                    if ($existingSku == $variationToUpdate['sku']) {
                        $productVariation = ProductVariation::where('product_id', $product->id)
                            ->where('sku', $existingSku)
                            ->first();
        
                        if ($productVariation) {
                            $productVariation->price = $variationToUpdate['price'];
                            $productVariation->stock = $variationToUpdate['stock'];
                            $productVariation->status = 1;
                            $productVariation->save();
        
                            if (isset($variationToUpdate['attributeOptions']) && is_array($variationToUpdate['attributeOptions'])) {

                                 ProductVariationAttribute::where('product_variation_id', $productVariation->id)->delete();
         
                                foreach ($variationToUpdate['attributeOptions'] as $attributesOption) {
                                    if (!empty($attributesOption)) {  
                                        $option = new ProductVariationAttribute();
                                        $option->product_variation_id = $productVariation->id;
                                        $option->product_id = $product->id;
                                        $option->attributes_options_id = $attributesOption;
                                        $option->attribute_id = $this->getAttributeByOptionId($attributesOption);
                                        $option->status = 1;
                                        $option->sort_order = 1;
                                        $option->increment('sort_order');
                                        $option->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        
            foreach ($requestVariations as $variationToAdd) {
                if (in_array($variationToAdd['sku'], $newSkus)) {
              
                    $productVariation = new ProductVariation();
                    $productVariation->product_id = $product->id;
                    $productVariation->sku = $variationToAdd['sku'];
                    $productVariation->price = $variationToAdd['price'];
                    $productVariation->stock = $variationToAdd['stock'];
                    $productVariation->status = 1;
                    $productVariation->sort_order = 1;
                    $productVariation->increment('sort_order');
                    $productVariation->save();
        
                    if (isset($variationToAdd['attributeOptions']) && is_array($variationToAdd['attributeOptions'])) {
                        foreach ($variationToAdd['attributeOptions'] as $attributesOption) {
                            if (!empty($attributesOption)) {  
                                $option = new ProductVariationAttribute();
                                $option->product_variation_id = $productVariation->id;
                                $option->product_id = $product->id;
                                $option->attributes_options_id = $attributesOption;
                                $option->attribute_id = $this->getAttributeByOptionId($attributesOption);
                                $option->status = 1;
                                $option->sort_order = 1;
                                $option->increment('sort_order');
                                $option->save();
                            }
                        }
                    }
                }
            }
        
            if (!empty($removedSkus)) {
                foreach ($removedSkus as $removeSku) {
                    $productVariation = ProductVariation::where('product_id', $product->id)
                        ->where('sku', $removeSku)
                        ->first();
        
                    if ($productVariation) {
                        
                        ProductVariationAttribute::where('product_variation_id', $productVariation->id)->update(['status' => 2]);

                        $productVariation->update(['status' => 2]);
                    }
                }
            }
        }
        return redirect()->route('product.index')->with('message', 'Product Updated Successfully');
    }

    Protected function getAttributeByOptionId($optionId)
    {
        $option = AttributeOptions::select('attribute_id')
        ->where('id', $optionId)
        ->first(); 
        return $option->attribute_id;
    }
    

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

    public function getAttributeOptions(Request $request)
    {
        $selectedAttributes = $request->input('attributes', []);
        $page = $request->input('editStatus'); // 1/0
        $productId = $request->input('productId');
        $index = $request->input('index');
       
        $prevAttributes = ProductAttribute::where('product_id', $productId)->pluck('attribute_id')->toArray();
        
        $newAttributes = array_diff($selectedAttributes, $prevAttributes);
       
        $attributesToRemove = array_diff($prevAttributes, $selectedAttributes);

       // $attributesToRemove = array_values($attributesToRemove);
        
        if (empty($productId) && $page == 0) {
            $product = new Product();
            $product->name = 'temp-product';
            $product->status = 2;
            $product->sortOrder = 1;
            $product->increment('sortOrder');
            $product->save();
        
            $productId = $product->id;
            Session::put('TEMPPRODUCTID', $productId);
        }

        if (!empty($attributesToRemove)) {
            
            $productAttributes = ProductAttribute::where('product_id', $productId)
                ->whereIn('attribute_id', $attributesToRemove)
                ->get();
    
            $attributeOptionIds = [];
            foreach ($productAttributes as $productAttribute) {
                $attributeOptionIds = array_merge($attributeOptionIds, $productAttribute->attributeOptions->pluck('id')->toArray());
            }
    
            if (!empty($attributeOptionIds)) {
                ProductVariationAttribute::whereIn('attributes_options_id', $attributeOptionIds)->delete();
            }
        
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
    
        return response()->json(['success' => true, 'response' => $response]);
    }

    
    public function addVariation(Request $request)
    {
       $productId = Session::get('TEMPPRODUCTID');

       $page = $request->input('editStatus');

       if($page == 1){
       $productId = $request->input('productId');
       }

        $productAttributes = ProductAttribute::where('product_id', $productId)
        //->orderBy('sort_order')
        ->with(['attribute', 'attributeOptions'])
        ->get();
   
        $variationRows = ProductVariation::where('product_id', $productId)->count();
      
        if ($variationRows == 1 && $page == 1) {
            $attributeIndex = $request->input('index', $variationRows); 
        } else {
            $attributeIndex = $request->input('index', $variationRows);
        }
    
    
        $html = '
            <tr class="variation_'.$attributeIndex.'" data-index="'.$attributeIndex.'">
                <td class="col-md-3 col-sm-6 p-1" style="margin-right: 0;">
                    <input class="form-control form-control-sm sku-fields" value="" name="variation['.$attributeIndex.'][sku]" placeholder="Enter SKU"/>
                </td>
                <td class="col-md-3 col-sm-6 p-1" style="margin-right: 0;">
                    <input class="form-control form-control-sm" name="variation['.$attributeIndex.'][price]" placeholder="Enter Product Price"/>
                </td>
                <td class="col-md-3 col-sm-6 p-1" style="margin-right: 0;">
                    <input class="form-control form-control-sm" name="variation['.$attributeIndex.'][stock]" placeholder="Enter Stock"/>
                </td>';
    
        foreach ($productAttributes as $productAttribute) {
            $attributeOptions = $productAttribute->attributeOptions;
           
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
           // $index++;
        }
        return $html;
    }


}
