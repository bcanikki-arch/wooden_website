<!DOCTYPE html>
<html lang="en" data-layout-mode="light_mode" >

<head>
    @php  $set=setting();  @endphp
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
    <meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
    <meta name="author" content="{{ $set['name'] }}">
    <meta name="robots" content="index, follow">
    <link rel="shortcut icon" href="{{ url('public/uploads/sitesetting/' . $set['favicon'] ) }}">
    <title>{{ $set['name'] }}</title>
    @include('Layouts.Components.style')
    @yield('style')
    <style>    
    :root {
        --primary-color:<?=$set['color'];?>;
        --bg-primary:<?=$set['background_color'];?> ;
    }
    .btn-primary {
        background-color:  var(--primary-color) ;
        color :#fff;
    }
     .bg-primary {
        background-color:  var(--bg-primary) !important ;
    }
</style>
</head>
<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <div class="main-wrapper">
        @include('Layouts.Components.header')
        @include('Layouts.Components.sidebar')
        <div class="page-wrapper">
            <div class="content">
                @yield('content')
            </div>
            @include('Layouts.Components.footer')
        </div>
    </div>
    @include('Layouts.Components.model')
    @include('Layouts.Components.script')
    @yield('script')
</body>

</html>
