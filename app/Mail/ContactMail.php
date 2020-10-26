<?php

namespace App\Mail;

use App\Models\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Mail
     */
    private $email;

    /**
     * Create a new message instance.
     *
     * @param Mail $email
     */
    public function __construct(Mail $email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email->email)
            ->subject("Email forwarded from the site")
            ->markdown('emails.contact')->with('email', $this->email);
    }
}
