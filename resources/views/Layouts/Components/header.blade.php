 <div class="header">
     <div class="main-header">
         <!-- Logo -->
         <div class="header-left active">
             <a href="{{ url('/') }}" class="logo logo-normal">
                 {{-- <img src="{{ url('assets/img/logo.svg') }}" alt="Img"> --}}
                 @if (!empty($set['logo']))
                     <img src="{{ url('public/uploads/sitesetting/' . $set['logo']) }}" alt="Logo">
                 @else
                     <img src="{{ url('assets/img/logo.svg') }}" alt="Img">
                 @endif

             </a>
             {{-- <a href="index.html" class="logo logo-white">
                 @if (!empty($set['logo']))
                     <img src="{{ url('public/uploads/sitesetting/' . $set['logo']) }}" alt="Logo">
                 @else
                     <img src="{{ url('assets/img/logo-white.svg') }}" alt="Img">
                 @endif

             </a>
             <a href="index.html" class="logo-small">
                 @if (!empty($set['logo']))
                     <img src="{{ url('public/uploads/sitesetting/' . $set['logo']) }}" alt="Logo">
                 @else
                     <img src="{{ url('assets/img/logo-small.png') }}" alt="Img">
                 @endif

             </a> --}}
         </div>
         <a id="mobile_btn" class="mobile_btn" href="#sidebar">
             <span class="bar-icon">
                 <span></span>
                 <span></span>
                 <span></span>
             </span>
         </a>
         <ul class="nav user-menu">
             <li class="nav-item nav-searchinputs">
                 <div class="top-nav-search">
                     <a href="javascript:void(0);" class="responsive-search">
                         <i class="fa fa-search"></i>
                     </a>                    
                 </div>
             </li>

             <li class="nav-item dropdown has-arrow main-drop profile-nav">
                 <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
                     <span class="user-info p-0">
                         <span class="user-letter">
                             @if (!empty(Auth::user()->image) && file_exists(public_path('/uploads/profile/'.Auth::user()->image)))
                                 <img src="{{ url('public/uploads/profile/' . Auth::user()->image) }}"alt="Img" class="img-fluid">
                             @else
                                 <img src="{{ url('assets/img/profiles/avator1.jpg') }}" alt="Img"
                                     class="img-fluid">
                             @endif
                         </span>
                     </span>
                 </a>
                 <div class="dropdown-menu menu-drop-user">
                     <div class="profileset d-flex align-items-center">
                         <span class="user-img me-2">

                             @if (!empty(Auth::user()->image) && file_exists(public_path('/uploads/profile/'.Auth::user()->image)))
                                 <img src="{{ url('public/uploads/profile/' . Auth::user()->image) }}"alt="Img">
                             @else
                                 <img src="{{ url('assets/img/profiles/avator1.jpg') }}" alt="Img">
                             @endif
                         </span>
                         <div>
                             <h6 class="fw-medium">{{ Auth::user()->name }}</h6>
                             <p>
                                 @if (Auth::user()->role == 1)
                                     Admin
                                 @else
                                     User
                                 @endif
                             </p>
                         </div>
                     </div>
                     <a class="dropdown-item" href="{{ route('profile') }}"><i class="ti ti-user-circle me-2"></i>My
                         Profile</a>
                     <a class="dropdown-item" href="{{ route('sitesetting.create') }}"><i
                             class="ti ti-settings-2 me-2"></i>Settings</a>
                     <hr class="my-2"><a class="dropdown-item logout pb-0" href="{{ route('admin.logout') }}"><i 
                             class="ti ti-logout me-2"></i>Logout</a>
                 </div>
             </li>
         </ul> 
         <!-- /Header Menu -->

         <!-- Mobile Menu -->
         <div class="dropdown mobile-user-menu">
             <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                 aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
             <div class="dropdown-menu dropdown-menu-right">
              
                 <a class="dropdown-item" href="{{ route('sitesetting.create') }}">Settings</a>
                 <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
             </div>
         </div>
         <!-- /Mobile Menu -->
     </div>
 </div>
