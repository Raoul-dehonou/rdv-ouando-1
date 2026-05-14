<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    // Liste des messages
    public function index()
    {
        $contacts = Contact::orderBy('date_envoi', 'desc')->paginate(15);
        $nonLus = Contact::where('lu', false)->count();
        $nonTraites = Contact::where('traite', false)->count();
        
        return view('admin.contacts.index', compact('contacts', 'nonLus', 'nonTraites'));
    }

    // Voir un message
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Marquer comme lu
        if (!$contact->lu) {
            $contact->lu = true;
            $contact->save();
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    // Marquer comme traité
    public function markAsTreated($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->traite = true;
        $contact->save();
        
        return redirect()->route('admin.contacts.index')->with('success', 'Message marqué comme traité');
    }

    // Marquer comme non traité
    public function markAsUntreated($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->traite = false;
        $contact->save();
        
        return redirect()->route('admin.contacts.index')->with('success', 'Message marqué comme non traité');
    }

    // Supprimer un message
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')->with('success', 'Message supprimé avec succès');
    }
}