<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $email;
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct($otp, $email, $subject)
    {
        $this->otp = $otp;
        $this->email = $email;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */

   
    public function content(): Content
    {
        return new Content(
            view: 'emails.OtpVerification',
            with: [
                'otp' => $this->otp,
                'email' => $this->email,
            ]
        );

        // return $this->view('emails.OtpVerification')
        //             ->subject('OTP Verification')
        //             ->with([
        //                 'otp' => $this->otp,
        //                 'email' => $this->email,
        //             ]);

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
