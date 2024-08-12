<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Attribute;
use Illuminate\Support\Facades\Auth;


class ProductAttributesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->organisationId = Auth::user()->organisationId;    
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = array();
        $data['attributes'] = Attribute::orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Manage Product Attributes';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'attributes';
        return view('admin.productAttributes.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data["pageTitle"] = 'Product Attribute';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'attributes';
        return view('admin.productAttributes.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate(request(), [
            'name' => 'required',
        ]);

        $attribute = new Attribute();
        $attribute->name = $request->input('name');
        $attribute->description = $request->input('description');
        $attribute->status = 1;
        $attribute->sortOrder = 1;
        $attribute->increment('sortOrder');
        $attribute->save();
        return redirect()->route('product-attributes.index')->with('message', 'Attribute Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = array();
        $data['attribute'] = Attribute::find($id);
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Product Attribute';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'attributes';
        return view('admin.productAttributes.create')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $this->validate(request(), [
            'name' => 'required',
        ]);
        $id = $request->input('id');
        $attribute = Attribute::find($id);
        $attribute->name = $request->input('name');
        $attribute->description = $request->input('description');
        $attribute->save();
        return redirect()->route('product-attributes.index')->with('message', 'Attribute Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $attribute = Attribute::find($id);
        $attribute->delete($id);
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
                $attribute = Attribute::find($id);
                $attribute->delete();
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
                $attribute = Attribute::find($id);
                $attribute->sortOrder = $values->position;
                $result = $attribute->save();
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
        $attribute = Attribute::find($id);
        $attribute->status = $status;
        $result = $attribute->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}



