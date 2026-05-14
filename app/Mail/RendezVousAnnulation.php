<?php

namespace App\Mail;

use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RendezVousAnnulation extends Mailable
{
    use Queueable, SerializesModels;

    public $rendezvous;
    public $patient;
    public $medecin;

    /**
     * Create a new message instance.
     */
    public function __construct(RendezVous $rendezvous)
    {
        $this->rendezvous = $rendezvous;
        $this->patient = $rendezvous->patient->user;
        $this->medecin = $rendezvous->medecin->user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Annulation de rendez-vous - SanteRDV',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rendezvous-annulation',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}