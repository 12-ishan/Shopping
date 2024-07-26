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

                        <form id="productForm" method="post" action="@if(isset($editStatus)){{ route('product.update', $product->id) }} @else {{ route('product.store')}}@endif" enctype='multipart/form-data'>

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
                                        <label for="categoryId">Product Category</label>
                                        <select class="form-control selectpicker" id="categoryId" name="categoryId" data-live-search="true">
                                            <option value="">Select Category</option>
                                            @if(isset($productCategory))
                                            @foreach($productCategory as $value)
                                            <option value="{{$value->id}}" @if (old('categoryId', isset($product->category_id) ? $product->category_id : NULL) == $value->id) selected="selected" @endif>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" value="{{old('name',  isset($product->name) ? $product->name : NULL)}}">
                                    </div>
                                </div>

                               

                                <div class="col-12 mt-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" class="form-control" id="price" name="price" placeholder="Enter product price" value="{{old('price',  isset($product->price) ? $product->price : NULL)}}">
                                    </div>
                                </div>

                                {{-- <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <label for="metaDescription">Meta Description</label>
                                        <input type="text" class="form-control" id="metaDescription" name="metaDescription" placeholder="Enter Meta Description" value="{{old('metaDescription',  isset($program->metaDescription) ? $program->metaDescription : NULL)}}">
                                    </div>
                                </div> --}}

                            </div>

                            <div class="row">


                                <div class="col-12 mt-6">
                                    <div class="form-group">
                                        <label for="image">Thumbnail</label>
                                        <input type="file" id="image" name="image" class="form-control" value="{{old('image',  isset($product->image->name) ? $product->image->name : NULL)}}">
                                    </div>
                                </div>


                                @if(isset($product->image->name))
                                <div class="col-12 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60" src=" {{ URL::to('/') }}/uploads/productImage/{{ $product->image->name }}" alt="image">
                                    </div>
                                </div>
                                @endif

                            </div>

                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($product->description) ? $product->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($product->id))
                            <input type="hidden" name="id" value="{{ $product->id }}">
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
<script src="{{ asset('assets/admin/js/console/product.js') }}"></script>
@append

<script type="text/javascript">

$(document).ready(function(){

    $("#productForm").submit(function(){

        if($("#categoryId").val()=="")
        {
            $("#err").text("Please select product category");
            $("#categoryId").focus();
            return false;
        }
        if($("#name").val()=="")
        {
            $("#err").text("Please enter product name");
            $("#name").focus();
            return false;
        }
        if($("#price").val()=="")
        {
            $("#err").text("Please enter product price");
            $("#price").focus();
            return false;
        }
        if($("#image").val()=="")
        {
            $("#err").text("Please select image");
            $("#image").focus();
            return false;
        }
        });
    });
 
</script>

@endsection