<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de rendez-vous - SanteRDV</title>
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
        .btn-cancel {
            background: linear-gradient(135deg, #E53935 0%, #C62828 100%);
            margin-left: 10px;
        }
        .info-card {
            background-color: #f0f5ff;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #1a6fff;
        }
        .value {
            color: #333;
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
        .status-confirmed {
            background-color: #4CAF50;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 12px;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Sante<span>RDV</span></div>
            <p style="color: white; opacity: 0.9; margin-top: 10px;">Confirmation de rendez-vous</p>
        </div>
        
        <div class="content">
            <div style="text-align: center; margin-bottom: 20px;">
                <span class="status-confirmed">✅ Rendez-vous confirmé</span>
            </div>
            
            <h1>Bonjour {{ $patient->name }},</h1>
            <p>Votre rendez-vous médical a été confirmé avec succès. Voici les détails :</p>
            
            <div class="info-card">
                <div class="info-row">
                    <span class="label">👨‍⚕️ Médecin :</span>
                    <span class="value">Dr. {{ $medecin->name }}</span>
                </div>
                <div class="info-row">
                    <span class="label">🏥 Spécialité :</span>
                    <span class="value">{{ $rendezvous->medecin->specialite ?? 'Médecine générale' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">📅 Date :</span>
                    <span class="value">{{ \Carbon\Carbon::parse($rendezvous->date)->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">⏰ Heure :</span>
                    <span class="value">{{ \Carbon\Carbon::parse($rendezvous->heure)->format('H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">📍 Lieu :</span>
                    <span class="value">Centre de santé de Ouando, Porto-Novo</span>
                </div>
                <div class="info-row">
                    <span class="label">🆔 Référence :</span>
                    <span class="value">#RDV-{{ str_pad($rendezvous->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
            
            <div class="qr-code">
                <p style="font-size: 12px; color: #666; margin-bottom: 10px;">Présentez ce code à votre arrivée</p>
                <div style="font-size: 40px; letter-spacing: 5px;">
                    {{ substr(md5($rendezvous->id . $rendezvous->date), 0, 8) }}
                </div>
            </div>
            
            <p><strong>Informations pratiques :</strong></p>
            <ul style="margin: 15px 0 20px 20px; line-height: 1.8;">
                <li>✅ Arrivez 10 minutes avant votre rendez-vous</li>
                <li>✅ Munissez-vous de votre pièce d'identité</li>
                <li>✅ Apportez vos examens médicaux antérieurs si disponibles</li>
                <li>✅ En cas d'empêchement, annulez au moins 24h à l'avance</li>
            </ul>
            
            <div style="text-align: center;">
                <a href="{{ route('patient.rendezvous.show', $rendezvous) }}" class="btn">Voir mon rendez-vous</a>
                <a href="{{ route('patient.rendezvous.destroy', $rendezvous) }}" class="btn btn-cancel">Annuler</a>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} SanteRDV - Centre de santé de Ouando, Porto-Novo, Bénin</p>
            <p>Pour toute urgence médicale, appelez le <strong>112</strong></p>
        </div>
    </div>
</body>
</html>
