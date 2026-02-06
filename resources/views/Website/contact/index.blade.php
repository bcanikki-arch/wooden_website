@extends('Website.layouts.app')
<!-- @php  $set=setting();  @endphp -->
@section('content')
<!-- {{-- breadcrumb section end --}} -->
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
                            <li>Contact Us</li>
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
    <div class="contact_page_sec">
        <div class="container">
            <div class="row">

                <!-- col -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="left_contact_frm">

                        <h1 class="modal_ti text-center">Post Your requirement </h1>
                        <form method="POST" class="contact-form" autocomplete="off" onsubmit="return submitUserForm();">

                            <div class="input-group mb-3">
                                <span class="input-group-text fa fa-user"></span>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name*"
                                    minlength="5"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                    required="">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text fa fa-user"></span>
                                <input type="text" name="last" id="last" class="form-control" placeholder="Surname*"
                                    minlength="5"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z. ]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                    required="">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text fa fa-phone"></span>
                                <input type="tel" placeholder="Enter 10 Digit Mobile Number" value="+91"
                                    class="form-control" name="phone" onkeyup="PhoneV()" id="phone" required=""
                                    oninput="this.value = this.value.replace(/[^0-9.+]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                    minlength="13" maxlength="13">
                            </div>
                            <div id="phoneval22"></div>


                            <div class="input-group mb-3">
                                <span class="input-group-text fa fa-envelope"></span>
                                <input type="text" class="form-control" name="email" placeholder="Email ID*"
                                    required="">
                            </div>



                            <div class="input-group mb-3">
                                <span class="input-group-text fa fa-commenting"></span>
                                <textarea name="message" class="form-control" placeholder="Write Your Requirement*"
                                    onkeyup="myFunction()" id="youo" minlength="30"></textarea>
                            </div>
                            <div id="warden_id"></div>


                            <div class="g-recaptcha " data-sitekey="6LfSZlsrAAAAAGNEus7CKnph0yMem_Sh1BX4-Hl_"
                                data-callback="verifyCaptcha">
                                <div style="width: 304px; height: 78px;">
                                    <div><iframe title="reCAPTCHA" width="304" height="78" role="presentation"
                                            name="a-pbtuasryazub" frameborder="0" scrolling="no"
                                            sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation"
                                            src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LfSZlsrAAAAAGNEus7CKnph0yMem_Sh1BX4-Hl_&amp;co=aHR0cHM6Ly93d3cubW9oYW53b29kZW5kb29ycy5jb206NDQz&amp;hl=en&amp;v=gYdqkxiddE5aXrugNbBbKgtN&amp;size=normal&amp;anchor-ms=20000&amp;execute-ms=30000&amp;cb=my7smyhl1i5p"></iframe>
                                    </div><textarea id="g-recaptcha-response" name="g-recaptcha-response"
                                        class="g-recaptcha-response"
                                        style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                                </div>
                            </div>
                            <div id="g-recaptcha-error"></div>

                            <div class="input_div">
                                <div class="form-group">
                                    <center><input type="submit" name="SubmitEmail" value="Send" class="btn mt-2"
                                            id="search"></center>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
                <!-- col end -->

                <!-- col -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="contact_addrees_right">
                        <h2>Contact Us </h2>

                        <!--  -->
                        <div class="conatct_main_div_flx">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="contact_page_num_div">


                                        <a href="tel: +91-9811253395">+91-6376471866</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->



                        <!--  -->
                        <div class="conatct_main_div_flx">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="contact_page_num_div">

                                        <a href="mailto:gunnufurniture@gmail.com<"> gunnufurniture@gmail.com<</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->


                        <!--  -->
                        <div class="conatct_main_div_flx">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="contact_page_num_div">
                                        <p><b>Address:-</b> Front Shiv Mandir, Vatika Rd, near K.D. School, Shyam Vatika, Chokhi Dhani, Sanganer, Jaipur, Asawala, Rajasthan 303905</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->



                        <!--  -->
                        <!-- <div class="conatct_main_div_flx">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bx bxs-layer"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="contact_page_num_div">


                                        <p><b>GST No.:-</b> 07CQVPM3123R1Z0</p>
                                        <p><b>PAN / Income Tax No. :-</b> CQVPM3123R</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!--  -->

                        <!--  -->
                    </div>
                    <b>Location</b>
                    <p><iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113908.55030280615!2d75.6845178323252!3d26.85133043168956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396dc9fd426a0be7%3A0x889ba208d4562f6a!2sGunnu%20Furniture%20Steel%20Railing%20%26%20Aluminium!5e0!3m2!1sen!2sin!4v1770371633572!5m2!1sen!2sin"
                            width="100%" height="auto" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></p>

                </div>
                <!-- col end -->

            </div>
        </div>
    </div>
    <!---->
@endsection
@section('script')
@endsection