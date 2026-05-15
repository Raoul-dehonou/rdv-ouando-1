<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Medecin\DashboardController as MedecinDashboardController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\RendezVousController as PatientRendezVousController;
use App\Http\Controllers\Patient\DossierController as PatientDossierController;
use App\Http\Controllers\Patient\DocumentController as PatientDocumentController;
use App\Http\Controllers\Patient\ProfilController as PatientProfilController;
use App\Http\Controllers\Patient\NotificationController as PatientNotificationController;
use App\Http\Controllers\Patient\MessagerieController as PatientMessagerieController;
use App\Http\Controllers\Medecin\RendezVousController as MedecinRendezVousController;
use App\Http\Controllers\Medecin\AgendaController;
use App\Http\Controllers\Medecin\PatientController as MedecinPatientController;
use App\Http\Controllers\Medecin\DisponibiliteController as MedecinDisponibiliteController;
use App\Http\Controllers\Medecin\ConsultationController as MedecinConsultationController;
use App\Http\Controllers\Medecin\ProfilController as MedecinProfilController;
use App\Http\Controllers\Medecin\NotificationController as MedecinNotificationController;
use App\Http\Controllers\Medecin\MessagerieController as MedecinMessagerieController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\UrgenceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConseilController;
use App\Http\Controllers\ChatbotController;
use App\Models\Medecin;

// ==============================================
// ROUTES PUBLIQUES
// ==============================================
Route::get('/', function () {
    $medecins = Medecin::with('user')->where('is_active', true)->get();
    return view('welcome', compact('medecins'));
})->name('home');

// Pages légales
Route::get('/confidentialite', fn() => view('legal.confidentialite'))->name('legal.confidentialite');
Route::get('/conditions-utilisation', fn() => view('legal.conditions'))->name('legal.conditions');
Route::get('/mentions-legales', fn() => view('legal.mentions'))->name('legal.mentions');
Route::get('/cookies', fn() => view('legal.cookies'))->name('legal.cookies');

// Pages services
Route::get('/services/consultations', fn() => view('services.consultations'))->name('service.consultations');
Route::get('/services/soins-dentaires', fn() => view('services.soins-dentaires'))->name('service.soins-dentaires');
Route::get('/services/soins-infirmiers', fn() => view('services.soins-infirmiers'))->name('service.soins-infirmiers');
Route::get('/services/vaccinations', fn() => view('services.vaccinations'))->name('service.vaccinations');
Route::get('/services/suivi-grossesse', fn() => view('services.suivi-grossesse'))->name('service.suivi-grossesse');
Route::get('/services/kinesitherapie', fn() => view('services.kinesitherapie'))->name('service.kinesitherapie');
Route::get('/services/depistage', fn() => view('services.depistage'))->name('service.depistage');

// Conseils santé
Route::get('/conseils', [ConseilController::class, 'index'])->name('conseils.index');
Route::get('/conseil/{id}', [ConseilController::class, 'show'])->name('conseil.show');
Route::get('/conseils-medicaux', fn() => view('conseils'))->name('conseils');

// Formulaire de contact public
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Alerte urgence publique
Route::post('/urgence', [UrgenceController::class, 'store'])->name('urgence.store');

// API Chatbot IA
Route::post('/api/chatbot/send', [ChatbotController::class, 'send'])->name('chatbot.send');

// Récupération des créneaux (public)
Route::get('/medecin/{medecin}/creneaux', [PatientRendezVousController::class, 'getCreneauxPublic'])->name('public.creneaux');

// ==============================================
// AUTHENTIFICATION
// ==============================================
require __DIR__.'/auth.php';

// ==============================================
// DASHBOARD PAR DÉFAUT (REDIRECTION SELON RÔLE)
// ==============================================
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($user && $user->role === 'medecin') {
        return redirect()->route('medecin.dashboard');
    }
    if ($user && $user->role === 'patient') {
        return redirect()->route('patient.dashboard');
    }
    
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==============================================
// PROFIL UTILISATEUR
// ==============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

// ==============================================
// ADMINISTRATEUR
// ==============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Patients
    Route::resource('patients', App\Http\Controllers\Admin\PatientController::class);
    
    // Médecins
    Route::resource('medecins', App\Http\Controllers\Admin\MedecinController::class);
    
    // Rendez-vous
    Route::prefix('rendez-vous')->name('rendez-vous.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\RendezVousController::class, 'index'])->name('index');
        Route::get('/calendar', [App\Http\Controllers\Admin\RendezVousController::class, 'calendar'])->name('calendar');
        Route::get('/create', [App\Http\Controllers\Admin\RendezVousController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\RendezVousController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Admin\RendezVousController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\RendezVousController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\RendezVousController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\RendezVousController::class, 'destroy'])->name('destroy');
    });
    
    // Consultations
    Route::resource('consultations', App\Http\Controllers\Admin\ConsultationController::class);
    
    // Services
    Route::resource('services', ServiceController::class);
    
    // Statistiques
    Route::get('/statistiques', [App\Http\Controllers\Admin\StatistiqueController::class, 'index'])->name('statistiques');
    
    // Alertes urgence
    Route::get('/urgences', [UrgenceController::class, 'index'])->name('urgences.index');
    Route::patch('/urgences/{id}/traitee', [UrgenceController::class, 'markAsTreated'])->name('urgences.traitee');
    
    // Messages contact
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactAdminController::class, 'index'])->name('index');
        Route::get('/{id}', [ContactAdminController::class, 'show'])->name('show');
        Route::patch('/{id}/traite', [ContactAdminController::class, 'markAsTreated'])->name('traite');
        Route::patch('/{id}/non-traite', [ContactAdminController::class, 'markAsUntreated'])->name('non-traite');
        Route::delete('/{id}', [ContactAdminController::class, 'destroy'])->name('destroy');
    });
});

// ==============================================
// MÉDECIN
// ==============================================
Route::middleware(['auth', 'role:medecin'])->prefix('medecin')->name('medecin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [MedecinDashboardController::class, 'index'])->name('dashboard');
    
    // Rendez-vous
    Route::prefix('rendez-vous')->name('rendez-vous.')->group(function () {
        Route::get('/', [MedecinRendezVousController::class, 'index'])->name('index');
        Route::get('/calendar', [MedecinRendezVousController::class, 'calendar'])->name('calendar');
        Route::get('/create', [MedecinRendezVousController::class, 'create'])->name('create');
        Route::post('/', [MedecinRendezVousController::class, 'store'])->name('store');
        Route::get('/{id}', [MedecinRendezVousController::class, 'show'])->name('show');
        Route::post('/{id}/update-statut', [MedecinRendezVousController::class, 'updateStatut'])->name('update-statut');
        Route::delete('/{id}', [MedecinRendezVousController::class, 'destroy'])->name('destroy');
    });
    
    // Agenda
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
    
    // Patients
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', [MedecinPatientController::class, 'index'])->name('index');
        Route::get('/{id}', [MedecinPatientController::class, 'show'])->name('show');
        Route::get('/{id}/dossier', [MedecinPatientController::class, 'dossierMedical'])->name('dossier');
    });
    
    // Disponibilités
    Route::prefix('disponibilites')->name('disponibilites.')->group(function () {
        Route::get('/', [MedecinDisponibiliteController::class, 'index'])->name('index');
        Route::post('/', [MedecinDisponibiliteController::class, 'store'])->name('store');
        // Modification ici : {id} devient {disponibilite} pour le model binding
        Route::delete('/{disponibilite}', [MedecinDisponibiliteController::class, 'destroy'])->name('destroy');
    });
    
    // Consultations
    Route::resource('consultations', MedecinConsultationController::class);
    Route::get('/consultations/create/{rendezvous}', [MedecinConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/consultations/{rendezvous}', [MedecinConsultationController::class, 'store'])->name('consultations.store');
    
    // Profil médecin
    Route::get('/profil', [MedecinProfilController::class, 'edit'])->name('profile');
    Route::put('/profil', [MedecinProfilController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [MedecinProfilController::class, 'updatePassword'])->name('profile.update-password');
    
    // Notifications
    Route::get('/notifications', [MedecinNotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{notification}/read', [MedecinNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [MedecinNotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    
    // Messagerie
    Route::prefix('messagerie')->name('messagerie.')->group(function () {
        Route::get('/', [MedecinMessagerieController::class, 'index'])->name('index');
        Route::get('/{id}', [MedecinMessagerieController::class, 'show'])->name('show');
        Route::post('/{id}/send', [MedecinMessagerieController::class, 'send'])->name('send');
    });
    
    // Route directe pour la messagerie (alternative)
    Route::get('/messagerie', [MedecinMessagerieController::class, 'index'])->name('messagerie.index');
});

// ==============================================
// PATIENT
// ==============================================
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
    
    // Rendez-vous
    Route::prefix('rendez-vous')->name('rendez-vous.')->group(function () {
        Route::get('/', [PatientRendezVousController::class, 'index'])->name('index');
        Route::get('/create', [PatientRendezVousController::class, 'create'])->name('create');
        Route::post('/', [PatientRendezVousController::class, 'store'])->name('store');
        Route::get('/{id}', [PatientRendezVousController::class, 'show'])->name('show');
        Route::delete('/{id}', [PatientRendezVousController::class, 'destroy'])->name('destroy');
    });
    
    // Médecins et créneaux
    Route::get('/medecins', [PatientRendezVousController::class, 'getMedecinsBySpecialite'])->name('medecins');
    Route::get('/creneaux', [PatientRendezVousController::class, 'getCreneauxDisponibles'])->name('creneaux');
    
    // Dossier médical
    Route::prefix('dossier')->name('dossier.')->group(function () {
        Route::get('/', [PatientDossierController::class, 'index'])->name('index');
        Route::get('/consultation/{id}', [PatientDossierController::class, 'showConsultation'])->name('consultation.show');
        Route::get('/pdf', [PatientDossierController::class, 'downloadPdf'])->name('pdf');
        Route::get('/consultation/{id}/pdf', [PatientDossierController::class, 'downloadConsultationPdf'])->name('consultation.pdf');
    });
    
    // Documents
    Route::resource('documents', PatientDocumentController::class);
    
    // Profil patient
    Route::get('/profil', [PatientProfilController::class, 'edit'])->name('profile');
    Route::put('/profil', [PatientProfilController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [PatientProfilController::class, 'updatePassword'])->name('profile.update-password');
    
    // Notifications
    Route::get('/notifications', [PatientNotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{notification}/read', [PatientNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [PatientNotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    
    // Messagerie
    Route::prefix('messagerie')->name('messagerie.')->group(function () {
        Route::get('/', [PatientMessagerieController::class, 'index'])->name('index');
        Route::get('/{id}', [PatientMessagerieController::class, 'show'])->name('show');
        Route::post('/{id}/send', [PatientMessagerieController::class, 'send'])->name('send');
    });
    
    // Route directe pour la messagerie
    Route::get('/messagerie', [PatientMessagerieController::class, 'index'])->name('messagerie');
});

// ==============================================
// CHAT (commun)
// ==============================================
Route::middleware('auth')->group(function () {
    Route::get('/chat/{user}', function ($userId) {
        $user = \App\Models\User::findOrFail($userId);
        $authUser = auth()->user();
        
        if (($authUser->role === 'patient' && $user->role === 'medecin') ||
            ($authUser->role === 'medecin' && $user->role === 'patient')) {
            return view('chat', compact('userId'));
        }
        abort(403);
    })->name('chat.show');
});