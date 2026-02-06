<script src="{{ url('assetss/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ url('assetss/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('assetss/js/swiper.min.js') }}"></script>
<script src="{{ url('assetss/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ url('assetss/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ url('assetss/js/jquery.validate.min.js') }}"></script>
<script src="{{ url('assetss/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('assetss/js/wow.js') }}"></script>
<script src="{{ url('assetss/js/odometer.min.js') }}"></script>
<script src="{{ url('assetss/js/jquery.appear.min.js') }}"></script>
<script src="{{ url('assetss/js/wNumb.min.js') }}"></script>
<script src="{{ url('assetss/js/nouislider.min.js') }}"></script>
<script src="{{ url('assetss/js/theme.js') }}"></script>
<script type="text/javascript" src="{{ url('assetss/js/loan-calculator.js') }}"></script>
<script type="text/javascript" src="{{ url('assetss/js/jquery-1.12.4.js') }}"></script>
<script type="text/javascript" src="{{ url('assetss/js/jquery-ui.js') }}"></script>
<script src="{{ url('assetss/cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js') }}"></script>
<script src="{{ url('assetss/cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js') }}"></script>
<script src="{{ url('assetss/cdn.amcharts.com/lib/4/core.js') }}"></script>
<script src="{{ url('assetss/cdn.amcharts.com/lib/4/maps.js') }}"></script>
<script src="{{ url('assetss/cdn.amcharts.com/lib/4/geodata/worldLow.js') }}"></script>
<script src="{{ url('assetss/cdn.amcharts.com/lib/4/themes/animated.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/indiaLow.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ==========================================================
       1️⃣ Swiper Sliders Initialization
    =========================================================== */
    const swiperConfigs = [
        {
            selector: '.testimonial-slider-wrapper',
            options: {
                slidesPerView: 3,
                centeredSlides: true,
                spaceBetween: 30,
                loop: true,
                navigation: { nextEl: '.bdt-navigation-next', prevEl: '.bdt-navigation-prev' },
                breakpoints: {
                    768: { slidesPerView: 1, spaceBetween: 20 },
                    1024: { slidesPerView: 3, spaceBetween: 30 }
                }
            }
        },
        {
            selector: '.testimonials-slider',
            options: {
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                speed: 800,
                spaceBetween: 30,
                centeredSlides: true,
                initialSlide: 1,
               navigation: {
                  nextEl: '.testimonials-slider .bdt-navigation-next',
                  prevEl: '.testimonials-slider .bdt-navigation-prev'
                },

                breakpoints: {
                    320: { slidesPerView: 1 },
                    768: { slidesPerView: 2 },
                    992: { slidesPerView: 3 }
                }
            }
        },
        {
            // selector: '.unique-arch-slider',
            // options: {
            //     slidesPerView: 3,
            //     spaceBetween: 60,
            //     centeredSlides: true,
            //     loop: true,
            //     navigation: { nextEl: '.unique-arch-next', prevEl: '.unique-arch-prev' },
            //     breakpoints: {
            //         0: { slidesPerView: 1, spaceBetween: 20 },
            //         768: { slidesPerView: 2, spaceBetween: 30 },
            //         1024: { slidesPerView: 3, spaceBetween: 40 }
            //     }
            // }
            selector: '.unique-arch-slider',
                options: {  
                    loop: true,
                    centeredSlides: true,
                    slidesPerView: 3,
                    spaceBetween: 60,
                    speed: 800,
                    navigation: {
                        nextEl: ".unique-arch-next",
                        prevEl: ".unique-arch-prev",
                    },
                    breakpoints: {
                         0: { slidesPerView: 1, spaceBetween: 20 ,centeredSlides: false,loop: false },
                                    768: { slidesPerView: 2, spaceBetween: 30, centeredSlides: false, loop: true },
                                    1024: { slidesPerView: 3, spaceBetween: 40,centeredSlides: true, loop: true }
                    },
                }

        },
         {
            selector: '.unique-arch-sliders',
            options: {
                slidesPerView: 3,
                spaceBetween: 60,
                centeredSlides: true,
                loop: true,
                navigation: { nextEl: '.unique-arch-next', prevEl: '.unique-arch-prev' },
                breakpoints: {
                    0: { slidesPerView: 1, spaceBetween: 20 },
                    768: { slidesPerView: 2, spaceBetween: 30 },
                    1024: { slidesPerView: 3, spaceBetween: 40 }
                }
            }
        }



        
    ];

    swiperConfigs.forEach(cfg => {
        if (document.querySelector(cfg.selector)) new Swiper(cfg.selector, cfg.options);
    });


    /* ==========================================================
       2️⃣ Radio-based Prime Slider Autoplay
    =========================================================== */
    const totalSlides = 4;
    let currentSlide = 1;
    const intervalTime = 7000;
    const dots = document.querySelectorAll('.slideshow-nav .dot');

    const nextSlide = () => {
        document.getElementById(`slide${currentSlide}`)?.removeAttribute('checked');
        currentSlide = (currentSlide % totalSlides) + 1;
        document.getElementById(`slide${currentSlide}`)?.setAttribute('checked', true);
    };

    let autoplayTimer = setInterval(nextSlide, intervalTime);

    dots.forEach(dot => {
        dot.addEventListener('click', e => {
            const targetId = e.target.getAttribute('for');
            currentSlide = parseInt(targetId.replace('slide', ''), 10);
            clearInterval(autoplayTimer);
            autoplayTimer = setInterval(nextSlide, intervalTime);
        });
    });
am4core.ready(function () {

    am4core.useTheme(am4themes_animated);

    const chart = am4core.create("chartdiv", am4maps.MapChart);

    chart.geodata = am4geodata_indiaLow;
    chart.projection = new am4maps.projections.Miller();

    // ✅ FIX VIEW
    chart.homeZoomLevel = 1.2;
    chart.homeGeoPoint = { latitude: 22.9734, longitude: 78.6569 };

    chart.maxZoomLevel = 5;
    chart.minZoomLevel = 1;

    chart.zoomControl = new am4maps.ZoomControl();

    const polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
    polygonSeries.useGeodata = true;

    const polygonTemplate = polygonSeries.mapPolygons.template;
    polygonTemplate.tooltipText = "{name}";
    polygonTemplate.fill = am4core.color("#e0e0e0");
    polygonTemplate.stroke = am4core.color("#ffffff");

    polygonTemplate.states.create("hover").properties.fill =
        am4core.color("#cfd8dc");

    // Highlight states
    polygonSeries.data = [
        { id: "IN-DL", fill: am4core.color("#ff5722") }, // Delhi
        { id: "IN-AS", fill: am4core.color("#ff5722") }, // Assam
        { id: "IN-RJ", fill: am4core.color("#ff5722") }  // Rajasthan
    ];

    polygonTemplate.propertyFields.fill = "fill";

    // ✅ Proper zoom on India
    chart.events.on("ready", function () {
        const india = polygonSeries.getPolygonById("IN");
        chart.zoomToMapObject(india, 1, true);
    });

});




    /* ==========================================================
       4️⃣ Animated Counters on Scroll
    =========================================================== */
    const countersAnimated = new Set();

    const startCounter = el => {
        const num = parseInt(el.dataset.num.replace(/[^\d]/g, ''), 10);
        if (isNaN(num)) return;
        const duration = 2000;
        const startTime = performance.now();
        const originalText = el.dataset.num;

        const update = now => {
            const progress = Math.min((now - startTime) / duration, 1);
            el.textContent = Math.floor(progress * num).toLocaleString('en-US');
            if (progress < 1) requestAnimationFrame(update);
            else el.textContent = originalText;
        };
        requestAnimationFrame(update);
    };

    const checkCounters = () => {
        document.querySelectorAll('.milestone-counter .num, .milestone-counter .map-counter-number')
            .forEach(el => {
                if (!countersAnimated.has(el) && el.getBoundingClientRect().top < window.innerHeight - 50) {
                    startCounter(el);
                    countersAnimated.add(el);
                }
            });
    };

    window.addEventListener('scroll', checkCounters);
    window.addEventListener('load', checkCounters);
    checkCounters();


    /* ==========================================================
       5️⃣ Typing Animation
    =========================================================== */
    const dataText = ["Sustainable Structures.", "Timeless Designs.", "Innovative Spaces.", "Elegant Architecture."];
    const cursor = document.querySelector(".typed-cursor");

    const typeWriter = (text, i = 0, done) => {
        if (!cursor) return;
        if (i < text.length) {
            cursor.innerHTML = text.substring(0, i + 1) + '<span class="caretenimation" aria-hidden="true"></span>';
            setTimeout(() => typeWriter(text, i + 1, done), 100);
        } else if (done) setTimeout(done, 700);
    };

    const startTyping = (i = 0) => {
        if (i >= dataText.length) i = 0;
        typeWriter(dataText[i], 0, () => startTyping(i + 1));
    };
    startTyping();


    /* ==========================================================
       6️⃣ Load Animation Observer
    =========================================================== */
   document.querySelectorAll(".char-animate").forEach(title => {
    const text = title.innerText;
    title.innerHTML = "";

    [...text].forEach((char, i) => {
        const span = document.createElement("span");
        span.innerHTML = char === " " ? "&nbsp;" : char;
        span.style.transitionDelay = `${i * 60}ms`;
        title.appendChild(span);
    });
});

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add("animate");
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll(".char-animate").forEach(el => observer.observe(el));

});

/// whychoose line animation///////

const processObserver = new IntersectionObserver(entries => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("animate");
            processObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.4 });

document.querySelectorAll(".process-item").forEach(item => {
    processObserver.observe(item);
});


</script>