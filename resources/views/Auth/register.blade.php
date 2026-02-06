@extends('Auth.app')
@section('style')
@endsection
@section('content')
    @php  $set=setting();  @endphp
    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper login-new">
                <div class="row w-100">
                    <div class="col-lg-5 mx-auto">
                        <div class="login-content user-login">
                            <div class="login-logo">
                                {{-- <img src="assets/img/logo.svg" alt="img"> --}}
                                <img src="{{ url('public/uploads/sitesetting/' . $set['logo'] ) }}" alt="img">

                                {{-- <a href="index.html" class="login-logo logo-white">
                                    <img src="assets/img/logo-white.svg" alt="Img">
                                </a> --}}
                            </div>
                            <form method="POST" class="needs-validation"  action="{{ route('register') }}">
                                @csrf <div class="card">
                                    <div class="card-body p-5">
                                        <div class="login-userheading">
                                            <h3>Register</h3>
                                            <h4>Create New {{$set['name']}} Account</h4>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Name <span class="text-danger"> *</span></label>
                                            <div class="input-group">
                                                <input type="text" value="" class="form-control border-end-0"
                                                    name="name">
                                                <span class="input-group-text border-start-0">
                                                    <i class="ti ti-user"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger"> *</span></label>
                                            <div class="input-group">
                                                <input type="text" value="" class="form-control border-end-0"
                                                    name="email">
                                                <span class="input-group-text border-start-0">
                                                    <i class="ti ti-mail"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password <span class="text-danger"> *</span></label>
                                            <div class="pass-group">
                                                <input type="password" class="pass-input form-control" name="password">
                                                <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                                            </div>
                                        </div>
                                        <div class="form-login authentication-check">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="custom-control custom-checkbox justify-content-start">
                                                        <div class="custom-control custom-checkbox">
                                                            <label class="checkboxs ps-4 mb-0 pb-0 line-height-1">
                                                                <input type="checkbox">
                                                                <span class="checkmarks"></span>I agree to the <a
                                                                    href="#" class="text-primary">Terms & Privacy</a>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-login">
                                            <button type="submit" class="btn btn-login">Sign Up</button>
                                        </div>
                                        {{-- <div class="signinform">
                                            <h4>Already have an account ? <a href="signin.html" class="hover-a">Sign In
                                                    Instead</a></h4>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                            <p>Copyright &copy; 2025 {{$set['name']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
