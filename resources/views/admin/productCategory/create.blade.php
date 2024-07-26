@extends('layout.admin')
@section('content')

<div class="row">
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <!-- basic form start -->
            <div class="col-12 mt-5 start-form-sec">
                <div class="card">
                    <div class="card-body">
                        <p id="err" style="color:red;"></p>
                        <form id="productCategoryForm" method="post" action="@if(isset($editStatus)){{ route('product-category.update', $productCategory->id) }} @else {{ route('product-category.store')}}@endif" enctype='multipart/form-data'>
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
                                        <label for="title">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter product category" value="{{old('name',  isset($productCategory->name) ? $productCategory->name : NULL)}}">
                                    </div>
                                </div>

                                {{-- <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="name">Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div> --}}

                                {{-- @if(isset($blog->image->name))
                                <div class="col-12 mt-6">
                                    <div class="upload-image">
                                        <img width="100" height="60" src=" {{ URL::to('/') }}/uploads/blogImage/{{ $blog->image->name }}" alt="image">
                                    </div>
                                </div>
                                @endif --}}

                                {{-- <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="publishedBy">Published By</label>
                                        <input type="text" class="form-control" id="publishedBy" name="publishedBy" placeholder="Enter publisher name" value="{{old('publishedBy',  isset($blog->published_by) ? $blog->published_by : NULL)}}">
                                    </div>
                                </div> --}}

                                {{-- <div class="col-6 mt-5">
                                    <label for="publishedDate">Published On</label>
                                    <div class="input-group">
                                        <input type="text" name="publishedDate" placeholder="Enter publish date" id="publishedDate" class="form-control" value="{{old('publishedDate',  isset($blog->published_on) ? $blog->published_on : NULL)}}">
                                    </div>
                                </div> --}}

                              

                                    <div class="col-12 mt-10">
    
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($productCategory->description) ? $productCategory->description : NULL)}}</textarea>
                                        </div>
    
                                    </div>
                            
                            </div>
                            @if(isset($productCategory->id))
                            <input type="hidden" name="id" value="{{ $productCategory->id }}">
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
<script src="{{ asset('assets/admin/js/console/productCategory.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){

$("#productCategoryForm").submit(function(){

    if($("#name").val()=="")
    {
        $("#err").text("Please enter product category name ");
        $("#name").focus();
        return false;
    }
    });
});

</script>
@append

@endsection
