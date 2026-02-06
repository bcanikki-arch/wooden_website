<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Appointment</title>
</head>
<body style="font-family: Arial, sans-serif; line-height:1.6; color:#333;">

    <h2>New Appointment Request</h2>

    <p>Hello Admin,</p>

    <p>You have received a new appointment request from the website.</p>

    <hr>

    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Phone:</strong> {{ $data['phone'] ?? 'N/A' }}</p>
    <p><strong>Service:</strong> {{ $data['service'] }}</p>
    <p><strong>Preferred Date:</strong> {{ $data['preferred_date'] }}</p>

    @if(!empty($data['message']))
        <p><strong>Message:</strong><br>
        {{ $data['message'] }}</p>
    @endif

    <hr>

    <p>
        Regards,<br>
        <strong>Bhardwaj Architects</strong><br>
        Website Appointment System
    </p>

</body>
</html>
