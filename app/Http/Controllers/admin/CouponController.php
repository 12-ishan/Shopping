<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Coupon;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->organisation_id = Auth::user()->organisation_id;    
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
        $data["coupon"] = Coupon::orderBy('sort_order')->get(); 
        $data['pageTitle'] = 'Manage Coupon';
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'coupon';
        return view('admin.coupon.manage')->with($data);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = array();
        $data['pageTitle'] = 'Add Coupon';
        $data["activeMenu"] = 'master';
        $data["activeSubMenu"] = 'coupon';
         return view('admin.coupon.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate(request(), [
            'title' => 'required',
            'couponCode' => 'required|min:6',
            'amount' => 'required|numeric'

        ]);

        $coupon = new Coupon();
        $coupon->title = $request->input('title');
        $coupon->coupon_code = $request->input('couponCode');  
        $coupon->discount_amount = $request->input('amount');
        $coupon->description = $request->input('description');
        $coupon->status = 1;
        $coupon->sort_order = 1;
        $coupon->increment('sort_order');
        $coupon->save();
        return redirect()->route('coupon.index')->with('message', 'Coupon Added Successfully');
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
        $data['coupon'] = Coupon::find($id);
        $data["editStatus"] = 1;
        $data['pageTitle'] = "Upadate Coupon";
        $data['activeMenu'] = 'master';
        $data['activeSubMenu'] = 'coupon';
        return view('admin.coupon.create')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $this->validate(request(), [
            'title' => 'required',
            'couponCode' => 'required|min:6',
            //'amount' => 'required|numeric'

        ]);
        $id = $request->input('id');
        $coupon = Coupon::find($id);
        $coupon->title = $request->input('title');
        $coupon->coupon_code = $request->input('couponCode');  
        $coupon->discount_amount = $request->input('amount');
        $coupon->description = $request->input('description');
        $coupon->save();
        return redirect()->route('coupon.index')->with('message', 'Coupon Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $coupon = Coupon::find($id);
        $coupon->delete($id);
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
                $coupon = Coupon::find($id);
                $coupon->delete();
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
                $coupon = Coupon::find($id);
                $coupon->sort_order = $values->position;
                $result = $coupon->save();
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
        $coupon = Coupon::find($id);
        $coupon->status = $status;
        $result = $coupon->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }
        return response()->json($response);
    }



}

