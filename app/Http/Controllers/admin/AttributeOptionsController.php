<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Attribute;
use App\Models\Admin\AttributeOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AttributeOptionsController extends Controller
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
        $data["options"] = AttributeOptions::orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Manage Attribute Options';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'options';
        return view('admin.attributeOptions.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["productAttribute"] = Attribute::where('status',1)->orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Add Attribute Options';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'options';
        return view('admin.attributeOptions.create')->with($data);
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
            'value' => 'required',
            'attributeId' => 'required'
              
        ]);

        $option = new AttributeOptions();

        $option->attribute_id = $request->input('attributeId');
        $option->value = $request->input('value');
        $option->description = $request->input('description');
       
        $option->status = 1;
        $option->sortOrder = 1;

        $option->increment('sortOrder');

        $option->save();

        return redirect()->route('attribute-options.index')->with('message', 'Option Added Successfully');
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

        $data['options'] = AttributeOptions::find($id);
        $data["attributes"] = Attribute::orderBy('sortOrder')->get();

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Option';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'options';
        return view('admin.attributeOptions.create')->with($data);
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
            'value' => 'required',
            'attributeId' => 'required'
           
        ]);
        
        $id = $request->input('id');

        $option = AttributeOptions::find($id);
        $option->attribute_id = $request->input('attributeId');
        $option->value = $request->input('value');
        $option->description = $request->input('description');

        $option->save();

        return redirect()->route('attribute-options.index')->with('message', 'option Updated Successfully');
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
        $option = AttributeOptions::find($id);
        $option->delete($id);

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
                $option = AttributeOptions::find($id);
                $option->delete();
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
                $option = AttributeOptions::find($id);
                $option->sortOrder = $values->position;
                $result = $option->save();
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

        $option = AttributeOptions::find($id);
        $option->status = $status;
        $result = $option->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
