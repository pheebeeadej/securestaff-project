<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public $title;

    public $description;

    public $footer;

    public $name;

    public $validityTime;

    public function __construct($otp, $title, $description, $footer = null, $name = null, $validityTime = 10)
    {
        $this->otp = $otp;
        $this->title = $title;
        $this->description = $description;
        $this->footer = $footer ?? 'If you did not request this, please ignore this email or contact our support team immediately. Never share this code with anyone, even if they claim to be from SimPlug.';
        $this->name = $name;
        $this->validityTime = $validityTime;
    }

    public function build()
    {
        $supportEmail = config('mail.from.address', 'support@example.com');

        return $this->subject($this->title)
            ->view('emails.otp_mail_template')
            ->with([
                'otp' => $this->otp,
                'title' => $this->title,
                'description' => $this->description,
                'footer' => $this->footer,
                'name' => $this->name,
                'validityTime' => $this->validityTime,
                'logoUrl' => asset('images/SimPlug-logo.png'),
                'supportEmail' => $supportEmail,
                'supportPhone' => null,
            ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
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
