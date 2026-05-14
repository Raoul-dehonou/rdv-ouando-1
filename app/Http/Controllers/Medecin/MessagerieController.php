<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagerieController extends Controller
{
    public function index()
    {
        $contacts = User::where('role', 'patient')
            ->whereHas('sentMessages', function($query) {
                $query->where('receiver_id', Auth::id());
            })
            ->orWhereHas('receivedMessages', function($query) {
                $query->where('sender_id', Auth::id());
            })
            ->get();
        
        return view('medecin.messagerie.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = User::findOrFail($id);
        
        Message::where('receiver_id', Auth::id())
            ->where('sender_id', $id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        $messages = Message::where(function($query) use ($id) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $id);
            })
            ->orWhere(function($query) use ($id) {
                $query->where('sender_id', $id)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();
        
        $contacts = User::where('role', 'patient')
            ->whereHas('sentMessages', function($query) {
                $query->where('receiver_id', Auth::id());
            })
            ->orWhereHas('receivedMessages', function($query) {
                $query->where('sender_id', Auth::id());
            })
            ->get();
        
        return view('medecin.messagerie.show', compact('contact', 'messages', 'contacts'));
    }

    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);
        
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'content' => $request->message,   // ✅ colonne correcte
            'is_read' => false
        ]);
        
        return redirect()->back()->with('success', 'Message envoyé');
    }
}