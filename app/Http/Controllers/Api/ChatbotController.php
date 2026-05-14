<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    // Connaissances de base du chatbot SanteRDV
    private $knowledgeBase = [
        'greetings' => [
            'bonjour', 'salut', 'hello', 'coucou', 'hey', 'bonsoir', 'bienvenue'
        ],
        'farewell' => [
            'au revoir', 'bye', 'merci au revoir', 'à bientôt', 'ciao'
        ],
        'appointment' => [
            'rendez-vous', 'rdv', 'prendre rendez-vous', 'consulter', 'prendre rdv'
        ],
        'doctor' => [
            'médecin', 'docteur', 'spécialiste', 'cardiologue', 'dentiste', 'pédiatre'
        ],
        'price' => [
            'prix', 'tarif', 'coût', 'combien', 'tarifs', 'coûte'
        ],
        'opening' => [
            'horaire', 'ouverture', 'fermeture', 'quand', 'horaires'
        ],
        'location' => [
            'adresse', 'où', 'localisation', 'trouver', 'centre'
        ],
        'emergency' => [
            'urgence', 'urgent', 'secours', 'urgence médicale', 'appeler secours'
        ],
        'vaccination' => [
            'vaccin', 'vaccination', 'vacciner', 'covid', 'grippe'
        ],
        'documents' => [
            'document', 'ordonnance', 'résultat', 'analyse', 'certificat'
        ],
        'account' => [
            'compte', 'inscription', 'créer compte', 'se connecter', 'login'
        ],
        'consultation' => [
            'consultation', 'téléconsultation', 'visio', 'en ligne'
        ]
    ];

    private $responses = [
        'greetings' => "Bonjour ! 👋 Je suis l'assistant virtuel de SanteRDV. Comment puis-je vous aider aujourd'hui ?\n\n💡 Je peux vous aider à :\n• Prendre rendez-vous avec un médecin\n• Connaître nos tarifs et horaires\n• Obtenir des informations sur nos services\n• Vous orienter en cas d'urgence\n\nQue souhaitez-vous savoir ?",
        
        'farewell' => "Merci d'avoir utilisé SanteRDV ! 👋 N'hésitez pas à revenir vers moi si vous avez d'autres questions. Prenez soin de vous ! 💙",
        
        'appointment' => "📅 Pour prendre un rendez-vous :\n\n1️⃣ Créez votre compte ou connectez-vous\n2️⃣ Choisissez votre spécialité\n3️⃣ Sélectionnez un médecin\n4️⃣ Choisissez un créneau disponible\n5️⃣ Confirmez votre rendez-vous\n\n🔗 Vous pouvez aussi cliquer sur 'Prendre RDV' sur notre page d'accueil.\n\nSouhaitez-vous que je vous guide pas à pas ?",
        
        'doctor' => "👨‍⚕️ Nos médecins experts :\n\n• Cardiologues - Soins du cœur\n• Neurologues - Système nerveux\n• Pédiatres - Enfants et adolescents\n• Dentistes - Soins bucco-dentaires\n• Gynécologues - Santé de la femme\n• Dermatologues - Peau et cheveux\n\nTous nos médecins sont diplômés et expérimentés. Souhaitez-vous prendre rendez-vous avec un spécialiste en particulier ?",
        
        'price' => "💰 Nos tarifs :\n\n• Consultation générale : 5 000 FCFA\n• Consultation spécialiste : 10 000 FCFA\n• Téléconsultation : 4 000 FCFA\n• Soins dentaires : à partir de 10 000 FCFA\n• Vaccination : à partir de 4 000 FCFA\n\n📌 Les tarifs peuvent varier selon les prestations. Une mutuelle est-elle prise en charge ?",
        
        'opening' => "🕐 Nos horaires d'ouverture :\n\n• Lundi - Vendredi : 8h00 - 18h00\n• Samedi : 9h00 - 16h00\n• Dimanche : Fermé (service urgence uniquement)\n\n📞 Urgence 24h/24 : Appelez le 112\n\nNos créneaux sont disponibles en ligne 24h/24 pour la prise de rendez-vous.",
        
        'location' => "📍 Notre adresse :\n\nCentre de santé de Ouando\nPorto-Novo, Bénin\n\n📞 Téléphone : +229 21 30 00 00\n📧 Email : contact@santerdv.bj\n\nSouhaitez-vous que je vous donne l'itinéraire ?",
        
        'emergency' => "🚨 URGENCE MÉDICALE 🚨\n\nSi vous ou un proche présentez des symptômes graves, appelez immédiatement :\n\n📞 Numéro d'urgence unique : 112\n📞 Police / Gendarmerie : 117\n📞 Pompiers : 118\n\n⚠️ Ne perdez pas de temps, appelez les secours !\n\nSi la situation ne relève pas des secours immédiats, vous pouvez remplir notre formulaire d'alerte sur la page d'accueil.",
        
        'vaccination' => "💉 Service Vaccination :\n\nNous proposons :\n• Vaccins enfants (BCG, Penta, ROR, Polio)\n• Vaccins adultes (Tétanos, Grippe, Hépatite B)\n• Vaccins voyage (Fièvre jaune, Typhoïde)\n\n📅 Prenez rendez-vous pour vos vaccinations sur notre plateforme. Les rappels sont automatiques par SMS !",
        
        'documents' => "📁 Gestion des documents :\n\nAvec SanteRDV, vous pouvez :\n• Télécharger vos ordonnances\n• Partager vos résultats d'analyses\n• Accéder à votre historique médical\n• Stocker vos certificats médicaux\n\nTous vos documents sont sécurisés et conformes HDS.",
        
        'account' => "🔐 Création de compte :\n\nPour créer votre compte :\n1️⃣ Cliquez sur 'Inscription'\n2️⃣ Remplissez vos informations\n3️⃣ Validez votre email\n4️⃣ Connectez-vous\n\n✅ C'est gratuit et rapide ! Vous pourrez ensuite prendre des rendez-vous en ligne.",
        
        'consultation' => "💻 Téléconsultation :\n\nConsultez vos médecins à distance :\n• Depuis chez vous\n• Sans déplacement\n• Horaires flexibles\n• Suivi médical simplifié\n\n📹 Tout ce dont vous avez besoin : un smartphone ou ordinateur avec une connexion internet.",
        
        'default' => "🤔 Je n'ai pas bien compris votre demande. Voici ce que je peux faire pour vous :\n\n📅 Prendre un rendez-vous\n👨‍⚕️ Informations sur les médecins\n💰 Tarifs des consultations\n🕐 Horaires d'ouverture\n📍 Adresse du centre\n🚨 Urgence médicale\n💉 Vaccinations\n📁 Documents médicaux\n\nPouvez-vous reformuler votre question ?"
    ];

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = strtolower(trim($request->message));
        $response = $this->getAIResponse($userMessage);

        return response()->json([
            'success' => true,
            'response' => $response,
            'user_message' => $request->message
        ]);
    }

    private function getAIResponse($message)
    {
        // Détection des intentions
        foreach ($this->knowledgeBase as $intent => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    return $this->responses[$intent] ?? $this->responses['default'];
                }
            }
        }

        // Détection des questions spécifiques
        if (strpos($message, '?') !== false) {
            if (strpos($message, 'prix') !== false || strpos($message, 'coût') !== false) {
                return $this->responses['price'];
            }
            if (strpos($message, 'horaire') !== false || strpos($message, 'heure') !== false) {
                return $this->responses['opening'];
            }
        }

        // Réponse par défaut
        return $this->responses['default'];
    }

    // Méthode pour entraîner le bot avec des réponses personnalisées
    public function train(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'intent' => 'required|string'
        ]);

        // Ajouter la nouvelle connaissance
        if (!isset($this->knowledgeBase[$request->intent])) {
            $this->knowledgeBase[$request->intent] = [];
        }
        
        $this->knowledgeBase[$request->intent][] = strtolower($request->question);
        
        // Sauvegarder dans un fichier ou base de données
        // Pour cet exemple, on retourne juste un succès
        
        return response()->json([
            'success' => true,
            'message' => 'Nouvelle connaissance ajoutée avec succès'
        ]);
    }
}