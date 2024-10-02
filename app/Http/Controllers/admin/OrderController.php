<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\GeneralSetting;
use App\Models\Admin\Order;
use App\Models\Admin\OrderItem;
use App\Models\OrderBilling;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
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

        $data["order"] = Order::orderBy('sort_order')->with('username', 'cart')->get();
       
        $data["pageTitle"] = 'Manage Order';
        $data["activeMenu"] = 'order';
        return view('admin.order.manage')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();

        $data["pageTitle"] = 'Add Order';
        $data["activeMenu"] = 'order';
        return view('admin.order.create')->with($data);
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
            'userId' => 'required',
            'paymentId' => 'required',
            'customerEmail' => 'required',
            'customerName' => 'required',
            'totalAmount' => 'required',
        ]);

        $order = new Order();

            $order->userId = $request->input('userId');
            $order->paymentId = $request->input('paymentId');
            $order->customerEmail = $request->input('customerEmail');
            $order->customerName = $request->input('customerName');
            $order->totalAmount = $request->input('totalAmount');
            $order->discount = $request->input('discount');
            $order->paymentGateway = $request->input('paymentGateway');
       
        $order->status = 1;
        $order->sortOrder = 1;

        $order->increment('sortOrder');

        $order->save();

        return redirect()->route('order.index')->with('message', 'Order Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);

        $cart = Cart::where(function ($query) use ($order) {
            if ($order->customer_id) {
                $query->where('customer_id', $order->customer_id);
            } else {
                $query->where('session_id', $order->session_id);
            }
        })->first();
    
        $customer = $order->username;
    
        $data['order'] = $order;
        $data['cart'] = $cart;
        $data['customer'] = $customer; 
        $data['orderBilling'] = OrderBilling::where('order_id', $id)->first();
        $data['orderItem'] = OrderItem::where('order_id', $id)->with('product')->get();
        $data["pageTitle"] = 'Order Details';
        $data["activeMenu"] = 'order';
    
        return view('admin.order.show')->with($data);
        
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

        $data['order'] = Order::find($id);

        $data["editStatus"] = 1;
        $data["pageTitle"] = 'Update Order';
        $data["activeMenu"] = 'order';
        return view('admin.order.create')->with($data);
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
            'email' => 'required',
        ]);
        
        $id = $request->input('id');

        $order = Order::find($id);

        
        $order->userId = $request->input('userId');
        $order->paymentId = $request->input('paymentId');
        $order->customerEmail = $request->input('customerEmail');
        $order->customerName = $request->input('customerName');
        $order->totalAmount = $request->input('totalAmount');
        $order->discount = $request->input('discount');
        $order->paymentGateway = $request->input('paymentGateway');

        $order->save();

        return redirect()->route('order.index')->with('message', 'Order Updated Successfully');
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
        $order = Order::find($id);
        $order->delete($id);

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
                $order = Order::find($id);
                $order->delete();
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
                $order = Order::find($id);
                $order->sortOrder = $values->position;
                $result = $order->save();
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

        $order = Order::find($id);
        $order->status = $status;
        $result = $order->save();

        if ($result) {
            $response = array('status' => 1, 'message' => 'Status updated', 'response' => '');
        } else {
            $response = array('status' => 0, 'message' => 'Something went wrong', 'response' => '');
        }

        return response()->json($response);
    }

}
