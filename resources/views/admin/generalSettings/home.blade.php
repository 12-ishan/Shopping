@extends('layout.admin')
@section('content')

<div class="row">
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-12 mt-5 start-form-sec">
                <div class="card">
                    <div class="card-body">
                        <form id="GeneralSettingsForm" method="POST" action="{{ route('update') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @if(isset($generalSettings))
                                @method('PUT')
                            @endif

                            @if(session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif

                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach

                            <div class="row">
                                {{-- <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <input ocation="text" class="form-control" id="type" name="type" placeholder="Enter type" value="{{ old('type', $generalSettings->type ?? '') }}">
                                    </div>
                                </div> --}}
                           
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="metaTitle">Meta Title</label>
                                        <input ocation="text" class="form-control" id="metaTitle" name="metaTitle" placeholder="Enter meta title" value="{{ old('metaTitle', $generalSettings->meta_title ?? '') }}">
                                    </div>
                                </div>
                            

                           
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="metaDescription">Meta Description</label>
                                        <input ocation="text" class="form-control" id="metaDescription" name="metaDescription" placeholder="Enter meta description" value="{{ old('metaDescription', $generalSettings->meta_description ?? '') }}">
                                    </div>
                                </div>
                           

                           
                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="location">Button URL</label>
                                        <input ocation="text" class="form-control" id="buttonUrl" name="buttonUrl" placeholder="Enter button URL" value="{{ old('buttonUrl', $generalSettings->button_url ?? '') }}">
                                    </div>
                                </div>

                                <div class="col-6 mt-5">
                                    <div class="form-group">
                                        <label for="image">Thumbnail</label>
                                        <!-- Removed the 'value' attribute, as it shouldn't be set for file inputs -->
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div>
                                </div>
                                
                                @if(isset($generalSettings->image->name))
                                    <div class="col-12 mt-6">
                                        <div class="upload-image">
                                            <!-- Displaying the uploaded image if it exists -->
                                            <img width="100" height="60" 
                                                src="{{ URL::to('/') }}/uploads/home/{{ $generalSettings->image->name }}" alt="image">
                                        </div>
                                    </div>
                                @endif
                                
                                
                              
                            </div>

                            <div class="row">

                                <div class="col-12 mt-10">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{old('description', isset($GeneralSettings->description) ? $GeneralSettings->description : NULL)}}</textarea>
                                    </div>

                                </div>
                            </div>

                            @if(isset($generalSettings->id))
                            <input type="hidden" name="id" value="{{ $generalSettings->id }}">
                            @endif
                           
                            {{-- <button ocation="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
                            @if(isset($generalSettings))
                            <button ocation="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update</button>
                        @endif --}}

                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update</button>
                           
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
