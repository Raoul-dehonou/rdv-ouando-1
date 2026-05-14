<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Chat extends Component
{
    use WithFileUploads;

    public $user;
    public $chatMessages = [];
    public $newMessage;
    public $image; // pour l'upload

    public function mount($userId)
    {
        if (!Auth::check()) {
            abort(403);
        }
        $this->user = User::findOrFail($userId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $userId = Auth::id();
        $messages = Message::where(function($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $this->user->id);
            })->orWhere(function($query) use ($userId) {
                $query->where('sender_id', $this->user->id)
                      ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $this->chatMessages = $messages->toArray();

        // Marquer les messages reçus comme lus
        Message::where('receiver_id', $userId)
               ->where('sender_id', $this->user->id)
               ->update(['is_read' => true]);
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048', // max 2 Mo
        ]);

        if (empty($this->newMessage) && !$this->image) {
            return;
        }

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('chat_images', 'public');
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->user->id,
            'content' => $this->newMessage ?? '',
            'image' => $imagePath,
        ]);

        $this->chatMessages[] = $message->toArray();
        $this->newMessage = '';
        $this->image = null;

        $this->dispatch('messageSent');
    }

    public function render()
    {
        return view('livewire.chat');
    }
}