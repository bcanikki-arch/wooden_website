<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo active">
        <a href="{{ url('/') }}" class="logo logo-normal">
            <img src="{{ url('public/uploads/sitesetting/' . $set['logo']) }}" alt="Logo">

        </a>
        {{-- <a href="index.html" class="logo logo-white">
            <img src="{{ url('public/uploads/sitesetting/' . $set['logo']) }}" alt="Logo">


        </a>
        <a href="index.html" class="logo-small">
            <img src="{{ url('public/uploads/sitesetting/' . $set['logo']) }}" alt="Logo">

        </a> --}}
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
    </div>
    <!-- /Logo -->
    <div class="modern-profile p-3 pb-0">
        <div class="text-center rounded bg-light p-3 mb-4 user-profile">
            <div class="avatar avatar-lg online mb-3">
                <img src="{{ url('assets/img/customer/customer15.jpg') }}" alt="Img"
                    class="img-fluid rounded-circle">
            </div>
            <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
            <p class="fs-12 mb-0">System Admin</p>
        </div>
        <div class="sidebar-nav mb-3">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a>
                </li>
                <li class="nav-item"><a class="nav-link border-0" href="chat.html">Chats</a></li>
                <li class="nav-item"><a class="nav-link border-0" href="email.html">Inbox</a></li>
            </ul>
        </div>
    </div>
    <div class="sidebar-header p-3 pb-0 pt-2">
        <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
            <div class="avatar avatar-md onlin">
                <img src="{{ url('assets/img/customer/customer15.jpg') }}" alt="Img"
                    class="img-fluid rounded-circle">
            </div>
            <div class="text-start sidebar-profile-info ms-2">
                <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
                <p class="fs-12">System Admin</p>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between menu-item mb-3">
            <div>
                <a href="index.html" class="btn btn-sm btn-icon bg-light">
                    <i class="ti ti-layout-grid-remove"></i>
                </a>
            </div>
            <div>
                <a href="chat.html" class="btn btn-sm btn-icon bg-light">
                    <i class="ti ti-brand-hipchat"></i>
                </a>
            </div>
            <div>
                <a href="email.html" class="btn btn-sm btn-icon bg-light position-relative">
                    <i class="ti ti-message"></i>
                </a>
            </div>
            <div class="notification-item">
                <a href="activities.html" class="btn btn-sm btn-icon bg-light position-relative">
                    <i class="ti ti-bell"></i>
                    <span class="notification-status-dot"></span>
                </a>
            </div>
            <div class="me-0">
                <a href="general-settings.html" class="btn btn-sm btn-icon bg-light">
                    <i class="ti ti-settings"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Dashboard</h6>
                    <ul>
                        <li><a href="{{ route('dashboard') }}"><i class="ti ti-layout-grid fs-16 me-2"></i><span>Dashbard</span></a> </li>
                    </ul>
                </li>


                <li class="submenu-open">
                    <h6 class="submenu-hdr">Inventory</h6>

                    <ul>
                        <li><a href="{{ route('category') }}"><i class="ti ti-list-details fs-16 me-2"></i><span>Category</span></a></li>
                        <!-- <li><a href="{{ route('subcategory') }}"><i class="ti ti-carousel-vertical fs-16 me-2"></i><span>Sub Category</span></a></li> -->
                        <!-- <li><a href="{{ route('brand') }}"><i class="ti ti-triangles fs-16 me-2"></i><span>Brands</span></a></li>
                        <li><a href="{{ route('producttype') }}"><i class="ti ti-checklist fs-16 me-2"></i><span>Product Type</span></a></li> -->
                        <li><a href="{{ route('product') }}"><i class="ti ti-table fs-16 me-2"></i><span> Product</span></a></li>
                        <li><a href="{{ route('product.create') }}"><i class="ti ti-table-plus fs-16 me-2"></i><span>Create Product</span></a></li>
                        <li><a href="{{ route('service') }}"><i class="ti ti-stack-3 fs-16 me-2"></i><span> Our Services</span></a></li>
                    </ul>
                </li>
                <!-- <li class="submenu-open">
                    <h6 class="submenu-hdr">Peoples</h6>
                    <ul>
                        <li><a href="{{ route('customer') }}"><i class="ti ti-users-group fs-16 me-2"></i><span>Customers</span></a></li>
                        <li><a href="suppliers.html"><i class="ti ti-user-dollar fs-16 me-2"></i><span>Suppliers</span></a></li>
                    <li><a href="store-list.html"><i class="ti ti-home-bolt fs-16 me-2"></i><span>Stores</span></a></li>
                    <li><a href="warehouse.html"><i class="ti ti-archive fs-16 me-2"></i><span>Warehouses</span></a>
                    </ul>
                </li> -->
                <!-- <li class="submenu-open">
                    <h6 class="submenu-hdr">Sales</h6>
                    <ul>
                        <li><a href="{{route('sales.index')}}"><i class="ti ti-layout-grid fs-16 me-2"></i><span>Sales</span><span></span></a></li>
                        <li><a href="{{ route('invoice.index') }}"><i class="ti ti-file-invoice fs-16 me-2"></i><span>Invoices</span></a></li>
                    </ul>
                </li> -->
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Settings</h6>
                    <ul>
                        <li><a href="{{ route('testimonial') }}"><i class="ti ti-settings fs-16 me-2"></i><span>Testimonial</span></a> </li>
                        <li><a href="{{ route('social') }}"><i class="ti ti-world fs-16 me-2"></i><span>Social Settings</span></a></li>
                        <li><a href="{{ route('sitesetting.create') }}"><i class="ti ti-world fs-16 me-2"></i><span>Website Settings</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>