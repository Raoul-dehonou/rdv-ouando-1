<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagerieController extends Controller
{
    public function index()
    {
        // Récupérer tous les médecins avec qui le patient a interagi
        $contacts = User::where('role', 'medecin')
            ->whereHas('medecin', function($query) {
                $query->where('is_active', true);
            })
            ->get();
        
        return view('patient.messagerie.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = User::findOrFail($id);
        
        // Marquer les messages reçus de ce contact comme lus
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
        
        $contacts = User::where('role', 'medecin')
            ->whereHas('medecin', function($query) {
                $query->where('is_active', true);
            })
            ->get();
        
        return view('patient.messagerie.show', compact('contact', 'messages', 'contacts'));
    }

    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);
        
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'message' => $request->message,
            'is_read' => false
        ]);
        
        return redirect()->back()->with('success', 'Message envoyé');
    }
}