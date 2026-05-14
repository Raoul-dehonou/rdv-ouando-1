<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Document;

class NouveauDocumentAjoute extends Notification
{
    use Queueable;

    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Nouveau document disponible',
            'message' => 'Un nouveau document "'. $this->document->titre .'" a été ajouté à votre dossier médical.',
            'document_id' => $this->document->id,
        ];
    }
}