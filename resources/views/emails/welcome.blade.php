<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur SanteRDV</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f8ff;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1a6fff 0%, #0d5ae0 100%);
            padding: 30px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: white;
        }
        .logo span {
            color: #FE914E;
        }
        .content {
            padding: 30px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #1a6fff 0%, #0d5ae0 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            margin-top: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        h1 {
            color: #1a6fff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f0f5ff;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #1a6fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Sante<span>RDV</span></div>
            <p style="color: white; opacity: 0.9; margin-top: 10px;">Plateforme Médicale</p>
        </div>
        
        <div class="content">
            <h1>Bienvenue {{ $user->name }} !</h1>
            <p>Nous sommes ravis de vous accueillir sur <strong>SanteRDV</strong>, la première plateforme de prise de rendez-vous médicaux en ligne au Bénin.</p>
            
            <div class="info-box">
                <p style="font-weight: bold; margin-bottom: 10px;">📋 Vos informations de connexion :</p>
                <p><strong>Email :</strong> {{ $user->email }}</p>
                @if($password)
                    <p><strong>Mot de passe :</strong> {{ $password }}</p>
                    <p style="font-size: 12px; color: #FF0000; margin-top: 10px;">⚠️ Nous vous recommandons de changer votre mot de passe après votre première connexion.</p>
                @endif
            </div>
            
            <p>Avec SanteRDV, vous pouvez :</p>
            <ul style="margin: 15px 0 20px 20px; line-height: 1.8;">
                <li>✅ Prendre rendez-vous en ligne 24h/24</li>
                <li>✅ Consulter votre dossier médical sécurisé</li>
                <li>✅ Recevoir des rappels automatiques par SMS et email</li>
                <li>✅ Échanger avec vos médecins en toute sécurité</li>
            </ul>
            
            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="btn">Se connecter</a>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} SanteRDV - Centre de santé de Ouando, Porto-Novo, Bénin</p>
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
