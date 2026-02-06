<!DOCTYPE html>
<html lang="en">
   @php  $set=setting();  @endphp

<!-- Mirrored from bhardwajarchitects.in/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 09 Jan 2026 12:35:25 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> AR | Home</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('assets/images/favicons/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('public/uploads/sitesetting/' . $set['logo']) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('public/uploads/sitesetting/' . $set['logo']) }}">
    <meta name="description" content="Bhardwaj Architectss">
    @include('Website.layouts.Components.style')
    @yield('style')
</head>

<body>
    <!--<div class="preloader">-->
    <!--    <img src="{{ url('public/uploads/sitesetting/' . $set['logo']) }}" class="logoimg">-->
    <!--</div>-->
    <div class="page-wrappers">
        @include('Website.layouts.Components.header')
        @yield('content')
    </div>
    @include('Website.layouts.Components.footer')

    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>

        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"></span>
            <div class="logo-box">
                <a href="http://localhost/gtech" aria-label="logo image"><img src="assetss/images/logo.png" class="logoimg" alt="" /></a>
            </div>
            <div class="mobile-nav__container"></div>
            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="pylon-icon-email1"></i>
                    <a href="mailto:hey@gtechlogicsindia.com">hey@gtechlogicsindia.com</a>
                </li>
                <li>
                </li>
            </ul>
            <div class="mobile-nav__top">
                <div class="mobile-nav__social">
                    <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
                    <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#" aria-label="instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>

        <div class="search-popup__content">
            <form action="#">
                <label for="search" class="sr-only">search here</label>
                <input type="text" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    <a href="https://wa.me/918700683138" target="_blank" class="whatsapp-btn">
        <img src="{{url('assetss/images/favicons/whatsapp.png')}}" alt="WhatsApp" style="height:65px;width:65px" />
    </a>
    @include('Website.layouts.Components.script')
    @yield('script')
</body>

</html>