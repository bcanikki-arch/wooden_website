
  document.addEventListener("DOMContentLoaded", function () {
    const toggleIcon = document.querySelector(".toggle-icon");
    const collapseElement = document.querySelector("#products");

    collapseElement.addEventListener("show.bs.collapse", function () {
      toggleIcon.classList.remove("fa-angle-down");
      toggleIcon.classList.add("fa-times");
    });

    collapseElement.addEventListener("hide.bs.collapse", function () {
      toggleIcon.classList.remove("fa-times");
      toggleIcon.classList.add("fa-angle-down");
    });
  });

  
 const btn = document.getElementById("backToTopBtn");

  window.addEventListener("scroll", function () {
    if (window.scrollY > 100) {
      btn.style.visibility = "visible";
      btn.style.opacity = "1";
    } else {
      btn.style.visibility = "hidden";
      btn.style.opacity = "0";
    }
  });

  function scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  }


// owl 
  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 2
      },
      1000: {
        items: 3
      }
    }
  })

  
// owl 
  $('.testimonials_slider').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 2
      },
      1000: {
        items: 3
      }
    }
  })





  var a = 0;
  $(window).scroll(function() {

    var oTop = $('#counter').offset().top - window.innerHeight;
    if (a == 0 && $(window).scrollTop() > oTop) {
      $('.counter-value').each(function() {
        var $this = $(this),
          countTo = $this.attr('data-count');
        $({
          countNum: $this.text()
        }).animate({
            countNum: countTo
          },

          {

            duration: 60000,
            easing: 'swing',
            step: function() {
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              $this.text(this.countNum);
              //alert('finished');
            }

          });
      });
      a = 1;
    }

  });






  $(window).scroll(function() {
    $('nav').toggleClass('scrolled', $(this).scrollTop() > 1);
  });




  var wow = new WOW({
    boxClass: 'wow',
    animateClass: 'animated',
    offset: 0,
    mobile: true,
    live: true,
    callback: function(box) {},
    scrollContainer: null,
    resetAnimation: true,
  });
  wow.init();



   function toggleReadMore() {
    const moreText = document.getElementById("moreText");
    const btn = document.getElementById("readMoreBtn");

    if (moreText.style.display === "none") {
      moreText.style.display = "block";
      btn.innerText = "Read Less";
    } else {
      moreText.style.display = "none";
      btn.innerText = "Read More";
      window.scrollTo({ top: document.getElementById("teak-description").offsetTop, behavior: 'smooth' });
    }
  }