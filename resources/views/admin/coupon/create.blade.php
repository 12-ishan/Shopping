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
                         <p id="err" style="color:red;"></p>

                         <form id="couponForm" method="post" action="@if(isset($editStatus)){{ route('coupon.update', $coupon->id) }} @else {{ route('coupon.store')}}@endif" enctype='multipart/form-data'>


                            {{ csrf_field() }}

                            @if(isset($editStatus))
                            @method('PUT')
                            @endif


                            @if(session()->has('message'))
                            <div class="alert alert-danger">
                                {{ session()->get('message') }}
                            </div>
                            @endif


                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach

                            <div class="row">

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter coupon title" value="{{old('title',  isset($coupon->title) ? $coupon->title : NULL)}}">
                                    </div>
                                </div> 

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="couponCode">Coupon Code</label>
                                        <input type="text" class="form-control" id="couponCode" name="couponCode" placeholder="Enter coupon code" value="{{old('couponCode',  isset($coupon->coupon_code) ? $coupon->coupon_code : NULL)}}">
                                    </div>
                                </div> 

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="amount">Discount Amount</label>
                                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter coupon amount" value="{{old('amount',  isset($coupon->discount_amount) ? $coupon->discount_amount : NULL)}}">
                                    </div>
                                </div> 



                            </div>


                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($coupon->description) ? $coupon->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($coupon->id))
                            <input type="hidden" name="id" value="{{ $coupon->id }}">
                            @endif
                           
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- basic form end -->
        </div>
    </div>
</div>

@section('js')
<script src="{{ asset('assets/admin/js/console/coupon.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#couponForm").submit(function(){

        if($("#title").val()=="")
        {
            $("#err").text("Please enter coupon title");
            $("#title").focus();
            return false;
        }
        if($("#couponCode").val()=="")
        {
            $("#err").text("Please enter coupon code");
            $("#couponCode").focus();
            return false;
        }
        if($("#amount").val()=="")
        {
            $("#err").text("Please enter coupon amount");
            $("#amount").focus();
            return false;
        }
        });
    });
 
</script>

@endsection