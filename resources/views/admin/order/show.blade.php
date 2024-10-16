@extends('layout.admin')
@section('content')

<div class="row">


    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <!-- basic form start -->

            <div class="col-12 mt-5 start-form-sec">

                <div class="card">
                    <div class="card-body">

                        <!-- <h4 class="header-title">Basic form</h4> -->

                        <div class="invoice-area">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="iv-left col-6">
                                                <span>Order ID:</span>
                                            </div>
                                            <div class="iv-right col-6 text-md-right">
                                                <span>#{{ $order->id }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="invoice-address">
                                                <h3>Customer Details</h3>
                                                <?php /* 
                                                <h5>{{ $order->customerName }}</h5>
                                                <h5>{{ $order->customerEmail }}</h5>
                                                <p>{{ $orderBilling->company }}</p>
                                                <p>{{ $orderBilling->address1 }}</p>
                                                <p>{{ $orderBilling->address2 }}, {{ $orderBilling->coutry }}, {{ $orderBilling->zip }} {{ $orderBilling->state }}</p>
                                                */ ?>                                                                                     
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <ul class="invoice-date">
                                                <li>Order Date : {{ $order->created_at }}</li>
                                                <li>Order Status :  {{$order->order_status}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="invoice-table table-responsive mt-5">
                                        <table class="table table-bordered table-hover text-right">
                                            <thead>
                                                <tr class="text-capitalize">
                                                    <th class="text-center" style="width: 5%;">S.No.</th>
                                                    <th class="text-left" style="width: 15%; min-width: 130px;">Product</th>
                                                    <th class="text-left">Quantity</th>
                                                    <th class="text-left">Customer Name</th>
                                                    <th style="min-width: 100px">Cost</th>
                                                    <th>total</th> 
                                                </tr>
                                            </thead>
                                            <tbody>

                                                 
                                            @php $i = 1 @endphp 
                                            @foreach($orderItem as $value)
                                                <tr>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td class="text-left">{{ $value->product->name }}</td>
                                                    <td class="text-left">{{  $value->quantity }}</td>
                                                    <td class="text-left">{{  $customer->username }}</td>
                                                    {{-- <td class="text-left">{{  $orderBilling->first_name }}</td> --}}
                                                    <td>&#8377;
                                                        @if(empty($value->product->price * $value->quantity))
                                                        0
                                                        @else
                                                        {{ $value->product->price}} &#10005; {{$value->quantity}}
                                                        @endif          
                                                    </td>
                                                    <td>&#8377;{{ $value->product->price * $value->quantity}}</td> 
                                                </tr>
                                                @php $i++ @endphp 
                                            @endforeach                    
                            
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6">total:</td>
                                                    <td>&#8377;{{$cart->total_amount }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
            <!-- basic form end -->
        </div>
    </div>
</div>

@section('js')
<script src="{{ asset('assets/admin/js/console/customer.js') }}"></script>
@append

@endsection