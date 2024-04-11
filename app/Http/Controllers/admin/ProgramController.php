<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Program;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class ProgramController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();

        $data["program"] = Program::where('organisationId', $this->organisationId)->orderBy('sortOrder')->get();
        $data["pageTitle"] = 'Manage Program';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'program';
        return view('admin.program.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["pageTitle"] = 'Add Program';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'program';
        return view('admin.program.create')->with($data);
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $program = new Program();

        // Image Uploading

        if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $program->imageId, $this->userId, "uploads/program/"); //Image, ReferenceRecordId, UserId, Path
           
            $program->imageId = $mediaId;
 
         }

            $program->name = $request->input('name');
            $program->slug = str::slug($request->input('name'));
            $program->metaKeyword = $request->input('metaKeyword');
            $program->metaDescription = $request->input('metaDescription');
            $program->description = $request->input('description');
            $program->organisationId = $this->organisationId;
           
       
        $program->status = 1;
        $program->sortOrder = 1;

        $program->increment('sortOrder');

        $program->save();

        return redirect()->route('program.index')->with('message', 'Program Added Successfully');
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

        $data['program'] = Program::find($id);

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Program';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'program';
        return view('admin.program.create')->with($data);
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
        ]);
        
        $id = $request->input('id');

        $program = Program::find($id);

         // Image Uploading

         if ($request->hasFile('image')) {  // Check if file input is set

            $mediaId = imageUpload($request->image, $program->imageId, $this->userId, "uploads/program/"); //Image, ReferenceRecordId, UserId, Path
            
            $program->imageId = $mediaId;
 
         }

        $program->name = $request->input('name');
        $program->slug = urlencode($request->input('name'));
        $program->metaKeyword = $request->input('metaKeyword');
        $program->metaDescription = $request->input('metaDescription');
        $program->description = $request->input('description');
        $program->save();

        return redirect()->route('program.index')->with('message', 'Program Updated Successfully');
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
        $program = Program::find($id);
        $program->delete($id);

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
                $program = Program::find($id);
                $program->delete();
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
                $program = Program::find($id);
                $program->sortOrder = $values->position;
                $result = $program->save();
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

        $program = Program::find($id);
        $program->status = $status;
        $result = $program->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
