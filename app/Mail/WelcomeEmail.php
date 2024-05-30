<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    private User $user;
    //we can set a private property to store the user

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user=$user;
        //we create an instance by passing a user object to the constructor
    }

    /**
     * Get the message envelope.
     * Header of the email
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thanks for joining'. config('app.name',''),

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    //we can pass the user to the view by adding it with the with key
    {
        return new Content(
            view: 'emails.welcome-email',
            with:[
                'user'=>$this->user
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
        return [Attachment::fromStorageDisk("public","profile/l22G8K08FLaMUdDNMLos8swNP91ru9COCYh3KVOD.png")];
    }
}
