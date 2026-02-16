<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactFormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(ContactRequest $request): RedirectResponse
    {
        Mail::to(config('mail.from.address'))->send(
            new ContactFormSubmission($request->validated())
        );

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
