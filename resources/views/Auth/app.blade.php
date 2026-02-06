<!DOCTYPE html>
<html lang="en">
<head>    
    @php  $set=setting();  @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
    <meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
    <meta name="author" content="{{$set['name']}}">
    <meta name="robots" content="index, follow">
    <title>{{$set['name']}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('public/uploads/sitesetting/' . $set['favicon'] ) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('public/uploads/sitesetting/' . $set['favicon'] ) }}">
    @include('Auth.style')
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

<body class="account-page bg-white">
   @yield('content')
    @include('Auth.script')  
</body>
</html>
