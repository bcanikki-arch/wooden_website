@extends('Layouts.app')
@section('style')
    <style>
        .accordion-button:after {
            content: none;
        }
    </style>
@endsection
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>Profile</h4>
            <h6>User Profile</h6>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Profile</h4>
        </div>
        <div class="card-body profile-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('updateprofile') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h5 class="mb-2"><i class="ti ti-user text-primary me-1"></i>Basic Information</h5>
                <div class="profile-pic-upload image-field">
                    <div class="profile-pic p-2">
                        
                        @if (!empty($user->image) && file_exists(public_path('uploads/profile/'.$user->image)))
                            <img src="{{ url('public/uploads/profile/' . $user->image) }}" alt=""
                                class=" object-fit-cover h-100 rounded-1">
                        @else

                            <img src="{{ url('assets/img/users/user-49.png') }}" alt=""
                                class="object-fit-cover h-100 rounded-1">
                        @endif

                        <button type="button" class="close rounded-1">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="mb-3">
                        <div class="image-upload mb-0 d-inline-flex">
                            <input type="file" name="image">
                            <div class="btn btn-primary fs-13">Change Image</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label">Full Name<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name ?? '' }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label>Email<span class="text-danger ms-1">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email ?? '' }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label">Phone Number<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="mobile" value="{{ $user->mobile ?? '' }}" class="form-control">
                        </div>
                    </div>                  
                 
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary shadow-none">Save</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
