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
                                <img src="{{ url('public/uploads/sitesetting/' . $set['logo'] ) }}" alt="img">
                                {{-- <a href="index.html" class="login-logo logo-white">
                                    <img src="assets/img/logo-white.svg" alt="Img">
                                </a> --}}
                            </div>
                            <form method="POST" action="{{ route('admin.login.post') }}">
                                @csrf
                                <div class="card">
                                    <div class="card-body p-5">
                                        <div class="login-userheading">
                                            <h3>Sign In</h3>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger"> *</span></label>
                                            <div class="input-group">
                                                <input type="text" value="" name="email"
                                                    class="form-control border-end-0">
                                                <span class="input-group-text border-start-0">
                                                    <i class="ti ti-mail"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password <span class="text-danger">
                                                    *</span></label>
                                            <div class="pass-group">
                                                <input type="password" class="pass-input form-control" name="password">
                                                <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                                            </div>
                                        </div>
                                        <div class="form-login authentication-check">
                                            <div class="row">
                                                <div class="col-12 d-flex align-items-center justify-content-between">
                                                    <div class="custom-control custom-checkbox">
                                                        <label
                                                            class="checkboxs ps-4 mb-0 pb-0 line-height-1 fs-16 text-gray-6">
                                                            <input type="checkbox" class="form-control">
                                                            <span class="checkmarks"></span>Remember me
                                                        </label>
                                                    </div>
                                                    {{-- <div class="text-end">
                                                        <a class="text-orange fs-16 fw-medium"
                                                            href="forgot-password.html">Forgot Password?</a>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-login">
                                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                        </div>
                                        <div class="signinform">
                                            <h4>New on our platform?<a href="{{route('register')}}" class="hover-a"> Create an
                                                    account</a></h4>
                                        </div>                                    
                                        
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
