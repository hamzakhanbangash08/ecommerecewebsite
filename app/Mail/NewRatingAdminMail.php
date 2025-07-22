<?php

namespace App\Mail;

use App\Models\Rating;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRatingAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $rating;

    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    public function build()
    {
        return $this->subject('📬 New Product Rating Submitted')
            ->view('emails.admin_rating');
    }
}
