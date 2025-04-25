<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;

class ContactReply extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $reply_message;

    public function __construct(Contact $contact, $reply_message)
    {
        $this->contact = $contact;
        $this->reply_message = $reply_message;
    }

    public function build()
    {
        return $this->subject('Phản hồi liên hệ từ quản trị viên')
                    ->view('emails.contact_reply');
    }
}

