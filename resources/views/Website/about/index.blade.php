@extends('Website.layouts.app')
@section('style')
<style>
.craft_story_section {
  padding: 70px 0;
  background: #f8f8f8;
}
.craft_story_section h3 {
  font-weight: 700;
  margin-bottom: 15px;
}
.craft_points ul {
  list-style: none;
  padding: 0;
}
.craft_points ul li {
  margin-bottom: 10px;
  font-size: 16px;
}
</style>

@endsection
@section('content')
<!-- {{-- breadcrumb section start --}} -->
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
                        <li><a href="index-2.html">Home</a></li>
                        <li class="fa fa-angle-double-right"></li>
                        <li>About Us</li>
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
<!-- {{-- breadcrumb section end --}} -->


<!-- section about us page start -->
 <section class="about_us_page_section">
  <!-- container start -->
   <div class="container">
    <!-- row start -->
     <div class="row">
      <!-- col start -->
       <div class="col-lg-12 col-md-12 col-12 col-12">
        <!-- about us page content main div start -->
         <div class="about_us_pg_content_main_div">
            <h1>About Us</h1>
            <p>
                <strong>Gunnu Furniture</strong> is a trusted and growing brand specializing in
                <strong>custom-made furniture, wooden furniture, and complete interior solutions</strong>.
                We combine modern designs with skilled craftsmanship to create stylish, durable,
                and functional furniture that enhances the beauty of every space.
                <br><br>
                Our product range includes home furniture, office furniture, modular furniture,
                and customized wooden work, designed to meet individual preferences and practical needs.
                We focus on premium materials, fine finishing, and attention to detail to deliver
                long-lasting and aesthetically pleasing furniture.
                <br><br>
                Based in <strong>Delhi, India</strong>, Gunnu Furniture is committed to providing
                high-quality, value-driven furniture solutions with a strong focus on customer satisfaction.
                Through innovation, reliability, and craftsmanship, we aim to build a strong
                and trusted presence in the furniture industry.
            </p>
        </div>

        <!-- about us page content main div end -->
       </div>
      <!-- col end -->
     </div>
    <!-- row end -->
   </div>
  <!-- container end -->
 </section>
<!-- section about us page end -->

<section class="craft_story_section">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-lg-6 col-md-12">
        <div class="craft_content">
          <h3>Our Craft. Your Comfort.</h3>
          <p>
            At <strong>Gunnu Furniture</strong>, furniture is not just about wood —
            it’s about comfort, design, and lifestyle. Every piece we create reflects
            thoughtful design, skilled craftsmanship, and a deep understanding of space.
          </p>
          <p>
            From modern homes to professional workspaces, our furniture is designed to
            bring warmth, functionality, and elegance into everyday living.
          </p>
        </div>
      </div>

      <div class="col-lg-6 col-md-12">
        <div class="craft_points">
          <ul>
            <li>✔ Handcrafted with precision & care</li>
            <li>✔ Customized designs for every space</li>
            <li>✔ Premium materials & fine finishing</li>
            <li>✔ Designed for comfort & durability</li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>


<!--serial no-->

<section class="serial_no_section">
  <div class="container">
    <div class="row">

      <div class="col-md-3 col-lg-3 col-12">
        <div class="serial_no_main_div3">
          <div class="serial_no_txt3 position-relative text-center">01</div>
          <div class="serial_no_head_ti">
            <h3>Premium Quality Materials</h3>
            <p>We use high-quality wood and materials to ensure strength, durability, and a premium finish in every piece.</p>
          </div>
          <div class="serial_no_icons">
            <span class="fa fa-cogs"></span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-lg-3 col-12">
        <div class="serial_no_main_div2">
          <div class="serial_no_txt2 position-relative text-center">02</div>
          <div class="serial_no_head_ti">
            <h3>Customized Furniture Solutions</h3>
            <p>Every design is tailored to client requirements, space planning, and personal style preferences.</p>
          </div>
          <div class="serial_no_icons">
            <span class="fa fa-handshake-o"></span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-lg-3 col-12">
        <div class="serial_no_main_div3">
          <div class="serial_no_txt3 position-relative text-center">03</div>
          <div class="serial_no_head_ti">
            <h3>Skilled & Experienced Craftsmanship</h3>
            <p>Our experienced craftsmen focus on precision, detailing, and flawless finishing in every project.</p>
          </div>
          <div class="serial_no_icons">
            <span class="fa fa-users"></span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-lg-3 col-12">
        <div class="serial_no_main_div2">
          <div class="serial_no_txt2 position-relative text-center">04</div>
          <div class="serial_no_head_ti">
            <h3>Reliable Service & Timely Delivery</h3>
            <p>We ensure smooth execution, on-time delivery, and complete customer satisfaction across all projects.</p>
          </div>
          <div class="serial_no_icons">
            <span class="fa fa-truck"></span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!---->
@endsection