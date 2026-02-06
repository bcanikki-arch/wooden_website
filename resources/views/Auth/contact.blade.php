<h2>New Contact Form Submission</h2>

<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Phone:</strong> {{ $data['phone'] }}</p>
<p><strong>Area:</strong> {{ $data['area'] }}</p>

@if(!empty($data['message']))
<p><strong>Message:</strong> {{ $data['message'] }}</p>
@endif
