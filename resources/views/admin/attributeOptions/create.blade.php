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

                        <form id="productForm" method="post" action="@if(isset($editStatus)){{ route('attribute-options.update', $options->id) }} @else {{ route('attribute-options.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="attributeId">Attribute</label>
                                        <select class="form-control selectpicker" id="attributeId" name="attributeId" data-live-search="true">
                                            <option value="">Select Attribute</option>
                                            @if(isset($productAttribute))
                                            @foreach($productAttribute as $value)
                                            <option value="{{$value->id}}" @if (old('attributeId', isset($options->attribute_id) ? $options->attribute_id : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="value">Value</label>
                                        <input type="text" class="form-control" id="value" name="value" placeholder="Enter option value" value="{{old('value',  isset($options->value) ? $options->value : NULL)}}">
                                    </div>
                                </div>
                            </div>

                          

                           

                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($options->description) ? $options->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($options->id))
                            <input type="hidden" name="id" value="{{ $options->id }}">
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
<script src="{{ asset('assets/admin/js/console/attributeOptions.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#productForm").submit(function(){

        if($("#attributeId").val()=="")
        {
            $("#err").text("Please select product attribute");
            $("#attributeId").focus();
            return false;
        }
        if($("#value").val()=="")
        {
            $("#err").text("Please enter product attribute value");
            $("#value").focus();
            return false;
        }
       
        });

   
    });
 
</script>

@endsection