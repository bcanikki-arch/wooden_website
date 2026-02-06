@extends('Website.layouts.app')
@section('style')


@endsection 
@section('content')
<section class="section-content-boxed appointment-section" id="appointment">
    <div class="container-inner">
        <div class="section-header">
            <h2 class="section-title loadanimation animate">Schedule Your Consultation</h2>
            <p class="section-subtitle intro-text">
                Fill out the form below to book an appointment with our experts. We will confirm your slot within 24 hours.
            </p>
        </div>
        <div class="appointment-form-grid text-center " id="response-message">
            <div class="response-message"></div>
        </div>
        <form method="POST" action="" id="appointment-form" class="appointment-form-grid">
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
                <label for="service">Select Service *</label>
                <select id="service" name="service" required="">
                    <option value="">-- Choose a Service --</option>
                    <option value="web-design">Web Design &amp; Development</option>
                    <option value="architecture">Architectural Planning</option>
                    <option value="interior-design">Interior Remodeling</option>
                    <option value="other">Other Inquiry</option>
                </select>
            </div>

            <div class="form-group form-group-full-width"> 
                <label for="date">Preferred Date &amp; Time *</label>
                <input type="datetime-local" id="date" name="preferredDate" required="">
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
@endsection
@section('script')
<script>

  document.getElementById('appointment-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const messageBox = document.getElementById('response-message');
        const submitButton = form.querySelector('.submit-button');

        // Set the target URL to the new PHP file
        const submitUrl = 'contactsubmit.php'; // <--- UPDATED TARGET FILE

        // Show loading state
        submitButton.disabled = true;
        submitButton.innerText = 'Sending...';
        messageBox.style.display = 'none';
        messageBox.style.opacity = '0';

        fetch(submitUrl, {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok || res.headers.get('content-type').indexOf('application/json') === -1) {
                    throw new Error('Server returned an invalid response (not JSON).');
                }
                return res.json();
            })
            .then(data => {
                // Handle the JSON response
                messageBox.style.opacity = '1';
                messageBox.style.display = 'block';
                messageBox.innerHTML = data.message;

                if (data.status === 'success') {
                    messageBox.style.background = '#d4edda';
                    messageBox.style.color = '#155724';
                    form.reset();
                } else {
                    messageBox.style.background = '#f8d7da';
                    messageBox.style.color = '#721c24';
                }

                // Restore button state
                submitButton.disabled = false;
                submitButton.innerText = 'Submit';

                // Hide message after 5 seconds
                setTimeout(() => {
                    messageBox.style.opacity = '0';
                    setTimeout(() => messageBox.style.display = 'none', 500);
                }, 5000);
            })
            .catch((error) => {
                // Network/Non-JSON error handler
                console.error('Fetch Error:', error);
                messageBox.style.opacity = '1';
                messageBox.style.display = 'block';
                messageBox.style.background = '#f8d7da';
                messageBox.style.color = '#721c24';
                messageBox.innerHTML = '❌ An unexpected error occurred. Check the console for details.';

                // Restore button state
                submitButton.disabled = false;
                submitButton.innerText = 'Submit';

                setTimeout(() => {
                    messageBox.style.opacity = '0';
                    setTimeout(() => messageBox.style.display = 'none', 500);
                }, 5000);
            });
    });
</script>
@endsection