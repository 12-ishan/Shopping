<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\AwardsLevel;
use Illuminate\Support\Facades\Auth;


class AwardsLevelController extends Controller
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
        $data["awardsLevel"] = AwardsLevel::where('organisationId', $this->organisationId)->orderBy('sortOrder')->get(); 
        $data["pageTitle"] = 'Manage Awards Level';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'awardsLevel';
        return view('admin.awardsLevel.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data["pageTitle"] = 'Add Awards Level';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'awardsLevel';
        return view('admin.awardsLevel.create')->with($data);
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

        $awardsLevel = new AwardsLevel();
        $awardsLevel->name = $request->input('name');
        $awardsLevel->description = $request->input('description');
        $awardsLevel->status = 1;
        $awardsLevel->sortOrder = 1;
        $awardsLevel->increment('sortOrder');
        $awardsLevel->save();
        return redirect()->route('awardsLevel.index')->with('message', 'Awards Level Added Successfully');
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
        $data['awardsLevel'] = AwardsLevel::find($id);
        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Awards Level';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'awardsLevel';
        return view('admin.awardsLevel.create')->with($data);
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
        $awardsLevel = AwardsLevel::find($id);
        $awardsLevel->name = $request->input('name');
        $awardsLevel->description = $request->input('description');
        $awardsLevel->save();
        return redirect()->route('awardsLevel.index')->with('message', 'Awards Level Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $awardsLevel = AwardsLevel::find($id);
        $awardsLevel->delete($id);
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
                $awardsLevel = AwardsLevel::find($id);
                $awardsLevel->delete();
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
                $awardsLevel = AwardsLevel::find($id);
                $awardsLevel->sortOrder = $values->position;
                $result = $awardsLevel->save();
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
        $awardsLevel = AwardsLevel::find($id);
        $awardsLevel->status = $status;
        $result = $awardsLevel->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}



