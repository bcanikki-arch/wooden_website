@extends('Website.layouts.app')

@section('style')
<style>
    @media (max-width: 767px) {
        .brand-slider {
            flex-wrap: nowrap;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
        }

        .brand-slider .brandimg {
            flex: 0 0 70%;
            scroll-snap-align: center;
            text-align: center;
        }

        .brand-slider::-webkit-scrollbar {
            display: none;
        }
    }

    /* .swiper { width: 100%; padding-top: 20px; padding-bottom: 20px; }
  .swiper-slide {
    background-position: center;
    background-size: cover;
    width: 400px;
    height: 600px;
    transition: 0.3s;
    transform: scale(0.8);
  }

  .swiper-slide-active {
    filter: blur(0);
    transform: scale(1.0); 
    z-index: 10;
  }
  .swiper-slide img { width: 100%; height: 100%; object-fit: cover; border-radius: 15px; } */
    /* @media (min-width: 768px) {
    .swiper-slide {
      width: 500px; 
      height: 400px;
    }
  }
  @media (max-width: 480px) {
  .swiper-slide {
    width: 400px; 
    height: 320px;
  }
  
  .swiper-button-next, .swiper-button-prev {
    transform: scale(0.7);
    color: #fff;
  }

  .slide-text {
    font-size: 14px;
  }
} */



    /* FULL SCREEN SECTION */
    .unique-arch-section {
        padding: 0;
        overflow: hidden;
    }

    /* SLIDER FULL HEIGHT */
    .unique-arch-slider {
        height: 100vh;
        position: relative;
    }

    /* SLIDE CENTERING */
    .unique-arch-slider .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* IMAGE FRAME */
    .unique-arch-cardsss {
        width: 165%;
        max-width: 1200px;
        height: 66vh;
        overflow: hidden;
        border-radius: 20px;
        transition: all 0.6s ease;
    }

    /* IMAGE */
    .unique-arch-cardsss img {
        width: 84%;
        height: 99%;
        object-fit: cover;
        margin-left: 55px;
    }

    /* ACTIVE SLIDE */
    .swiper-slide-active .unique-arch-cardsss {
        transform: scale(1.25);
        z-index: 10;
    }

    /* SIDE SLIDES */
    .swiper-slide-prev .unique-arch-cardsss,
    .swiper-slide-next .unique-arch-cardsss {
        transform: scale(0.9);
        opacity: 0.7;
    }

    /* ARROWS */
    .unique-arch-prev,
    .unique-arch-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 55px;
        height: 55px;
        background: #fff;
        border-radius: 50%;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 20;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .unique-arch-cardsss {
            max-width: 700px;
            height: 70vh;
        }

        .swiper-slide-active .unique-arch-cardsss {
            transform: scale(1.1);
        }

        .unique-arch-cardsss img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin-left: 0px;

        }

        .unique-arch-slider,
        .swiper-slide {
            height: 100vh;
        }


    }

    @media (max-width: 576px) {


        .unique-arch-cardsss {
            max-width: 100%;
            height: 100vh;
        }

        .unique-arch-slider,
        .swiper-slide {
            height: 100vh;
        }



        .swiper-slide-active .unique-arch-cardsss {
            transform: scale(1);
        }

        .unique-arch-cardsss img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin-left: 0px;
        }
    }
    .qodef-e-character {
    display: inline-block;
    opacity: 0;
    transform: translateY(30px); /* Neeche se start hoga */
    transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 0.6s;
    white-space: pre; /* Spaces ko maintain rakhne ke liye */
}

/* Jab 'animate' class trigger hogi */
.animate .qodef-e-character {
    opacity: 1;
    transform: translateY(0);
}
.char-animate span {
    opacity: 0;
    transform: translateY(14px);
    display: inline-block;
    transition: opacity 0.45s ease, transform 0.45s ease;
}

.char-animate.animate span {
    opacity: 1;
    transform: translateY(18px);
    transition: opacity 0.5s cubic-bezier(.25,.46,.45,.94),
                transform 0.5s cubic-bezier(.25,.46,.45,.94);
}



</style>
@endsection
@section('content')

<section class="blog-home pt-1">
    <div class="prime-slider-container">
        <div class="slideshow-wrapper">
            <input type="radio" name="slider" id="slide1" checked>
            <input type="radio" name="slider" id="slide2">
            <input type="radio" name="slider" id="slide3">
            <input type="radio" name="slider" id="slide4">
            <ul class="slideshow-items">
                <li class="slideshow-item" style="background-image: url('https://slowpoke.uenicdn.com/5bd9e83e-da8e-4dc1-9d82-5be8de9f9bce/c1600_a/image/upload/v1567585374/5e97a3e8766248279a37e8c3c5915992.jpg');">
                    <div class="overlay"></div>
                    <div class="slide-content-wrapper">
                        <div class="main-titles">
                            <h1 class="text-white  ">Architecture is our passion, design is our art</h1>
                        </div>
                        <div class="slider-excerpt ">
                            <p>Architects offer design and planning services for buildings, landscapes, and interiors.</p>
                        </div>
                        <div class="">
                            <div class="cta-button-wrapper  delay-400">
                                <a href="{{route('website.appointment')}}" class=" cta-button buttonhero">
                                    <span class="button-text">Request An Appointment</span>

                                </a>
                            </div>
                            <div class="cta-button-wrapper  delay-400 ">
                                <a href="{{route('website.project')}}" class="cta-button buttonhero">
                                    <span class="button-text"> View Our Portfolio </span>
                                </a>
                            </div>
                        </div>
                    </div>

                </li>

                <li class="slideshow-item" style="background-image: url('assetss/images/about/23.jpg');">
                    <div class="overlay"></div>
                    <div class="slide-content-wrapper">
                        <div class="main-titles">
                            <h1 class="text-white ">Building your vision, creating reality</h1>
                        </div>
                        <div class="slider-excerpt ">
                            <p>Architects can manage the construction process from start to finish, overseeing contractors and ensuring that the project stays on schedule.</p>
                        </div>
                        <div class="">
                            <div class="cta-button-wrapper  delay-400">
                                <a href="{{route('website.appointment')}}" class=" cta-button buttonhero">
                                    <span class="button-text">Request An Appointment</span>

                                </a>
                            </div>
                            <div class="cta-button-wrapper  delay-400 ">
                                <a href="{{route('website.project')}}" class="cta-button buttonhero">
                                    <span class="button-text"> View Our Portfolio </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="slideshow-item" style="background-image: url('https://slowpoke.uenicdn.com/5bd9e83e-da8e-4dc1-9d82-5be8de9f9bce/c1600_a/image/upload/v1567585374/5e97a3e8766248279a37e8c3c5915992.jpg');">
                    <div class="overlay"></div>
                    <div class="slide-content-wrapper">
                        <div class="main-titles">
                            <h1 class="text-white ">Designing spaces, creating experiences</h1>
                        </div>
                        <div class="slider-excerpt ">
                            <p>Many architects specialize in sustainable design, incorporating environmentally friendly features into buildings.</p>
                        </div>
                        <div class="">
                            <div class="cta-button-wrapper  delay-400">
                                <a href="{{route('website.appointment')}}" class=" cta-button buttonhero">
                                    <span class="button-text">Request An Appointment</span>

                                </a>
                            </div>
                            <div class="cta-button-wrapper  delay-400 ">
                                <a href="{{route('website.project')}}" class="cta-button buttonhero">
                                    <span class="button-text"> View Our Portfolio </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="slideshow-item" style="background-image: url('assetss/images/about/23.jpg');">
                    <div class="overlay"></div>
                    <div class="slide-content-wrapper">
                        <div class="main-titles">
                            <h1 class="text-white ">Transforming ideas into structures</h1>
                        </div>
                        <div class="slider-excerpt ">
                            <p>Architects can conduct site analysis and evaluation to determine the best location for a building or development project.</p>
                        </div>
                        <div class="">
                            <div class="cta-button-wrapper  delay-400">
                                <a href="{{route('website.appointment')}}" class=" cta-button buttonhero">
                                    <span class="button-text">Request An Appointment</span>

                                </a>
                            </div>
                            <div class="cta-button-wrapper  delay-400 ">
                                <a href="{{route('website.project')}}" class="cta-button buttonhero">
                                    <span class="button-text"> View Our Portfolio </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="slideshow-nav">
                <label for="slide1" class="dot" title="Slide 1"></label>
                <label for="slide2" class="dot" title="Slide 2"></label>
                <label for="slide3" class="dot" title="Slide 3"></label>
                <label for="slide4" class="dot" title="Slide 4"></label>
            </div>

        </div>

        <div class="social-icon-wrapper">
            <a href="https://www.instagram.com/bhardwaj_architects/?igshid=OGQ5ZDc2ODk2ZA%3D%3D/" target="_blank" title="Instagram" class=" text-white">
                <svg aria-hidden="true" viewBox="0 0 448 512">
                    <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                </svg>
            </a>
            <a href="https://www.youtube.com/@bhardwajarchitects75" target="_blank" title="Youtube" class=" text-white">
                <svg aria-hidden="true" viewBox="0 0 576 512">
                    <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path>
                </svg>
            </a>
            <a href="https://www.facebook.com/Bhardwajarchitects?mibextid=LQQJ4d" target="_blank" title="Facebook" class=" text-white">
                <svg aria-hidden="true" viewBox="0 0 320 512" width="30" height="30" fill="white">
                    <path d="M279.14 288l14.22-92.66h-88.91V127.75c0-25.35 12.42-50.06 52.24-50.06H293V6.26S259.56 0 225.36 0c-73.1 0-121.15 44.38-121.15 124.72v70.62H22.89V288h81.32v224h100.2V288z" />
                </svg>
            </a>

            <!-- WhatsApp -->
            <a href="https://wa.me/919876543210" target="_blank" title="WhatsApp" class="text-white">
                <svg aria-hidden="true" viewBox="0 0 448 512" width="30" height="30" fill="white">
                    <path d="M380.9 97.1C339-12.2 219.2-30.3 135.7 22.8c-82.1 51.9-109.8 160-62 244l-26.6 97.6 100.2-26.3c76 40.3 171.6 22.8 229.2-42.1 63.1-70.6 73.7-173.5 27.7-251zM224.1 338.3c-26.4 0-52.3-6.9-74.9-19.9l-5.3-3.2-44.3 11.6 11.8-43.4-3.4-5.4c-13.5-21.5-20.7-46.2-20.7-71.7 0-74.7 60.8-135.5 135.5-135.5 36.2 0 70.3 14.1 95.9 39.7s39.7 59.7 39.7 95.9c-.1 74.8-60.9 135.6-135.3 135.6z" />
                </svg>
            </a>
        </div>


    </div>
</section>
<section class="info-section pt-0">
    <div class="container page-wrappers  pl-2 pr-2">
        <div class="animated-title-wrapper">
            <h1 class="section-title  show  headerofmap 
        char-animate">DESIGNING ACROSS BORDERS</h1>
        </div>
        <div class="content-area">
            <div class="stats-column">
                <div class="map-counter">
                    <div class="map-counter-title ">LOCAL PROJECTS</div>
                    <div class="map-counter-number-wrapper milestone-counter">
                        <span class="map-counter-number" data-num="12">12</span>
                        <span class="map-counter-number-suffix">K</span>
                    </div>
                </div>

                <div class="map-counter">
                    <div class="map-counter-title ">INTERNATIONAL PROJECTS</div>
                    <div class="map-counter-number-wrapper milestone-counter">
                        <span class="map-counter-number" data-num="75">75</span>
                        <span class="map-counter-number-suffix"></span>
                    </div>
                </div>

                <div class="map-counter">
                    <div class="map-counter-title ">CONSTRUCTION PROJECTS</div>
                    <div class="map-counter-number-wrapper milestone-counter">
                        <span class="map-counter-number" data-num="100">1,623</span>
                        <span class="map-counter-number-suffix"></span>
                    </div>
                </div>
            </div>

            <div id="chartdiv" class="map-column"></div>
        </div>

    </div>
</section>
<section class="cta-section " style="background-image: url('assetss/images/services/imgi_13_16.jpg');">
    <div class="cta-overlay"></div>
    <div class="cta-container">

        <div class="cta-heading-group animated-element">
            <h1 class="cta-main-heading">
                Have a project in mind?
            </h1>
        </div>

        <div class="cta-heading-group animated-element delay-200">
            <h2 class="cta-sub-heading">
                Do not hesitate to say
                <span class="typeout-text">Hello</span>
                <span class="typed-cursor">|</span>
            </h2>
        </div>

        <div class="cta-button-wrapper animated-element delay-400">
            <a href="{{route('website.appointment')}}" class="cta-button">
                <span class="button-text">Request An Appointment</span>
                <span class="button-icon-box">
                    <svg viewBox="1.25 1.25 7 7" aria-hidden="true" width="7px" height="7px">
                        <polygon points="1.25,1.25 1.25,2.25 6.543,2.25 1.25,7.543 1.958,8.25 7.25,2.957 7.25,8.25 8.25,8.25 8.25,1.25 8.25,1.25 "></polygon>
                    </svg>
                </span>
            </a>
        </div>

    </div>
</section>
<section class="info-section1 pb-0">
    <div class="info-container">
        <div class="animated-title-wrapper">
            <h1 class="section-title2  char-animate">Why Choose Us</h1>
        </div>

        <div class="process-grid ">

            <div class="process-item ">
                <div class="item-inner">
                    <div class="item-content ">
                        <div class="icon-holder">
                            <div class="item-icon">
                                <svg viewBox="0 0 496 512" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M248 8C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm160 215.5v6.93c0 5.87-3.32 11.24-8.57 13.86l-15.39 7.7a15.485 15.485 0 0 1-15.53-.97l-18.21-12.14a15.52 15.52 0 0 0-13.5-1.81l-2.65.88c-9.7 3.23-13.66 14.79-7.99 23.3l13.24 19.86c2.87 4.31 7.71 6.9 12.89 6.9h8.21c8.56 0 15.5 6.94 15.5 15.5v11.34c0 3.35-1.09 6.62-3.1 9.3l-18.74 24.98c-1.42 1.9-2.39 4.1-2.83 6.43l-4.3 22.83c-.62 3.29-2.29 6.29-4.76 8.56a159.608 159.608 0 0 0-25 29.16l-13.03 19.55a27.756 27.756 0 0 1-23.09 12.36c-10.51 0-20.12-5.94-24.82-15.34a78.902 78.902 0 0 1-8.33-35.29V367.5c0-8.56-6.94-15.5-15.5-15.5h-25.88c-14.49 0-28.38-5.76-38.63-16a54.659 54.659 0 0 1-16-38.63v-14.06c0-17.19 8.1-33.38 21.85-43.7l27.58-20.69a54.663 54.663 0 0 1 32.78-10.93h.89c8.48 0 16.85 1.97 24.43 5.77l14.72 7.36c3.68 1.84 7.93 2.14 11.83.84l47.31-15.77c6.33-2.11 10.6-8.03 10.6-14.7 0-8.56-6.94-15.5-15.5-15.5h-10.09c-4.11 0-8.05-1.63-10.96-4.54l-6.92-6.92a15.493 15.493 0 0 0-10.96-4.54H199.5c-8.56 0-15.5-6.94-15.5-15.5v-4.4c0-7.11 4.84-13.31 11.74-15.04l14.45-3.61c3.74-.94 7-3.23 9.14-6.44l8.08-12.11c2.87-4.31 7.71-6.9 12.89-6.9h24.21c8.56 0 15.5-6.94 15.5-15.5v-21.7C359.23 71.63 422.86 131.02 441.93 208H423.5c-8.56 0-15.5 6.94-15.5 15.5z"></path>
                                </svg>
                            </div>
                            <div class="item-number text-light ">1.</div>
                        </div>
                        <h3 class="item-title ">Mobility</h3>
                        <p class="item-text ">Seamlessly adaptable designs that move with your needs.</p>
                    </div>
                </div>
            </div>

            <div class="process-item ">
                <div class="item-inner">
                    <div class="item-content ">
                        <div class="icon-holder">
                            <div class="item-icon">
                                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 377.4l43 74.3A51.35 51.35 0 0 0 90.9 480h285.4l-59.2-102.6zM501.8 350L335.6 59.3A51.38 51.38 0 0 0 290.2 32h-88.4l257.3 447.6 40.7-70.5c1.9-3.2 21-29.7 2-59.1zM275 304.5l-115.5-200L44 304.5z"></path>
                                </svg>
                            </div>
                            <div class="item-number text-light">2.</div>
                        </div>
                        <h3 class="item-title ">Time Saving</h3>
                        <p class="item-text ">Efficient planning and execution to meet deadlines effortlessly.</p>
                    </div>
                </div>
            </div>

            <div class="process-item ">
                <div class="item-inner">
                    <div class="item-content ">
                        <div class="icon-holder">
                            <div class="item-icon">
                                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M87 481.8h73.7v-73.6H87zM25.4 346.6v61.6H87v-61.6zm466.2-169.7c-23-74.2-82.4-133.3-156.6-156.6C164.9-32.8 8 93.7 8 255.9h95.8c0-101.8 101-180.5 208.1-141.7 39.7 14.3 71.5 46.1 85.8 85.7 39.1 107-39.7 207.8-141.4 208v.3h-.3V504c162.6 0 288.8-156.8 235.6-327.1zm-235.3 231v-95.3h-95.6v95.6H256v-.3z"></path>
                                </svg>
                            </div>
                            <div class="item-number text-light">3.</div>
                        </div>
                        <h3 class="item-title ">Concentrated</h3>
                        <p class="item-text ">Precision-focused solutions tailored to your vision.</p>
                    </div>
                </div>
            </div>

            <div class="process-item ">
                <div class="item-inner">
                    <div class="item-content ">
                        <div class="icon-holder">
                            <div class="item-icon">
                                <svg viewBox="0 0 496 512" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M247.6 8C389.4 8 496 118.1 496 256c0 147.1-118.5 248-248.4 248C113.6 504 0 394.5 0 256 0 123.1 104.7 8 247.6 8zm.8 44.7C130.2 52.7 44.7 150.6 44.7 256c0 109.8 91.2 202.8 203.7 202.8 103.2 0 202.8-81.1 202.8-202.8.1-113.8-90.2-203.3-202.8-203.3zM137.7 221c13-83.9 80.5-95.7 108.9-95.7 99.8 0 127.5 82.5 127.5 134.2 0 63.6-41 132.9-128.9 132.9-38.9 0-99.1-20-109.4-97h62.5c1.5 30.1 19.6 45.2 54.5 45.2 23.3 0 58-18.2 58-82.8 0-82.5-49.1-80.6-56.7-80.6-33.1 0-51.7 14.6-55.8 43.8h18.2l-49.2 49.2-49-49.2h19.4z"></path>
                                </svg>
                            </div>
                            <div class="item-number text-light">4.</div>
                        </div>
                        <h3 class="item-title ">Meeting And Approval</h3>
                        <p class="item-text ">Streamlined collaboration for smooth project approvals.</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="cta-button-wrapper pb-4">
            <a href="{{route('website.appointment')}}" class="cta-button buttonhero1">
                <span class="button-text">Request An Appointment</span>

            </a>
        </div>
        <hr style="
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 2px solid;">
    </div>
</section>
<section class="slider-section pt-0 ">
    <div class="header-content">
        <div class="text-and-button-wrap">
            <h1 class="section-title2  char-animate">
                We Design It All.
            </h1>
            <h2 class="subtitle1 ">
                We provide turnkey solutions from architectural services to all technical fields to turn your dreams into reality.
            </h2>
            <a class="all-services-btn float-right " href="{{route('website.service')}}">
                <span class="btn-text ">All Services</span>
                <span class="btn-icon">→</span>
            </a>
        </div>
    </div>


    <section class="unique-arch-section pb-0 ">
        <div class="container">
            <div class="unique-arch-slider swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="unique-arch-cardsss ">
                            <img src="assetss/images/about/2-2.jpg" alt="Commercial">

                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="unique-arch-cardsss ">
                            <img src="assetss/images/about/1-4.jpg" alt="Residential">

                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="unique-arch-cardsss ">
                            <img src="assetss/images/about/3-1.jpg" alt="Interior">

                        </div>
                    </div>

                    <div class="swiper-slide ">
                        <div class="unique-arch-cardsss ">
                            <img src="assetss/images/about/2-2.jpg" alt="Commercial">

                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="unique-arch-cardsss ">
                          <img src="assetss/images/about/3-1.jpg" alt="Interior">

                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="unique-arch-cardsss ">
                               <img src="assetss/images/about/1-4.jpg" alt="Residential">

                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="unique-arch-cardsss ">
                            <img src="assetss/images/about/2-2.jpg" alt="Commercial">

                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="unique-arch-cardsss ">
                            <img src="assetss/images/about/2-2.jpg" alt="Commercial">
                            <!-- <h3>COMMERCIAL</h3> -->
                        </div>
                    </div>
                    <div class="swiper-slide ">
                        <div class="unique-arch-cardsss ">
                            <img src="assetss/images/about/2-2.jpg" alt="Commercial">
                            <!-- <h3>COMMERCIAL</h3> -->
                        </div>
                    </div>

                </div>

                <div class="unique-arch-prev">←</div>
                <div class="unique-arch-next">→</div>
            </div>

        </div>

    </section>

    <!-- <section class="unique-arch-section pb-0">
    <div class="container-fluid px-0">
        <div class="unique-arch-slider swiper">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="unique-arch-cardsss">
                        <img src="assets/images/about/2-2.jpg" alt="Commercial">
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="unique-arch-cardsss">
                        <img src="assets/images/about/1-4.jpg" alt="Residential">
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="unique-arch-cardsss">
                        <img src="assets/images/about/3-1.jpg" alt="Interior">
                    </div>
                </div>

            </div>

            <div class="unique-arch-prev">←</div>
            <div class="unique-arch-next">→</div>
        </div>
    </div>
</section> -->





    <section class="blog-home pt-5">
        <div class="container">
            <div class="block-title text-center">
                <h2 class="blog-title__h2">Working with the India's leading brands </h2>
            </div>
            <div class="row brand-slider">
                <div class="col-lg-2 wow fadeInUp brandimg animated" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-name: fadeInUp;">
                    <img src="{{url('public/uploads/sitesetting/dd6aeee2-4a5e-4be6-b327-4a7be339b4ad.png')}}">
                </div>
                <div class="col-lg-2 wow fadeInUp brandimg animated" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-name: fadeInUp;">
                    <img src="{{url('public/uploads/sitesetting/dd6aeee2-4a5e-4be6-b327-4a7be339b4ad.png')}}">
                </div>
                <div class="col-lg-2 wow fadeInUp brandimg animated" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-name: fadeInUp;">
                    <img src="{{url('public/uploads/sitesetting/dd6aeee2-4a5e-4be6-b327-4a7be339b4ad.png')}}">
                </div>
                <div class="col-lg-2 wow fadeInUp brandimg animated" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-name: fadeInUp;">
                    <img src="{{url('public/uploads/sitesetting/dd6aeee2-4a5e-4be6-b327-4a7be339b4ad.png')}}">
                </div>

                <div class="col-lg-2 wow fadeInUp brandimg animated" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-name: fadeInUp;">
                    <img src="{{url('public/uploads/sitesetting/dd6aeee2-4a5e-4be6-b327-4a7be339b4ad.png')}}">
                </div>
                <div class="col-lg-2 wow fadeInUp brandimg animated" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-name: fadeInUp;">
                    <img src="{{url('public/uploads/sitesetting/dd6aeee2-4a5e-4be6-b327-4a7be339b4ad.png')}}">
                </div>
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="animated-title-wrapper">
            <h1 class="section-title  char-animate">Meet Our Team</h1>
        </div>
        <div class="team-container">

            @foreach ($teams as $team)
            <div class="team-column">
                <div class="team-member-card">
                    <div class="member-image-wrap">
                        <img src="{{ asset('public/' . $team->image) }}" class="member-image" alt="{{ $team->name }}">
                    </div>
                    <div class="member-content">
                        <h4 class="member-title ">{{ $team->name }}</h4>
                        <!-- <div class="member-social-icons">
                        <a href="#" target="_blank" class="social-icon-link">
                            <svg viewBox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                            </svg>
                        </a>
                        <a href="#" target="_blank" class="social-icon-link">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                            </svg>
                        </a>
                        <a href="#" target="_blank" class="social-icon-link">
                            <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                            </svg>
                        </a>
                        <a href="#" target="_blank" class="social-icon-link">
                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.75-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z"></path>
                            </svg>
                        </a>
                    </div> -->
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </section>

    <section class="testimonials-section">
        <div class="container">
            <h2 class="section-title  char-animate">Client's Feedback</h2>

            <div class="testimonials-slider swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="{{url('public/banners/wood.jpg')}}" alt="Wood Villa" class="testimonial-image">
                            <div class="testimonial-content">

                                <h3 class="testimonial-title">Wood Villa</h3>
                                <p class="testimonial-text">The design of our villa changed our perspective of house and what does a Home really means</p>
                                <div class="testimonial-author">
                                    <p class="author-name">Mr. Shoaib</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="{{url('public/banners/8-villa-1.jpg')}}" alt="085 Villa" class="testimonial-image">
                            <div class="testimonial-content">

                                <h3 class="testimonial-title">085 Villa</h3>
                                <p class="testimonial-text">loved working the team. Went through the creative process with Kumail Bhardwaj Architech with ease and learned alot why is design important and change the perspective we think in.</p>
                                <div class="testimonial-author">
                                    <p class="author-name">Mr. Sarang</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="{{url('public/banners/metro.jpg')}}" alt="Metro London" class="testimonial-image">
                            <div class="testimonial-content">

                                <h3 class="testimonial-title">Metro London</h3>
                                <p class="testimonial-text">the process with Bhardwaj Architech was unexpectedly smoother than our previous designers. we are working with them on multiple projects and will suggest everyone to do so as well.</p>
                                <div class="testimonial-author">
                                    <p class="author-name">Mr. Wahid</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="{{url('public/banners/rim-house-1.jpg')}}" alt="Rim House" class="testimonial-image">
                            <div class="testimonial-content">

                                <h3 class="testimonial-title">Rim House</h3>
                                <p class="testimonial-text">Was shocked how can a 1 kanal house be turned into a bigger space.</p>
                                <div class="testimonial-author">
                                    <p class="author-name">Mr. Sheikh Jahan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="{{url('public/banners/lv-villa.jpg')}}" alt="LV Villa" class="testimonial-image">
                            <div class="testimonial-content">

                                <h3 class="testimonial-title">LV Villa</h3>
                                <p class="testimonial-text">Bhardwaj Architech turned my less space into a very spacious living space.</p>
                                <div class="testimonial-author">
                                    <p class="author-name">Mr. Nadeem</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="{{url('public/banners/nik.jpg')}}" alt="Villa 8" class="testimonial-image">
                            <div class="testimonial-content">

                                <h3 class="testimonial-title">Villa 8</h3>
                                <p class="testimonial-text">loved the process with creative heads and architects, i was the part of the whole design process and that is what i needed.</p>
                                <div class="testimonial-author">
                                    <p class="author-name">Mr. Nik</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="{{url('public/banners/sky-nine.jpg')}}" alt="Sky Nine" class="testimonial-image">
                            <div class="testimonial-content">

                                <h3 class="testimonial-title">Sky Nine</h3>
                                <p class="testimonial-text">design for BESTWESTERN Islamabad was a big challenge to power the selling capacity and Bhardwaj Architech did an amazing job to do so.</p>
                                <div class="testimonial-author">
                                    <p class="author-name">Mr. Musheer</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bdt-navigation-prev">←</div>
                <div class="bdt-navigation-next">→</div>
            </div>
        </div>
    </section>

    <section class="cta-section " style="background-image: url('assetss/images/services/imgi_13_16.jpg');">
        <div class="cta-overlay"></div>
        <div class="cta-container">

            <div class="cta-heading-group animated-element">
                <h1 class="cta-main-heading">
                    Have a project in mind?
                </h1>
            </div>

            <div class="cta-heading-group animated-element delay-200">
                <h2 class="cta-sub-heading">
                    Do not hesitate to say
                    <span class="typeout-text">Hello</span>
                    <span class="typed-cursor">|</span>
                </h2>
            </div>

            <div class="cta-button-wrapper animated-element delay-400">
                <a href="{{route('website.appointment')}}" class="cta-button">
                    <span class="button-text">Request An Appointment</span>
                    <span class="button-icon-box">
                        <svg viewBox="1.25 1.25 7 7" aria-hidden="true" width="7px" height="7px">
                            <polygon points="1.25,1.25 1.25,2.25 6.543,2.25 1.25,7.543 1.958,8.25 7.25,2.957 7.25,8.25 8.25,8.25 8.25,1.25 8.25,1.25 "></polygon>
                        </svg>
                    </span>
                </a>
            </div>

        </div>
    </section>
    @endsection
    @section('script')
    <script>


    </script>
    @endsection