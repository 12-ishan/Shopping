<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Contact;
use Illuminate\Support\Facades\Auth;


class ContactLeadsController extends Controller
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

        $data["contact"] = Contact::orderBy('sortOrder')->get();
      

        $data["pageTitle"] = 'Manage Contact Leads';
        $data["activeMenu"] = 'contact leads';
        return view('admin.contactLeads.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $data = array();

    //     $data["pageTitle"] = 'Add Contact';
    //     $data["activeMenu"] = 'contact';
    //     return view('admin.contact.create')->with($data);
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $this->validate(request(), [
    //         'name' => 'required',
    //         'email' => 'required|email|unique:contact',
    //     ]);

    //     $contact = new Contact();

    //         $contact->name = $request->input('name');
    //         $contact->email = $request->input('email');
    //         $contact->phone = $request->input('phone');
    //         $contact->message = $request->input('description');
       
    //     $contact->status = 1;
    //     $contact->sortOrder = 1;

    //     $contact->increment('sortOrder');

    //     $contact->save();

    //     return redirect()->route('contact.index')->with('message', 'Contact Added Successfully');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
        
    //     $data = array();

    //     $data['contact'] = Contact::find($id);

    //     $data["editStatus"] = 1;
    //     $data["pageTitle"] = 'Update Contact';
    //     $data["activeMenu"] = 'contact';
    //     return view('admin.contact.create')->with($data);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request)
    // {

    //     $this->validate(request(), [
    //         'name' => 'required',
    //     ]);
        
    //     $id = $request->input('id');

    //     $contact = Contact::find($id);

    //     $contact->name = $request->input('name');
    //     $contact->email = $request->input('email');
    //     $contact->phone = $request->input('phone');
    //     $contact->message = $request->input('description');

    //     $contact->save();

    //     return redirect()->route('contact.index')->with('message', 'Contact Updated Successfully');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $contact = Contact::find($id);
        $contact->delete($id);

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => $request->id
        ]);
    }

    // /**
    //  * Remove all selected resource from storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroyAll(Request $request)
    {

        $record = $request->input('deleterecords');

        if (isset($record) && !empty($record)) {

            foreach ($record as $id) {
                $contact = Contact::find($id);
                $contact->delete();
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'Delete Successfull',
            'response' => ''
        ]);
    }

    // /**
    //  * Update SortOrder.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function updateSortorder(Request $request)
    {
        $data = $request->records;
        $decoded_data = json_decode($data);
        $result = 0;

        if (is_array($decoded_data)) {
            foreach ($decoded_data as $values) {

                $id = $values->id;
                $contact = Contact::find($id);
                $contact->sortOrder = $values->position;
                $result = $contact->save();
            }
        }

        if ($result) {
            $response = array('status' => 1, 'message' => 'Sort order updated', 'response' => $data);
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => $data);
        }

        return response()->json($response);
    }

    // /**
    //  * Update Status resource from storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function updateStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;

        $contact = Contact::find($id);
        $contact->status = $status;
        $result = $contact->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
