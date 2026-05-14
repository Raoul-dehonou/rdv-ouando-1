<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vos identifiants SanteRDV</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1a6fff 0%, #0d5ae0 100%);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: white;
            opacity: 0.9;
            margin: 5px 0 0;
        }
        .content {
            padding: 30px;
        }
        .content h2 {
            color: #333;
            margin-top: 0;
        }
        .credentials {
            background: #f0f7ff;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #1a6fff;
        }
        .credential-item {
            margin-bottom: 15px;
        }
        .credential-label {
            font-weight: bold;
            color: #1a6fff;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .credential-value {
            font-size: 16px;
            color: #333;
            word-break: break-all;
            font-family: monospace;
            background: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #1a6fff 0%, #0d5ae0 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            font-weight: bold;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e9ecef;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffecb5;
            border-radius: 8px;
            padding: 12px;
            margin: 15px 0;
            color: #856404;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏥 SanteRDV</h1>
            <p>Plateforme médicale - Centre de santé de Ouando</p>
        </div>
        
        <div class="content">
            <h2>Bienvenue, Dr. {{ $user->name }} !</h2>
            
            <p>Votre compte a été créé avec succès sur la plateforme <strong>SanteRDV</strong>.</p>
            <p>Voici vos identifiants de connexion pour accéder à votre espace médecin :</p>
            
            <div class="credentials">
                <div class="credential-item">
                    <div class="credential-label">📧 Adresse email :</div>
                    <div class="credential-value">{{ $user->email }}</div>
                </div>
                <div class="credential-item">
                    <div class="credential-label">🔑 Mot de passe :</div>
                    <div class="credential-value">{{ $password }}</div>
                </div>
            </div>
            
            <div class="warning">
                ⚠️ <strong>Important :</strong> Nous vous recommandons de changer votre mot de passe lors de votre première connexion.
            </div>
            
            <a href="{{ url('/login') }}" class="btn">🔗 Se connecter</a>
            
            <p style="margin-top: 25px; font-size: 13px; color: #888;">
                Ce message a été généré automatiquement. Merci de ne pas y répondre.
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} SanteRDV - Prenez soin de votre santé</p>
            <p>Centre de santé de Ouando - Porto-Novo, Bénin</p>
        </div>
    </div>
</body>
</html>