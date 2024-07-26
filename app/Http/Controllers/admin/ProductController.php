<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


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
        $this->validate(request(), [
            'name' => 'required',
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required'
           
            
        ]);

        $product = new product();

        if ($request->hasFile('image')) {  

            $mediaId = imageUpload($request->image, $product->imageId, $this->userId, "uploads/productImage/"); 
           
            $product->imageId = $mediaId;
 
         }

        $product->category_id = $request->input('categoryId');
        $product->name = $request->input('name');
        $product->slug = str::slug($request->input('name'));
        $product->price = $request->input('price');
        $product->description = $request->input('description');
       
        $product->status = 1;
        $product->sortOrder = 1;

        $product->increment('sortOrder');

        $product->save();

        return redirect()->route('product.index')->with('message', 'Product Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data = array();

        $data['product'] = Product::find($id);
        $data["productCategory"] = ProductCategory::orderBy('sortOrder')->get();

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
    public function update(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required',
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required'
           
        ]);
        
        $id = $request->input('id');


        $product = Product::find($id);
        // echo '<pre>';
        // print_r($product);
        // die();

        if ($request->hasFile('image')) { 

           
            $mediaId = imageUpload($request->image, $product->imageId, $this->userId, "uploads/productImage/"); 
            // echo '<pre>';
            // print_r($mediaId);
            // die();
    
            
            $product->imageId = $mediaId;
 
         }

       $product->category_id = $request->input('categoryId');
        $product->name = $request->input('name');
        $product->slug = urlencode($request->input('name'));
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();

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

}
