<?php

use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Mail;

it('can submit the contact form', function () {
    Mail::fake();

    $this->post('/contact', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'subject' => 'Test Subject',
        'message' => 'This is a test message.',
    ])->assertRedirect();

    Mail::assertSent(ContactFormSubmission::class, function ($mail) {
        return $mail->data['name'] === 'John Doe'
            && $mail->data['email'] === 'john@example.com'
            && $mail->data['subject'] === 'Test Subject'
            && $mail->data['message'] === 'This is a test message.';
    });
});

it('requires a name', function () {
    $this->post('/contact', [
        'email' => 'john@example.com',
        'subject' => 'Test Subject',
        'message' => 'This is a test message.',
    ])->assertSessionHasErrors('name');
});

it('requires an email', function () {
    $this->post('/contact', [
        'name' => 'John Doe',
        'subject' => 'Test Subject',
        'message' => 'This is a test message.',
    ])->assertSessionHasErrors('email');
});

it('requires a valid email', function () {
    $this->post('/contact', [
        'name' => 'John Doe',
        'email' => 'invalid-email',
        'subject' => 'Test Subject',
        'message' => 'This is a test message.',
    ])->assertSessionHasErrors('email');
});

it('requires a subject', function () {
    $this->post('/contact', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'This is a test message.',
    ])->assertSessionHasErrors('subject');
});

it('requires a message', function () {
    $this->post('/contact', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'subject' => 'Test Subject',
    ])->assertSessionHasErrors('message');
});
