<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture {{ $liquidation->numero_facture }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1a2e; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2d6a4f; padding-bottom: 15px; }
        .header h1 { color: #2d6a4f; margin: 0; font-size: 22px; }
        .header p { margin: 4px 0; color: #666; }
        .section { margin-bottom: 20px; }
        .section h2 { font-size: 14px; color: #2d6a4f; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f0f7f4; }
        .montant { font-size: 18px; font-weight: bold; color: #2d6a4f; text-align: right; margin-top: 15px; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CAISSE NATIONALE DE SÉCURITÉ SOCIALE</h1>
        <p>Facture N° {{ $liquidation->numero_facture }}</p>
        <p>Date : {{ $liquidation->date_liquidation->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <h2>Bénéficiaire</h2>
        <p>
            <strong>{{ $demande->travailleur->nom }} {{ $demande->travailleur->postnom }} {{ $demande->travailleur->prenom }}</strong><br>
            {{ $demande->travailleur->email }}
        </p>
    </div>

    <div class="section">
        <h2>Entreprise employeur</h2>
        <p>
            <strong>{{ $demande->entreprise->raison_sociale }}</strong><br>
            {{ $demande->entreprise->email }}
        </p>
    </div>

    <div class="section">
        <h2>Détail de la prestation</h2>
        <table>
            <tr>
                <th>Réf. demande</th>
                <th>Type d'allocation</th>
                <th>Date liquidation</th>
                <th>Montant (FC)</th>
            </tr>
            <tr>
                <td>#{{ $demande->id }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $demande->type_allocation)) }}</td>
                <td>{{ $liquidation->date_liquidation->format('d/m/Y') }}</td>
                <td>{{ number_format($liquidation->montant, 0, ',', ' ') }}</td>
            </tr>
        </table>
        <p class="montant">Total versé : {{ number_format($liquidation->montant, 0, ',', ' ') }} FC</p>
    </div>

    <div class="section">
        <p>Liquidation enregistrée par : {{ $liquidation->administrateur->prenom }} {{ $liquidation->administrateur->nom }}</p>
    </div>

    <div class="footer">
        <p>CNSS — Caisse Nationale de Sécurité Sociale — Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
