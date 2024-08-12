<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    //
    public function getProductCategories(Request $request)
    {
       $categories = ProductCategory::where('status', 1)->get();
    // echo '<pre>';
    // print_r($categories);
    // die();
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
        $response = [
            'message' => 'Category not exists',
            'status' => '0',
          //  'products' => []
        ];
    } else {
        $products = Product::where('category_id', $category->id)->get();
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
                'product_category' => $productCategoryName // Add the category name to the response
            ];
        }

        if ($products->isEmpty()) {
            $response = [
                'message' => 'Product not found',
                'status' => '0',
                'products' => []
            ];
        } else {
            $response = [
                'message' => 'Products exist',
                'status' => '1',
                'products' => $data,
                'categoryName' => $category->name
            ];
        }
    }

    return response()->json($response, 200);
}



public function getSingleProduct($slug){

    $product = Product::where('slug', $slug)->first();

    if($product){
    $reponse = [
        'message' => 'single product detail',
        'status' => '1',
        'product' => $product
    ];
   }

   return response()->json($response, 201);

}
   
}  

