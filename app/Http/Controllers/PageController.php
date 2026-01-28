<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the about page.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the affiliate disclosure page.
     */
    public function disclosure()
    {
        return view('pages.affiliate-disclosure');
    }

    /**
     * Display the privacy policy page.
     */
    public function privacy()
    {
        return view('pages.privacy-policy');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // TODO: Send email or store contact message
        // Mail::to('admin@example.com')->send(new ContactMessage($validated));

        return back()->with('success', 'Thank you for your message! We\'ll get back to you soon.');
    }
}
