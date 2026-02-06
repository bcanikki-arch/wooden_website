<?php

namespace App\Http\Controllers\Website\Home;

use App\Mail\ContactMail;
use App\Mail\AppointmentMail;
use \App\Models\Contact;
use \App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
class ContactController extends Controller
{
   public function submit(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email',
            'phone'  => 'required|string|max:20',
            'area'   => 'required|string|max:255',
            'message'=> 'nullable|string',
        ]);
    
        Contact::create($validated);
        Mail::to(env('MAIL_USERNAME'))->send(new ContactMail($validated));
        
        return back()->with('success', 'Thank you for your infomation we will contact you soon!');
    }
   public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email',
            'phone'          => 'nullable|string|max:20',
            'service'        => 'required|string',
            'preferred_date' => 'required',
            'message'        => 'nullable|string',
        ]);
    
        Appointment::create($validated);
        Mail::to(env('MAIL_USERNAME'))->send(new AppointmentMail($validated));
        return back()->with('success', 'Appointment booked successfully! We will contact you soon.');
    }

}
