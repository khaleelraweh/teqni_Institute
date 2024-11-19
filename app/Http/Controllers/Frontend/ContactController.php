<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'required|string|max:20',
            'subject'   => 'required|string|max:255',
            'message'   => 'required|string',
        ]);

        // If validation passes, process the data (e.g., send an email or store it in the database)
        try {
            // Send email logic (you can customize this to send a real email)
            Mail::raw("Name: {$validated['name']}\nEmail: {$validated['email']}\nPhone: {$validated['phone']}\nSubject: {$validated['subject']}\nMessage: {$validated['message']}", function ($message) use ($validated) {
                // $message->to('khaleelvisa@gmail.com') // Your email address
                $message->to('khaleelraweh302@gmail.com') // Your email address
                    ->subject('Contact Form Submission: ' . $validated['subject']);
            });

            // Redirect with success message
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            // Handle any errors (for example, logging or showing a generic error)
            return redirect()->back()->with('error', 'There was an error sending your message. Please try again later.');
        }
    }
}
