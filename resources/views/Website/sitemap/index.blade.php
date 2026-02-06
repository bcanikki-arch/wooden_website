@extends('Website.layouts.app')

@section('content')
<section class="breadcrumb_section">
    <!-- {{-- container start --}} -->
    <div class="container">
        <!-- {{-- row start --}} -->
        <div class="row">
            <!-- {{-- col start --}} -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <!-- {{-- breadcrumb content main div start --}} -->
                <div class="breadcrumb_content_main_div">
                    <!-- {{-- breadcrumb list start --}} -->
                    <ul>
                        <li><a href="index">Home</a></li>
                        <li class="fa fa-angle-double-right"></li>
                        <li>Sitemap</li>
                    </ul>
                    <!-- {{-- breadcrumb list end --}} -->
                </div>
                <!-- {{-- breadcrumb content main div end --}} -->
            </div>
            <!-- {{-- col end --}} -->
        </div>
        <!-- {{-- row end --}} -->
    </div>
    <!-- {{-- container end --}} -->
</section>
<section class="site_map_navi">
    <div class="container">
        
    <!--  -->
<div class="row">
    <div class="col-lg-12">
        <div class="site_map_nav">
            <h1>Usefull Links</h1>
            <a href="index">Home</a>
            <a href="about-us">About Us</a>
            <a href="img/mohandoor.pdf" target="_blank">Catalogue</a>
            <!--<a href="gallery">Gallery</a>-->
            <a href="contact-us">Contact Us</a>
        </div>
    </div>
</div>
    <!--  -->
    </div>
</section>
<section class="sitemap_section">
    <div class="container">

        <div class="sitemap_head_ti">
            <h2>Doors</h2>
        </div>
        <div class="row">
          
          
            <div class="col-lg-6">
                <div class="sitemap_ul_div">
                    <ul>
                <li><a href="teak-wood-doors">Teak wood doors</a></li>
        <li><a href="synthetic-doors">synthetic doors</a></li>
        <li><a href="laminate-grooving-doors">Laminate Grooving Doors</a></li>
        <li><a href="laminate-profile">laminate profile doors</a></li>
        <li><a href="veneer-doors"> Veneer doors</a></li>
        <li><a href="pine-wood-doors">pine wood doors</a></li>


                </ul></div>
            </div>
         
         
             <div class="col-lg-6">
                <div class="sitemap_ul_div">
                <ul>
               
         <li><a href="3d-teak-wood-doors">3D Teak Wood Doors</a></li>
         <li><a href="solid-teak-wood-doors">Solid Teak Wood Doors</a></li>
         <li><a href="hdhmr-doors">HDHMR Doors</a></li>
         <li><a href="teak-engineered-door">Teak engineered door</a></li>
         <li><a href="hdhmr-panel-door">HDHMR panel door</a></li>
         <li><a href="laminate-door">Laminate door</a></li>

</ul>
                </div>
            </div>
           

        </div>
    </div>
</section>
@endsection