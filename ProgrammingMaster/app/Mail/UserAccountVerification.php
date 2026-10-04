<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserAccountVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $lastName;
    public $email;
    public $description;
    public $userId;
    public $otp;

    /**
     * Create a new message instance.
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $description
     * @param int $userId
     * @param string $otp
     */
    public function __construct($firstName, $lastName, $email, $userId)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->userId = $userId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Account Verification'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.account_verification'
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
