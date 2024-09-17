<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SocialMediaLoginCustomerCredentialMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

     public $customerIntialRandomPassword;

     public $customerEmail;
    public function __construct($randomPassword,$email)

    {
        
        $this->customerIntialRandomPassword=$randomPassword;

        $this->customerEmail=$email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Social Media Login Customer Credential Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        
        return new Content(
            view: 'mail.socailmedialoginusercredentialmail',
            with:[
                'customerpassword'=>$this->customerIntialRandomPassword,
                'email'=>$this->customerEmail
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
