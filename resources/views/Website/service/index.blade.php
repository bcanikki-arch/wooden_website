@extends('Website.layouts.app')
@section('style')
<style>
    @media (max-width: 991px) {
        .intro-text {
            font-size: 30px;
            padding: 0px 0px 0px 0px;
        }
    }

    @media (max-width: 575px) {
        .intro-text {
            font-size: 20px;
            padding: 0px 0px 0px 0px;
        }


    }

    .sss {
        font-size: 20px;
        text-align: center;

    }
  
    .service-title
    {
        text-align: center;
    }
    .service-title h2 {
        text-align: center;
    }
    .intro-text
    {
font-size: 30px;
padding-bottom: 2rem;
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
<section class="service-item pt-4">
    <div class="container">
        <div class="animated-title-wrapper">
            <h1 class="section-title char-animate show">Our Services</h1>
        </div>

        <p class="intro-text">
            “At AR Bhardwaj Architech , we provide comprehensive solutions in residential and interior design, structural engineering, landscaping, construction, real estate, and MEP design, delivering quality, innovation, and precision in every project.”
        </p>
        @foreach ($services as $serv)
        <div class="row flex p-3">
            <div class="column-content">
                <h2 class="service-title char-animate">{{$serv->name}}</h2>
                <div class="service-description sss">
                    {!!$serv->subdescription!!}
                </div>
            </div>
            <div class="column-image">
                <img src="{{ url('public/uploads/services/' . $serv->image) }}" alt="RESIDENTIAL DESIGN">
            </div>
        </div>
        @endforeach
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
                <span class="typed-cursor">S<span class="caretenimation" aria-hidden="true"></span></span>
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
<section class="section-intro pt-4">
    <div class="container">
        <div class="animated-title-wrapper">
            <h1 class="section-title char-animate show">Our Services</h1>
        </div>
        <p class="intro-text pb-1">
            “At AR Bhardwaj Architech, we provide comprehensive solutions in residential and interior design, structural engineering, landscaping, construction, real estate, and MEP design, delivering quality, innovation, and precision in every project.”
        </p>
    </div>
</section>
<section class="service-grid-section section-content-boxed">
    <div class="container">
        <div class="service-grid">
            @foreach ($services as $serv)

            <div class="service-grid-item">
                <img src="{{ url('public/uploads/services/' . $serv->image) }}" alt="RESIDENTIAL DESIGN">
                <h3 class="grid-item-title">{{$serv->name}}</h3>
                <p class="grid-item-description"></p>
                <p>{!! $serv->description !!}</p>
                <p></p>
            </div>
            @endforeach
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
                <span class="typed-cursor">S<span class="caretenimation" aria-hidden="true"></span></span>
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
    const swiper = new Swiper('.about-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        centeredSlides: true,
        navigation: {
            nextEl: '.unique-arch1-next',
            prevEl: '.unique-arch1-prev',
        },
        effect: 'coverflow',
        coverflowEffect: {
            rotate: 0,
            stretch: 50,
            depth: 150,
            modifier: 2,
            slideShadows: false,
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 3,
            },
        },
    });
</script>
@endsection