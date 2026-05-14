<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConseilController extends Controller
{
    // Liste de tous les conseils
    public function index()
    {
        $conseils = [
            [
                'id' => 1,
                'titre' => '5 aliments à privilégier pour booster votre immunité',
                'categorie' => 'Nutrition',
                'couleur_categorie' => '#1a6fff',
                'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=500&h=300&fit=crop',
                'resume' => 'Découvrez les aliments riches en vitamines qui renforcent vos défenses naturelles.',
                'contenu' => 'Les agrumes comme l\'orange et le citron sont riches en vitamine C, essentielle pour stimuler le système immunitaire. Le miel, reconnu pour ses propriétés antibactériennes, aide à lutter contre les infections. L\'ail contient de l\'allicine, un composé sulfuré qui renforce les défenses naturelles. Les épinards sont riches en fer, magnésium et vitamines A, C, E et K. Enfin, le gingembre possède des propriétés anti-inflammatoires et antioxydantes puissantes.'
            ],
            [
                'id' => 2,
                'titre' => 'Les bienfaits d\'une activité physique régulière',
                'categorie' => 'Sport',
                'couleur_categorie' => '#43A047',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=300&fit=crop',
                'resume' => 'Comment 30 minutes d\'exercice par jour peuvent transformer votre santé.',
                'contenu' => 'L\'activité physique régulière réduit les risques de maladies cardiovasculaires, d\'obésité et de diabète de type 2. Elle améliore la qualité du sommeil, réduit le stress et l\'anxiété. La marche rapide, le vélo ou la natation sont d\'excellentes options. L\'OMS recommande au moins 150 minutes d\'activité modérée par semaine pour les adultes.'
            ],
            [
                'id' => 3,
                'titre' => 'Les clés d\'un sommeil réparateur',
                'categorie' => 'Bien-être',
                'couleur_categorie' => '#E53935',
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=500&h=300&fit=crop',
                'resume' => 'Adoptez les bonnes habitudes pour mieux dormir et récupérer.',
                'contenu' => 'Un adulte a besoin de 7 à 9 heures de sommeil par nuit. Pour un sommeil réparateur, maintenez des horaires réguliers, évitez les écrans avant le coucher, créez un environnement calme et sombre, et évitez la caféine en fin de journée. La méditation et la lecture peuvent aider à s\'endormir plus facilement.'
            ],
            [
                'id' => 4,
                'titre' => 'L\'hydratation : l\'or liquide de votre santé',
                'categorie' => 'Hydratation',
                'couleur_categorie' => '#1a6fff',
                'image' => 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=500&h=300&fit=crop',
                'resume' => 'Pourquoi boire suffisamment d\'eau est essentiel à votre bien-être.',
                'contenu' => 'L\'eau représente environ 60% du corps humain. Une bonne hydratation améliore la concentration, régule la température corporelle, facilite la digestion et maintient une peau saine. Buvez environ 1,5 à 2 litres d\'eau par jour, et plus en cas d\'activité physique ou de fortes chaleurs. Les tisanes et les fruits riches en eau comme la pastèque sont également recommandés.'
            ],
            [
                'id' => 5,
                'titre' => 'Prévenir le stress au quotidien',
                'categorie' => 'Santé mentale',
                'couleur_categorie' => '#43A047',
                'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=500&h=300&fit=crop',
                'resume' => 'Des techniques simples pour gérer votre stress efficacement.',
                'contenu' => 'Le stress chronique peut avoir des effets néfastes sur votre santé. Pratiquez la respiration profonde, méditez 10 minutes par jour, faites du sport régulièrement, et accordez-vous des pauses. Identifiez les sources de votre stress et apprenez à déléguer. Le yoga et la sophrologie sont d\'excellentes méthodes pour retrouver votre calme intérieur.'
            ],
            [
                'id' => 6,
                'titre' => 'Les bienfaits des fruits et légumes de saison',
                'categorie' => 'Nutrition',
                'couleur_categorie' => '#1a6fff',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=300&fit=crop',
                'resume' => 'Pourquoi consommer des produits frais et locaux est meilleur pour votre santé.',
                'contenu' => 'Les fruits et légumes de saison sont plus riches en nutriments car ils sont récoltés à maturité. Ils contiennent plus de vitamines, de minéraux et d\'antioxydants. De plus, ils sont plus savoureux et moins chers. Privilégiez les circuits courts et les producteurs locaux pour une alimentation saine et responsable.'
            ]
        ];

        // Pagination manuelle (6 éléments par page)
        $perPage = 6;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedConseils = array_slice($conseils, $offset, $perPage);
        
        $conseilsCollection = collect($paginatedConseils);
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $conseilsCollection,
            count($conseils),
            $perPage,
            $currentPage,
            ['path' => route('conseils.index')]
        );

        return view('conseils.index', ['conseils' => $paginator]);
    }

    // Afficher un conseil spécifique
    public function show($id)
    {
        $tousConseils = [
            [
                'id' => 1,
                'titre' => '5 aliments à privilégier pour booster votre immunité',
                'categorie' => 'Nutrition',
                'couleur_categorie' => '#1a6fff',
                'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&h=500&fit=crop',
                'resume' => 'Découvrez les aliments riches en vitamines qui renforcent vos défenses naturelles.',
                'contenu' => '<p>Les agrumes comme l\'orange et le citron sont riches en vitamine C, essentielle pour stimuler le système immunitaire. Le miel, reconnu pour ses propriétés antibactériennes, aide à lutter contre les infections. L\'ail contient de l\'allicine, un composé sulfuré qui renforce les défenses naturelles. Les épinards sont riches en fer, magnésium et vitamines A, C, E et K. Enfin, le gingembre possède des propriétés anti-inflammatoires et antioxydantes puissantes.</p>
                <p class="mt-4">Pour bénéficier pleinement de ces bienfaits, intégrez ces aliments dans votre alimentation quotidienne. Une cure de vitamines peut être bénéfique, mais rien ne remplace une alimentation variée et équilibrée.</p>
                <h3 class="text-lg font-bold mt-6 mb-3">Recette express : Smoothie immunité</h3>
                <p>Mélangez 1 orange pressée, 1 cuillère à café de miel, 1 petit morceau de gingembre frais et 2 épinards frais. Mixez le tout et dégustez immédiatement !</p>'
            ],
            [
                'id' => 2,
                'titre' => 'Les bienfaits d\'une activité physique régulière',
                'categorie' => 'Sport',
                'couleur_categorie' => '#43A047',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=500&fit=crop',
                'resume' => 'Comment 30 minutes d\'exercice par jour peuvent transformer votre santé.',
                'contenu' => '<p>L\'activité physique régulière réduit les risques de maladies cardiovasculaires, d\'obésité et de diabète de type 2. Elle améliore la qualité du sommeil, réduit le stress et l\'anxiété. La marche rapide, le vélo ou la natation sont d\'excellentes options. L\'OMS recommande au moins 150 minutes d\'activité modérée par semaine pour les adultes.</p>
                <p class="mt-4">Commencez doucement : 10 minutes de marche par jour, puis augmentez progressivement. L\'important est la régularité, pas l\'intensité. Choisissez une activité qui vous plaît pour rester motivé.</p>'
            ],
            // ... ajoutez les autres conseils avec contenu détaillé
        ];

        $conseil = collect($tousConseils)->firstWhere('id', (int)$id);

        if (!$conseil) {
            abort(404);
        }

        return view('conseils.show', compact('conseil'));
    }
}