<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\Attribute;
use App\Models\Admin\ProductAttribute;
use App\Models\Admin\ProductVariation;
use App\Models\Admin\ProductVariationAttribute;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function fetchProductDetails($slug)
{
    $product = Product::where('slug', $slug)->first();

    if (!$product) {
        return response()->json([
            'message' => 'Product does not exist',
            'status' => '0',
        ], 404);
    }

    $productDetails = [
        'id' => $product->id,
        'type' => $product->type,
        'slug' => $product->slug,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'productCategory' => productCategory($product->category_id),
        'image' => url('/') . "/uploads/productImage/" . getMediaName($product->imageId),
        'status' => $product->status,
    ];

    $response = [
        'message' => 'Product exists',
        'status' => '1',
        'response' => [
            'product' => [
                'productDetails' => $productDetails,
            ]
        ]
    ];

    if($product->type == 1){
        $productVariation = [];
        $i = 0;
        // echo '<pre>';
        // print_r($product->productVariation);
        // die();
        
        foreach ($product->productVariation as $variation) {
            
            $productVariation[$i] = [
                'sku' => $variation->sku,
                'price' => $variation->price,
                'stock' => $variation->stock,
            ];
        
            foreach ($variation->variationAttribute as $variationAttribute) {
                $productVariation[$i]['attribute'][] = [
                    'attribute_id' => $variationAttribute->attributeOption->attribute_id,
                    'attribute_name' => $variationAttribute->attributeOption->attribute->name, 
                    'option_id' => $variationAttribute->attributes_options_id,
                    'option_name' => $variationAttribute->attributeOption->value, 
                ];
            }
        
            $i++;
        }
    

    $attributes = ProductAttribute::where('product_id', $product->id)->get();
    $productAttributes = [];

    foreach ($attributes as $index => $productAttribute) {
        $attribute = $this->getProductAttributeById($productAttribute->attribute_id);
    //     echo '<pre>';
    //    print_r($attribute);
    //    die();
        
       // $attributeOptions = $productAttribute->attribute->options()->get();
       $attributeOptions = ProductVariationAttribute::where('attribute_id', $productAttribute->attribute_id)
    ->where('product_id', $product->id)
    ->get();

$options = [];
$existingOptionIds = []; // Array to track existing option IDs

foreach ($attributeOptions as $option) {
    $optionId = $option->attributeOption->id;

    // Check if the option ID already exists in the array
    if (!in_array($optionId, $existingOptionIds)) {
        $options[] = [
            'option_id' => $optionId,
            'option_value' => $option->attributeOption->value,
        ];
        $existingOptionIds[] = $optionId; // Add the option ID to the tracking array
    }
}


        $productAttributes[$index] = [
            'attribute_id' => $productAttribute->attribute_id,
            'attribute_name' => $attribute->name,
            'options' => $options,
        ];
    }
    $response['response']['product']['productVariation'] = $productVariation;
    $response['response']['product']['attributes'] = $productAttributes;
    $response['response']['product']['maxPrice'] = $this->findMaxPriceByProductId($product->id);
}

    return response()->json($response, 200);
}

protected function findMaxPriceByProductId($productId){
    return ProductVariation::where('product_id', $productId)->max('price');
}

protected function getProductAttributeById($id)
{
        return Attribute::find($id);
}
}
// $productVariationAttribute = ProductVariationAttribute::where('product_id', $product->id)->where('product_varia', $productAttribute->attribute_id)->get();
                // foreach($productVariationAttribute as $pva){
                //     $productAttributes[$i]['available_options'][] = [
                //           'attribute_id' => $pva->id,
                //           'attributes_options_id' => $pva->attributes_options_id
                //     ];
                // }