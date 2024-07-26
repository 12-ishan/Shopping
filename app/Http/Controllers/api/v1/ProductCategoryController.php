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
                'products' => []
            ];
        } else {
            $products = Product::where('category_id', $category->id)->get();
            $data = [];
    
            foreach ($products as $product) {
                $mediaName = url('/') . "/uploads/productImage/" . getMediaName($product['imageId']);
    
                $data[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'slug' => $product['slug'],
                    'media_name' => $mediaName,
                    'price' => $product['price'],
                    'description' => $product['description']
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
    

}


   
   

