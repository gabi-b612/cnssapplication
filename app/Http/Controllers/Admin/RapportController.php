<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\Liquidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $dateDebut = $request->input('date_debut', now()->startOfYear()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', now()->format('Y-m-d'));

        $demandesQuery = Demande::whereBetween('created_at', [$dateDebut . ' 00:00:00', $dateFin . ' 23:59:59']);

        $stats = [
            'total' => (clone $demandesQuery)->count(),
            'par_statut' => (clone $demandesQuery)->selectRaw('statut, COUNT(*) as total')
                ->groupBy('statut')
                ->pluck('total', 'statut'),
            'par_type' => (clone $demandesQuery)->selectRaw('type_allocation, COUNT(*) as total')
                ->groupBy('type_allocation')
                ->pluck('total', 'type_allocation'),
            'approuvees' => (clone $demandesQuery)->where('statut', Demande::STATUT_APPROUVEE)->count(),
            'rejetees' => (clone $demandesQuery)->where('statut', Demande::STATUT_REJETEE)->count(),
            'payees' => (clone $demandesQuery)->where('statut', Demande::STATUT_PAYEE)->count(),
        ];

        $stats['montant_liquide'] = Liquidation::whereBetween('date_liquidation', [$dateDebut, $dateFin])
            ->sum('montant');

        $stats['taux_approbation'] = $stats['total'] > 0
            ? round((($stats['approuvees'] + $stats['payees']) / $stats['total']) * 100, 1)
            : 0;

        $stats['taux_rejet'] = $stats['total'] > 0
            ? round(($stats['rejetees'] / $stats['total']) * 100, 1)
            : 0;

        $topEntreprises = Demande::query()
            ->whereBetween('created_at', [$dateDebut . ' 00:00:00', $dateFin . ' 23:59:59'])
            ->selectRaw('entreprise_id, COUNT(*) as total')
            ->with('entreprise:id,raison_sociale')
            ->groupBy('entreprise_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.rapports.index', compact('stats', 'topEntreprises', 'dateDebut', 'dateFin'));
    }

    public function export(Request $request): StreamedResponse
    {
        $dateDebut = $request->input('date_debut', now()->startOfYear()->format('Y-m-d'));
        $dateFin = $request->input('date_fin', now()->format('Y-m-d'));

        $demandes = Demande::with(['travailleur', 'entreprise', 'liquidation'])
            ->whereBetween('created_at', [$dateDebut . ' 00:00:00', $dateFin . ' 23:59:59'])
            ->orderBy('created_at')
            ->get();

        $filename = 'rapport-demandes-' . $dateDebut . '-' . $dateFin . '.csv';

        return ResponseFacade::streamDownload(function () use ($demandes) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'ID',
                'Date',
                'Entreprise',
                'Travailleur',
                'Type',
                'Statut',
                'Montant liquidé (FC)',
            ], ';');

            foreach ($demandes as $demande) {
                fputcsv($handle, [
                    $demande->id,
                    $demande->created_at->format('d/m/Y'),
                    $demande->entreprise?->raison_sociale,
                    trim(($demande->travailleur?->nom ?? '') . ' ' . ($demande->travailleur?->prenom ?? '')),
                    $demande->type_allocation,
                    Demande::statutLabel($demande->statut),
                    $demande->liquidation ? number_format($demande->liquidation->montant, 0, ',', ' ') : '',
                ], ';');
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
