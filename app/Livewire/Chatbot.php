<?php

namespace App\Livewire;

use Livewire\Component;

class Chatbot extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $isOpen = false;
    public $isTyping = false;

    // Base de connaissances locale (pas besoin d'API)
    private $responses = [
        'grave' => [
            'keywords' => ['difficulte respirer', 'respire pas', 'suffoque', 'etouffe', 'douleur thoracique', 'poitrine', 'cardiaque', 'crise cardiaque', 'perte connaissance', 'evanouissement', 'coma', 'convulsion', 'crise epilepsie', 'saignement abondant', 'hemorragie', 'traumatisme grave', 'accident voiture', 'intoxication', 'overdose', 'ne repond plus'],
            'response' => "🚨 **URGENCE MÉDICALE DÉTECTÉE** 🚨\n\n⚠️ Les symptômes que vous décrivez semblent GRAVES et nécessitent une intervention immédiate.\n\n📞 **Appelez immédiatement les secours :**\n• Numéro d'urgence unique : **112**\n• Police/Gendarmerie : **117**\n• Pompiers : **118**\n\n⏱️ **En attendant les secours :**\n1️⃣ Restez calme et rassurez la personne\n2️⃣ Ne déplacez pas la personne sauf danger\n3️⃣ Si elle ne respire pas, commencez les gestes de premiers secours\n\n🔴 **NE PERDEZ PAS DE TEMPS, APPELEZ LE 112 !**"
        ],
        'modere' => [
            'keywords' => ['fievre', 'temperature', 'vomissement', 'diarrhee', 'douleur intense', 'migraine', 'fatigue extreme', 'toux persistante', 'gorge douloureuse', 'nez bouche', 'otite', 'douleur ventre', 'brulure', 'infection'],
            'response' => "🏥 **Consultation recommandée**\n\nD'après vos symptômes, une consultation médicale est recommandée dans les prochaines 24-48h.\n\n✅ **Conseils :**\n• Reposez-vous et buvez beaucoup d'eau\n• Évitez l'automédication\n• Surveillez l'évolution des symptômes\n\n📅 **Prenez rendez-vous rapidement :**\n👉 Cliquez sur 'Prendre RDV' sur notre page d'accueil\n\n📞 Si les symptômes s'aggravent, appelez le 112"
        ],
        'leger' => [
            'keywords' => ['petit bobo', 'coupure legere', 'bleu', 'ecchymose', 'demangeaison', 'allergie legere', 'eternuement', 'nez coule', 'gorge gratte', 'fatigue legere', 'courbature', 'rhume'],
            'response' => "🩹 **Conseils pour symptômes légers**\n\nLes symptômes que vous décrivez semblent légers.\n\n✅ **Recommandations :**\n• Nettoyez la zone avec de l'eau et du savon\n• Reposez-vous\n• Buvez beaucoup d'eau\n• Surveillez l'évolution\n\n📅 Si les symptômes persistent +48h, prenez rendez-vous.\n\n💊 Important : Ne prenez pas de médicaments sans avis médical."
        ]
    ];

    private $generalResponses = [
        'rdv' => "📅 **Prise de rendez-vous**\n\nPour prendre un rendez-vous :\n1️⃣ Créez votre compte ou connectez-vous\n2️⃣ Choisissez votre spécialité\n3️⃣ Sélectionnez un médecin\n4️⃣ Choisissez un créneau disponible\n5️⃣ Confirmez votre rendez-vous\n\n🔗 Cliquez sur 'Prendre RDV' sur notre page d'accueil.",
        
        'medecins' => "👨‍⚕️ **Nos spécialistes**\n\n• Cardiologues - Cœur\n• Neurologues - Système nerveux\n• Pédiatres - Enfants\n• Dentistes - Dents\n• Gynécologues - Femmes\n• Dermatologues - Peau\n• Ophtalmologistes - Yeux\n\n📅 Tous disponibles sur rendez-vous.",
        
        'tarifs' => "💰 **Nos tarifs**\n\n• Consultation générale : 5 000 FCFA\n• Consultation spécialiste : 10 000 FCFA\n• Téléconsultation : 4 000 FCFA\n• Soins dentaires : à partir de 10 000 FCFA\n• Vaccination : à partir de 4 000 FCFA",
        
        'horaires' => "🕐 **Horaires d'ouverture**\n\n• Lundi - Vendredi : 8h - 18h\n• Samedi : 9h - 16h\n• Dimanche : Fermé (urgence uniquement)\n\n📞 Urgence 24h/24 : 112",
        
        'adresse' => "📍 **Notre centre**\n\nCentre de santé de Ouando\nPorto-Novo, Bénin\n\n📞 Tél : +229 21 30 00 00\n📧 Email : contact@santerdv.bj",
        
        'vaccins' => "💉 **Vaccinations**\n\n• Enfants : BCG, Penta, ROR, Polio\n• Adultes : Tétanos, Grippe, Hépatite B\n• Voyage : Fièvre jaune, Typhoïde\n\n📅 Prenez rendez-vous !",
        
        'documents' => "📁 **Documents médicaux**\n\nAvec SanteRDV :\n• Téléchargez vos ordonnances\n• Partagez vos résultats\n• Accédez à votre historique médical\n\n🔒 Données sécurisées (HDS)",
        
        'bienvenue' => "👋 Bonjour ! Je suis l'assistant médical de SanteRDV.\n\n🔍 **Décrivez vos symptômes** (ex: j'ai mal à la tête, fièvre, etc.)\n📅 Ou dites-moi 'rendez-vous', 'tarifs', 'horaires', 'adresse'",
        
        'defaut' => "🤔 Je n'ai pas bien compris.\n\n🔍 **Décrivez vos symptômes** (mal à la tête, fièvre, douleur...)\n📅 **Ou dites-moi :**\n• 'rendez-vous'\n• 'tarifs'\n• 'horaires'\n• 'adresse'\n• 'médecins'\n• 'vaccins'\n\n🚨 En cas d'urgence, appelez le 112 !"
    ];

    public function mount()
    {
        $this->messages[] = [
            'type' => 'bot',
            'content' => $this->generalResponses['bienvenue'],
            'time' => now()->format('H:i')
        ];
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function clearChat()
    {
        $this->messages = [
            [
                'type' => 'bot',
                'content' => "🧹 Conversation effacée.\n\n" . $this->generalResponses['bienvenue'],
                'time' => now()->format('H:i')
            ]
        ];
    }

    public function sendMessage()
    {
        if (empty(trim($this->newMessage))) {
            return;
        }

        $userMessage = mb_strtolower(trim($this->newMessage), 'UTF-8');
        
        $this->messages[] = [
            'type' => 'user',
            'content' => $this->newMessage,
            'time' => now()->format('H:i')
        ];
        
        $this->newMessage = '';
        $this->isTyping = true;
        
        // Analyser le message et générer la réponse
        $response = $this->getResponse($userMessage);
        
        $this->isTyping = false;
        
        $this->messages[] = [
            'type' => 'bot',
            'content' => $response,
            'time' => now()->format('H:i')
        ];
        
        $this->dispatch('scrollToBottom');
    }
    
    private function getResponse($message)
    {
        // Supprimer les accents
        $message = $this->removeAccents($message);
        
        // 1. ANALYSE DES SYMPTÔMES (URGENCE EN PRIORITÉ)
        foreach ($this->responses as $niveau => $data) {
            foreach ($data['keywords'] as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    return $data['response'];
                }
            }
        }
        
        // 2. INTENTIONS SPÉCIFIQUES
        if (strpos($message, 'rendez-vous') !== false || 
            strpos($message, 'rdv') !== false || 
            strpos($message, 'prendre') !== false ||
            strpos($message, 'consultation') !== false) {
            return $this->generalResponses['rdv'];
        }
        
        if (strpos($message, 'medecin') !== false || 
            strpos($message, 'docteur') !== false || 
            strpos($message, 'specialiste') !== false) {
            return $this->generalResponses['medecins'];
        }
        
        if (strpos($message, 'prix') !== false || 
            strpos($message, 'tarif') !== false || 
            strpos($message, 'cout') !== false ||
            strpos($message, 'combien') !== false) {
            return $this->generalResponses['tarifs'];
        }
        
        if (strpos($message, 'horaire') !== false || 
            strpos($message, 'ouverture') !== false || 
            strpos($message, 'heure') !== false) {
            return $this->generalResponses['horaires'];
        }
        
        if (strpos($message, 'adresse') !== false || 
            strpos($message, 'ou') !== false || 
            strpos($message, 'localisation') !== false ||
            strpos($message, 'trouver') !== false) {
            return $this->generalResponses['adresse'];
        }
        
        if (strpos($message, 'vaccin') !== false || 
            strpos($message, 'vaccination') !== false) {
            return $this->generalResponses['vaccins'];
        }
        
        if (strpos($message, 'document') !== false || 
            strpos($message, 'ordonnance') !== false) {
            return $this->generalResponses['documents'];
        }
        
        if (strpos($message, 'bonjour') !== false || 
            strpos($message, 'salut') !== false || 
            strpos($message, 'hello') !== false) {
            return $this->generalResponses['bienvenue'];
        }
        
        // 3. ANALYSE GÉNÉRIQUE DES SYMPTÔMES
        $motsSante = ['mal', 'douleur', 'souffre', 'fatigue', 'fievre', 'toux', 'rhume', 'grippe', 'nausee', 'vertige'];
        foreach ($motsSante as $mot) {
            if (strpos($message, $mot) !== false) {
                return "🏥 **Analyse de vos symptômes**\n\nMerci de partager vos symptômes. Pour mieux vous aider :\n❓ **Depuis quand ?**\n❓ **Où se situe la douleur ?**\n❓ **Avez-vous de la fièvre ?**\n❓ **Autres symptômes ?**\n\n📅 Pour une consultation, prenez rendez-vous sur notre plateforme.\n\n🚨 **Si les symptômes sont graves**, appelez le 112 immédiatement.";
            }
        }
        
        // 4. RÉPONSE PAR DÉFAUT
        return $this->generalResponses['defaut'];
    }
    
    private function removeAccents($string)
    {
        $accents = [
            'à', 'â', 'ä', 'á', 'ã', 'å', 'ç', 'é', 'è', 'ê', 'ë', 
            'í', 'ì', 'î', 'ï', 'ñ', 'ó', 'ò', 'ô', 'ö', 'õ', 'ú', 
            'ù', 'û', 'ü', 'ý', 'ÿ'
        ];
        $sansAccents = [
            'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 
            'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 
            'u', 'u', 'u', 'y', 'y'
        ];
        return str_replace($accents, $sansAccents, $string);
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
}