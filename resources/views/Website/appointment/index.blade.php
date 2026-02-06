@extends('Website.layouts.app')
@section('style')
<style>
    /* -------------------------------------- */
    /* 1. Base Styles & Layout Helpers        */
    /* -------------------------------------- */

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
<section class="section-content-boxed appointment-section" id="appointment">
    <div class="container-inner">
        <div class="section-header">
            <h2 class="section-title char-animate">Schedule Your Consultation</h2>

            <h2 class="sub-heading">Fill out the form below to book an appointment with our experts. We will confirm your slot within 24 hours.</h2>


        </div>
        <div class="appointment-form-grid text-center " id="response-message">
            <div class="response-message"></div>
        </div>
        
            @if(session('success'))
                <div class="alert alert-success" style="margin: 9px auto;">
                    {{ session('success') }}
                </div>
            @endif
        <form method="POST" action="{{ route('appointment.submit') }}" id="appointment-form" class="appointment-form-grid">

             @csrf
            <input type="hidden" name="form_type" value="inquiry">
            <div class="form-group">
                <label for="full-name">Full Name *</label>
                <input type="text" id="full-name" name="name" required="" placeholder="John Doe">
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" required="" placeholder="name@example.com">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="+910000000000">
            </div>

            <div class="form-group">
                <label for="service">Select Service <span class="text-danger">*</span></label>
                <select id="service" name="service" required>
                    <option value="">-- Choose a Service --</option>
                    <option value="construction-planning"> Construction Design & Planning</option>
                    <option value="architectural-design"> Architectural Design </option>
                    <option value="landscape-design"> Landscape Design </option>
                    <option value="interior-design"> Interior Design & Remodeling </option>
                    <option value="project-consultation"> Project Consultation </option>
                    <option value="other"> Other Inquiry
                    </option>
                </select>
            </div>

            <div class="form-group form-group-full-width">
                <label for="date">Preferred Date &amp; Time *</label>
                <input type="datetime-local" id="date" name="preferred_date" required="">
            </div>

            <div class="form-group form-group-full-width">
                <label for="message">Your Project Details (Optional)</label>
                <textarea id="message" name="message" rows="4" placeholder="Briefly describe your project or what you would like to discuss..."></textarea>
            </div>

            <div class="form-group form-group-full-width">
                <button type="submit" class="submit-btn submit-button">Book My Appointment</button>
            </div>

            <p id="confirmation-message" class="confirmation-message" style="display: none;">
                Thank you! Your request has been sent successfully. We will contact you soon.
            </p>

        </form>
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
<!--<script>-->
<!--    document.getElementById('appointment-form').addEventListener('submit', function(e) {-->
<!--        e.preventDefault();-->

<!--        const form = e.target;-->
<!--        const formData = new FormData(form);-->
<!--        const messageBox = document.getElementById('response-message');-->
<!--        const submitButton = form.querySelector('.submit-button');-->

        <!--// Set the target URL to the new PHP file-->
<!--        const submitUrl = "{{ route('appointment.submit') }}";-->

        <!--// Show loading state-->
<!--        submitButton.disabled = true;-->
<!--        submitButton.innerText = 'Sending...';-->
<!--        messageBox.style.display = 'none';-->
<!--        messageBox.style.opacity = '0';-->

<!--        fetch(submitUrl, {-->
<!--            method: 'POST',-->
<!--            headers: {-->
<!--                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content-->
<!--            },-->
<!--            body: formData-->
<!--        })-->
<!--            .then(res => {-->
<!--                if (!res.ok || res.headers.get('content-type').indexOf('application/json') === -1) {-->
<!--                    throw new Error('Server returned an invalid response (not JSON).');-->
<!--                }-->
<!--                return res.json();-->
<!--            })-->
<!--            .then(data => {-->
                <!--// Handle the JSON response-->
<!--                messageBox.style.opacity = '1';-->
<!--                messageBox.style.display = 'block';-->
<!--                messageBox.innerHTML = data.message;-->

<!--                if (data.status === 'success') {-->
<!--                    messageBox.style.background = '#d4edda';-->
<!--                    messageBox.style.color = '#155724';-->
<!--                    form.reset();-->
<!--                } else {-->
<!--                    messageBox.style.background = '#f8d7da';-->
<!--                    messageBox.style.color = '#721c24';-->
<!--                }-->

                <!--// Restore button state-->
<!--                submitButton.disabled = false;-->
<!--                submitButton.innerText = 'Submit';-->

                <!--// Hide message after 5 seconds-->
<!--                setTimeout(() => {-->
<!--                    messageBox.style.opacity = '0';-->
<!--                    setTimeout(() => messageBox.style.display = 'none', 500);-->
<!--                }, 5000);-->
<!--            })-->
<!--            .catch((error) => {-->
                <!--// Network/Non-JSON error handler-->
<!--                console.error('Fetch Error:', error);-->
<!--                messageBox.style.opacity = '1';-->
<!--                messageBox.style.display = 'block';-->
<!--                messageBox.style.background = '#f8d7da';-->
<!--                messageBox.style.color = '#721c24';-->
<!--                messageBox.innerHTML = '❌ An unexpected error occurred. Check the console for details.';-->

                <!--// Restore button state-->
<!--                submitButton.disabled = false;-->
<!--                submitButton.innerText = 'Submit';-->

<!--                setTimeout(() => {-->
<!--                    messageBox.style.opacity = '0';-->
<!--                    setTimeout(() => messageBox.style.display = 'none', 500);-->
<!--                }, 5000);-->
<!--            });-->
<!--    });-->
<!--</script>-->
@endsection