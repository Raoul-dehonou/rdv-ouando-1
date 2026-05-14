<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Conseils médicaux - SanteRDV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .card-conseil {
            transition: all 0.3s ease;
        }
        .card-conseil:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(26, 111, 255, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('accueil') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-[#1a6fff] rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-[#1a6fff]">SanteRDV</span>
                </a>
                <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-[#1a6fff] transition text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </header>

    <!-- Section principale -->
    <main>
        <!-- En-tête -->
        <section class="bg-gradient-to-r from-[#1a6fff] to-[#0d5ae0] text-white py-16">
            <div class="container mx-auto px-6 text-center">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mb-4">
                    <i class="fas fa-lightbulb text-yellow-300 text-sm"></i>
                    <span class="text-sm font-medium">Bien-être & Santé</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Conseils médicaux</h1>
                <p class="text-xl text-white/90 max-w-2xl mx-auto">Des articles et conseils rédigés par nos experts pour prendre soin de votre santé au quotidien.</p>
            </div>
        </section>

        <!-- Grille des conseils -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Conseil 1 - Alimentation saine -->
                    <div class="card-conseil bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-aos="fade-up" data-aos-duration="800">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('images/conseils/alimentation.jpg') }}" alt="Alimentation saine" class="w-full h-full object-cover"
                                 onerror="this.src='https://placehold.co/600x400/1a6fff/white?text=Alimentation+Saine'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full">Nutrition</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Les bases d'une alimentation saine</h3>
                            <p class="text-gray-600 text-sm mb-4">Découvrez les principes fondamentaux pour adopter une alimentation équilibrée et bénéfique pour votre santé.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> 5 min de lecture</span>
                                <button onclick="openArticle(1)" class="text-[#1a6fff] hover:text-[#0d5ae0] font-semibold text-sm flex items-center gap-1">
                                    Lire la suite <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Conseil 2 - Activité physique -->
                    <div class="card-conseil bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('images/conseils/sport.jpg') }}" alt="Activité physique" class="w-full h-full object-cover"
                                 onerror="this.src='https://placehold.co/600x400/1a6fff/white?text=Activité+Physique'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full">Sport</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Bouger pour sa santé</h3>
                            <p class="text-gray-600 text-sm mb-4">Pourquoi l'activité physique est essentielle et comment l'intégrer facilement dans votre quotidien.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> 4 min de lecture</span>
                                <button onclick="openArticle(2)" class="text-[#1a6fff] hover:text-[#0d5ae0] font-semibold text-sm flex items-center gap-1">
                                    Lire la suite <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Conseil 3 - Gestion du stress -->
                    <div class="card-conseil bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('images/conseils/stress.jpg') }}" alt="Gestion du stress" class="w-full h-full object-cover"
                                 onerror="this.src='https://placehold.co/600x400/1a6fff/white?text=Gestion+du+Stress'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-purple-500 text-white text-xs px-3 py-1 rounded-full">Bien-être</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mieux gérer son stress au quotidien</h3>
                            <p class="text-gray-600 text-sm mb-4">Des techniques simples et efficaces pour réduire votre stress et améliorer votre qualité de vie.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> 6 min de lecture</span>
                                <button onclick="openArticle(3)" class="text-[#1a6fff] hover:text-[#0d5ae0] font-semibold text-sm flex items-center gap-1">
                                    Lire la suite <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Conseil 4 - Sommeil réparateur -->
                    <div class="card-conseil bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('images/conseils/sommeil.jpg') }}" alt="Sommeil" class="w-full h-full object-cover"
                                 onerror="this.src='https://placehold.co/600x400/1a6fff/white?text=Bon+Sommeil'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-indigo-500 text-white text-xs px-3 py-1 rounded-full">Sommeil</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Les secrets d'un sommeil réparateur</h3>
                            <p class="text-gray-600 text-sm mb-4">Adoptez les bonnes habitudes pour retrouver un sommeil de qualité et vous réveiller en forme.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> 5 min de lecture</span>
                                <button onclick="openArticle(4)" class="text-[#1a6fff] hover:text-[#0d5ae0] font-semibold text-sm flex items-center gap-1">
                                    Lire la suite <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Conseil 5 - Vaccination -->
                    <div class="card-conseil bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('images/conseils/vaccination.jpg') }}" alt="Vaccination" class="w-full h-full object-cover"
                                 onerror="this.src='https://placehold.co/600x400/1a6fff/white?text=Vaccination'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full">Prévention</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">L'importance de la vaccination</h3>
                            <p class="text-gray-600 text-sm mb-4">Pourquoi se faire vacciner et quel est le calendrier vaccinal recommandé.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> 7 min de lecture</span>
                                <button onclick="openArticle(5)" class="text-[#1a6fff] hover:text-[#0d5ae0] font-semibold text-sm flex items-center gap-1">
                                    Lire la suite <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Conseil 6 - Santé dentaire -->
                    <div class="card-conseil bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('images/conseils/dentaire.jpg') }}" alt="Santé dentaire" class="w-full h-full object-cover"
                                 onerror="this.src='https://placehold.co/600x400/1a6fff/white?text=Santé+Dentaire'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-cyan-500 text-white text-xs px-3 py-1 rounded-full">Dentaire</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Bien prendre soin de ses dents</h3>
                            <p class="text-gray-600 text-sm mb-4">Les gestes simples pour une hygiène bucco-dentaire irréprochable.</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> 4 min de lecture</span>
                                <button onclick="openArticle(6)" class="text-[#1a6fff] hover:text-[#0d5ae0] font-semibold text-sm flex items-center gap-1">
                                    Lire la suite <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modale article -->
        <div id="articleModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 hidden" style="display: none;">
            <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[85vh] overflow-y-auto shadow-2xl">
                <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                    <h3 id="modalTitle" class="text-2xl font-bold text-gray-800">Article</h3>
                    <button onclick="closeArticle()" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>
                <div class="p-6" id="modalContent">
                    <!-- Contenu de l'article -->
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-12">
        <div class="container mx-auto px-6 py-8">
            <div class="text-center">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} SanteRDV. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800, offset: 100 });

        const articles = {
            1: {
                title: "Les bases d'une alimentation saine",
                content: `<div class="prose max-w-none">
                    <h2>Une alimentation équilibrée : la clé d'une bonne santé</h2>
                    <p>L'alimentation joue un rôle fondamental dans notre santé. Une alimentation équilibrée permet de prévenir de nombreuses maladies et d'améliorer notre bien-être au quotidien.</p>
                    
                    <h3>Les 7 règles d'or :</h3>
                    <ul>
                        <li><strong>Manger varié :</strong> Alternez les aliments pour couvrir tous vos besoins nutritionnels.</li>
                        <li><strong>Privilégier les fruits et légumes :</strong> Au moins 5 portions par jour.</li>
                        <li><strong>Limiter les sucres rapides :</strong> Évitez les sodas, pâtisseries, bonbons.</li>
                        <li><strong>Boire suffisamment d'eau :</strong> 1,5 à 2 litres par jour.</li>
                        <li><strong>Manger à heures régulières :</strong> 3 repas par jour, sans sauter.</li>
                        <li><strong>Privilégier les cuissons douces :</strong> À la vapeur, au four, à l'étouffée.</li>
                        <li><strong>Prendre le temps de manger :</strong> Mâchez lentement, savourez vos repas.</li>
                    </ul>
                    
                    <h3>Les aliments à privilégier :</h3>
                    <ul>
                        <li>Fruits et légumes frais et de saison</li>
                        <li>Légumes secs (lentilles, pois chiches, haricots)</li>
                        <li>Poissons (au moins 2 fois par semaine)</li>
                        <li>Huiles végétales (olive, colza, noix)</li>
                        <li>Céréales complètes (pain complet, riz complet, quinoa)</li>
                    </ul>
                    
                    <p>N'oubliez pas : l'équilibre alimentaire ne se joue pas sur un repas mais sur la semaine. Une alimentation variée et plaisir sont compatibles !</p>
                </div>`
            },
            2: {
                title: "Bouger pour sa santé",
                content: `<div class="prose max-w-none">
                    <h2>L'activité physique : un médicament naturel</h2>
                    <p>L'activité physique régulière est essentielle pour rester en bonne santé. Elle prévient de nombreuses maladies chroniques et améliore la qualité de vie.</p>
                    
                    <h3>Les bienfaits de l'activité physique :</h3>
                    <ul>
                        <li>Renforce le système cardiovasculaire</li>
                        <li>Améliore la qualité du sommeil</li>
                        <li>Réduit le stress et l'anxiété</li>
                        <li>Maintient un poids santé</li>
                        <li>Renforce les muscles et les os</li>
                        <li>Améliore la mémoire et les capacités cognitives</li>
                    </ul>
                    
                    <h3>Combien d'activité physique par semaine ?</h3>
                    <p>Au moins 30 minutes d'activité modérée 5 fois par semaine. Cela peut être :</p>
                    <ul>
                        <li>Marche rapide</li>
                        <li>Vélo</li>
                        <li>Natation</li>
                        <li>Course à pied</li>
                        <li>Danse</li>
                    </ul>
                    <p>Le plus important : choisissez une activité qui vous plaît pour tenir sur la durée !</p>
                </div>`
            },
            3: {
                title: "Mieux gérer son stress au quotidien",
                content: `<div class="prose max-w-none">
                    <h2>Apprivoiser son stress pour mieux vivre</h2>
                    <p>Le stress fait partie de notre vie quotidienne, mais lorsqu'il devient excessif, il peut nuire à notre santé. Voici des techniques pour mieux le gérer.</p>
                    
                    <h3>Techniques anti-stress :</h3>
                    <ul>
                        <li><strong>La respiration profonde :</strong> Inspirez par le nez (4 sec), bloque (4 sec), expirez par la bouche (6 sec).</li>
                        <li><strong>La méditation :</strong> 10 minutes par jour pour se recentrer.</li>
                        <li><strong>Le sport :</strong> Libère des endorphines, les hormones du bonheur.</li>
                        <li><strong>Le sommeil :</strong> Un sommeil réparateur est essentiel.</li>
                        <li><strong>L'organisation :</strong> Planifiez vos tâches, évitez la surcharge.</li>
                    </ul>
                    
                    <h3>Quand consulter ?</h3>
                    <p>Si le stress devient trop envahissant et impacte votre vie quotidienne, n'hésitez pas à consulter un professionnel de santé.</p>
                </div>`
            },
            4: {
                title: "Les secrets d'un sommeil réparateur",
                content: `<div class="prose max-w-none">
                    <h2>Bien dormir pour être en forme</h2>
                    <p>Le sommeil est essentiel à notre santé physique et mentale. Pourtant, un adulte sur trois souffre de troubles du sommeil.</p>
                    
                    <h3>Les règles d'or pour bien dormir :</h3>
                    <ul>
                        <li>Se coucher et se lever à heures fixes</li>
                        <li>Éviter les écrans 1h avant le coucher</li>
                        <li>Créer un environnement calme et obscur</li>
                        <li>Éviter les repas lourds le soir</li>
                        <li>Pratiquer une activité relaxante avant le coucher</li>
                    </ul>
                    
                    <h3>Les besoins en sommeil :</h3>
                    <ul>
                        <li>Adultes : 7 à 9 heures par nuit</li>
                        <li>Adolescents : 8 à 10 heures</li>
                        <li>Enfants : 9 à 12 heures</li>
                    </ul>
                </div>`
            },
            5: {
                title: "L'importance de la vaccination",
                content: `<div class="prose max-w-none">
                    <h2>Se vacciner : un geste pour soi et pour les autres</h2>
                    <p>La vaccination est l'un des moyens les plus efficaces de prévenir les maladies infectieuses. Elle protège à la fois l'individu et la collectivité.</p>
                    
                    <h3>Pourquoi se faire vacciner ?</h3>
                    <ul>
                        <li>Se protéger contre des maladies graves</li>
                        <li>Protéger les personnes vulnérables</li>
                        <li>Contribuer à l'élimination de certaines maladies</li>
                    </ul>
                    
                    <h3>Calendrier vaccinal</h3>
                    <p>Consultez votre médecin pour connaître les vaccins recommandés selon votre âge et votre situation.</p>
                </div>`
            },
            6: {
                title: "Bien prendre soin de ses dents",
                content: `<div class="prose max-w-none">
                    <h2>Une bonne hygiène bucco-dentaire</h2>
                    <p>Des dents et des gencives saines sont essentielles pour votre santé générale.</p>
                    
                    <h3>Les bons gestes au quotidien :</h3>
                    <ul>
                        <li>Brossez-vous les dents 2 fois par jour</li>
                        <li>Utilisez du fil dentaire quotidiennement</li>
                        <li>Consultez votre dentiste 1 fois par an</li>
                        <li>Limitez les sucres et sodas</li>
                        <li>Changez votre brosse à dents tous les 3 mois</li>
                    </ul>
                </div>`
            }
        };

        function openArticle(id) {
            const article = articles[id];
            if (article) {
                document.getElementById('modalTitle').innerHTML = article.title;
                document.getElementById('modalContent').innerHTML = article.content;
                document.getElementById('articleModal').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeArticle() {
            document.getElementById('articleModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        document.getElementById('articleModal').addEventListener('click', function(e) {
            if (e.target === this) closeArticle();
        });
    </script>
</body>
</html>
