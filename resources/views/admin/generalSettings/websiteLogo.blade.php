@extends('layout.admin')
@section('content')

<div class="row">
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-12 mt-5 start-form-sec">
                <div class="card">
                    <div class="card-body">
                        <form id="GeneralSettingsForm" method="POST" action="{{ route('updateLogo') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @if(isset($websiteLogo))
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
                                        <label for="image">Thumbnail</label>
                                        <!-- Removed the 'value' attribute, as it shouldn't be set for file inputs -->
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div>
                                </div>
                                
                                @if(isset($websiteLogo->image->name))
                                    <div class="col-12 mt-6">
                                        <div class="upload-image">
                                            <!-- Displaying the uploaded image if it exists -->
                                            <img width="100" height="60" 
                                                src="{{ URL::to('/') }}/uploads/home/{{ $websiteLogo->image->name }}" alt="image">
                                        </div>
                                    </div>
                                @endif
                                
                                
                              
                            </div>

                           

                            @if(isset($websiteLogo->id))
                            <input type="hidden" name="id" value="{{ $websiteLogo->id }}">
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
