<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consultation du {{ $consultation->created_at->format('d/m/Y') }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 40px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1a6fff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1a6fff;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
        }
        .info-section {
            margin-bottom: 25px;
        }
        .info-section h3 {
            color: #1a6fff;
            border-left: 4px solid #1a6fff;
            padding-left: 10px;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 11px;
        }
        .info-value {
            margin-top: 5px;
            font-size: 12px;
        }
        .diagnostic-box, .prescription-box, .notes-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SanteRDV</h1>
        <p>Fiche médicale - Consultation du {{ $consultation->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="info-section">
        <h3>Informations patient</h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nom complet</div>
                <div class="info-value">{{ $consultation->patient->user->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $consultation->patient->user->email }}</div>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Informations consultation</h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Médecin</div>
                <div class="info-value">Dr. {{ $consultation->rendezvous->medecin->user->name ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Spécialité</div>
                <div class="info-value">{{ $consultation->rendezvous->medecin->specialite ?? 'Médecine générale' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date</div>
                <div class="info-value">{{ $consultation->created_at->format('d/m/Y à H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Lieu</div>
                <div class="info-value">Centre de santé de Ouando, Porto-Novo</div>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Diagnostic médical</h3>
        <div class="diagnostic-box">
            {{ $consultation->diagnostic ?? 'Aucun diagnostic renseigné' }}
        </div>
    </div>

    @if($consultation->prescription)
    <div class="info-section">
        <h3>Prescription</h3>
        <div class="prescription-box">
            {{ $consultation->prescription }}
        </div>
    </div>
    @endif

    @if($consultation->notes)
    <div class="info-section">
        <h3>Notes complémentaires</h3>
        <div class="notes-box">
            {{ $consultation->notes }}
        </div>
    </div>
    @endif

    @if($consultation->prochain_rdv)
    <div class="info-section">
        <h3>Prochain rendez-vous suggéré</h3>
        <div class="info-item">
            <div class="info-value">{{ \Carbon\Carbon::parse($consultation->prochain_rdv)->format('d/m/Y') }}</div>
        </div>
    </div>
    @endif

    <div class="footer">
        Document généré automatiquement par SanteRDV - {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>