<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class NewMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The new message instance.
     *
     * @var \App\Models\Message
     */
    // --- THIS IS THE FIX ---
    // Renamed from '$message' to '$newMessage'
    public $newMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Message $message)
    {
        // --- THIS IS THE FIX ---
        $this->newMessage = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Set the "From" address using the sender's info
            // --- THIS IS THE FIX ---
            from: new Address($this->newMessage->email, $this->newMessage->name),
            subject: 'New Portfolio Contact Form Message',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // This tells Laravel to use a simple text-based email
        // and pass the message content to it.
        return new Content(
            text: 'mail.new-message-text'
            // The public '$newMessage' property is automatically
            // passed to the 'mail.new-message-text' view.
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

