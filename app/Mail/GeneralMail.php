<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $messageBody;

    public $name;

    public $heading;

    public $bannerTitle;

    public $bannerSubtitle;

    public $bannerIcon;

    public $buttonText;

    public $buttonUrl;

    public $notice;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $messageBody, $name = null, $heading = null, $bannerTitle = null, $bannerSubtitle = null, $bannerIcon = null, $buttonText = null, $buttonUrl = null, $notice = null)
    {
        $this->subject = $subject;
        $this->messageBody = $messageBody;
        $this->name = $name;
        $this->heading = $heading ?? $subject;
        $this->bannerTitle = $bannerTitle ?? $subject;
        $this->bannerSubtitle = $bannerSubtitle;
        $this->bannerIcon = $bannerIcon ?? '📧';
        $this->buttonText = $buttonText;
        $this->buttonUrl = $buttonUrl;
        $this->notice = $notice;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $supportEmail = config('mail.from.address', 'support@example.com');

        return $this->subject($this->subject)
            ->view('emails.general')
            ->with([
                'messageBody' => $this->messageBody,
                'name' => $this->name,
                'heading' => $this->heading,
                'subject' => $this->subject,
                'bannerTitle' => $this->bannerTitle,
                'bannerSubtitle' => $this->bannerSubtitle,
                'bannerIcon' => $this->bannerIcon,
                'buttonText' => $this->buttonText,
                'buttonUrl' => $this->buttonUrl,
                'notice' => $this->notice,
                'logoUrl' => asset('images/SimPlug-logo.png'),
                'supportEmail' => $supportEmail,
                'supportPhone' => null,
                'showSocialMedia' => true,
                'facebookUrl' => '#',
                'linkedinUrl' => '#',
                'twitterUrl' => '#',
                'instagramUrl' => '#',
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

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
