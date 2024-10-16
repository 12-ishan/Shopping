<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\Product;
use App\Models\Admin\Attribute;
use App\Models\Admin\ProductVariationAttribute;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function getProductCategories(Request $request)
    {
       $categories = ProductCategory::where('status', 1)->get();
   
        if (empty($categories)) {

            $response = [
                'message' => 'Categories not exists',
                'status' => '0',
            ];
        } 
        else {
            $response = [
                'message' => 'Categories exists',
                'status' => '1',
                'categories' => $categories
            ];
        }
    
        return response()->json($response, 201);
    }


    public function getProductByCategory($slug)
    {
        $category = ProductCategory::where('slug', $slug)->first();
    
        if (empty($category)) {
            $response =[
                'message' => 'Category not exists',
                'status' => '0',
            ];
        }
    
        $allProducts = Product::where('category_id', $category->id)->get();
    
        if ($allProducts->isEmpty()) {
            $response=[
                'message' => 'Product not found',
                'status' => '0',
            ];
        }
    
    
        $products = Product::where('category_id', $category->id)->paginate(2);
    
        $attributes = Attribute::with('options:id,value,attribute_id')->get();
        $attributesWithOptions = [];
    
        foreach ($attributes as $attribute) {
            $options = $attribute->options->pluck('value', 'id');
            $attributesWithOptions[] = [
                'attribute_id' => $attribute->id,
                'attribute_name' => $attribute->name,
                'options' => $options->toArray(),
            ];
        }
    
       
        $data = [];
        foreach ($products as $product) {
            $mediaName = url('/') . "/uploads/productImage/" . getMediaName($product['imageId']);
            $productCategoryName = productCategory($product['category_id']);
    
            $data[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'media_name' => $mediaName,
                'price' => $product['price'],
                'description' => $product['description'],
                'product_category' => $productCategoryName,
            ];
        }
    
     
        if ($products->isEmpty()) {
            
            $data = [];
            foreach ($allProducts as $product) {
                $mediaName = url('/') . "/uploads/productImage/" . getMediaName($product['imageId']);
                $productCategoryName = productCategory($product['category_id']);
    
                $data[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'slug' => $product['slug'],
                    'media_name' => $mediaName,
                    'price' => $product['price'],
                    'description' => $product['description'],
                    'product_category' => $productCategoryName,
                ];
            }
    
           
           $response=[
                'message' => 'Products exist',
                'status' => '1',
                'products' => $data,
                'categoryName' => $category->name,
                'categorySlug' => $category->slug,
                'attributes' => $attributesWithOptions,
                'currentPage' => 1,
                'lastPage' => 1,   
            ];
        }
    
        
        $response=[
            'message' => 'Products exist',
            'status' => '1',
            'products' => $data,
            'categoryName' => $category->name,
            'categorySlug' => $category->slug,
            'attributes' => $attributesWithOptions,
            'currentPage' => $products->currentPage(), 
            'lastPage' => $products->lastPage(),       
        ];

        return response()->json($response, 200);
    }
    
        


//     public function getProductByCategory($slug)
// {
//     $category = ProductCategory::where('slug', $slug)->first();
   
//     if (empty($category)) {
//         $response = [
//             'message' => 'Category not exists',
//             'status' => '0',
//         ];
//     } else {
//         $products = Product::where('category_id', $category->id)->get();

//         $attributes = Attribute::with('options:id,value,attribute_id')->get();

//         $attributesWithOptions = [];
        
//         foreach ($attributes as $attribute) {
//             $options = $attribute->options->pluck('value', 'id'); 
//             $attributesWithOptions[] = [
//                 'attribute_id' => $attribute->id,
//                 'attribute_name' => $attribute->name,
//                 'options' => $options->toArray()
//             ];
//         }

//         $data = [];

//         foreach ($products as $product) {
//             $mediaName = url('/') . "/uploads/productImage/" . getMediaName($product['imageId']);
//             $productCategoryName = productCategory($product['category_id']); 

//             $data[] = [
//                 'id' => $product['id'],
//                 'name' => $product['name'],
//                 'slug' => $product['slug'],
//                 'media_name' => $mediaName,
//                 'price' => $product['price'],
//                 'description' => $product['description'],
//                 'product_category' => $productCategoryName 
//             ];
//         }

//         if ($products->isEmpty()) {
//             $response = [
//                 'message' => 'Product not found',
//                 'status' => '0',
//             ];
//         } else {
//             $response = [
//                 'message' => 'Products exist',
//                 'status' => '1',
//                 'products' => $data,
//                 'categoryName' => $category->name,
//                 'categorySlug' => $category->slug,
//                 'attributes' => $attributesWithOptions
//             ];
//         }
//     }

//     return response()->json($response, 200);
// }

public function search(Request $request)
{
    $query = $request->input('query');

    $products = Product::where('name', 'LIKE', "{$query}%")->get();

    $data = [];

    foreach ($products as $product) {
       
        $category = $product->category;
        
        $mediaName = url('/') . "/uploads/productImage/" . getMediaName($product['imageId']);
        $productCategoryName = $category ? $category->name : 'null'; 
        $categorySlug = $category ? $category->slug : 'null'; 

        $data[] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'slug' => $product['slug'],
            'media_name' => $mediaName,
            'price' => $product['price'],
            'description' => $product['description'],
            'product_category' => $productCategoryName,
            'category_slug' => $categorySlug, 
        ];
    }

    return response()->json([
        'query' => $query,
        'results' => $data,
    ]);
}

public function getFilteredProducts($slug, $optionId){

    $category = ProductCategory::where('slug', $slug)->first();
   
    if (empty($category)) {
        $response = [
            'message' => 'Category not exists',
            'status' => '0',
        ];
    } else {
        $products = Product::where('category_id', $category->id)->get();

        $products = Product::whereHas('productVariation.attributes', function ($query) use ($optionId) {
            $query->where('attributes_options_id', $optionId);
        })->get();


        $data = [];

        foreach ($products as $product) {
            $mediaName = url('/') . "/uploads/productImage/" . getMediaName($product['imageId']);
            $productCategoryName = productCategory($product['category_id']); 

            $data[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'media_name' => $mediaName,
                'price' => $product['price'],
                'description' => $product['description'],
                'product_category' => $productCategoryName 
            ];
        }

        if ($products->isEmpty()) {
            $response = [
                'products' => 'null',
                'message' => 'Product not found',
                'status' => '0',
            ];
        } else {
            $response = [
                'message' => 'Products exist',
                'status' => '1',
                'products' => $data,
                'categoryName' => $category->name,
                'categorySlug' => $category->slug,
              //  'attributes' => $attributesWithOptions
            ];
        }
    }

    return response()->json($response, 200);

}


// public function getSingleProduct($slug){

//     $product = Product::where('slug', $slug)->first();

//     if($product){
//     $reponse = [
//         'message' => 'single product detail',
//         'status' => '1',
//         'product' => $product
//     ];
//    }

//    return response()->json($response, 201);

// }
   
}  

