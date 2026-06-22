<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreLiquidationRequest;
use App\Models\Liquidation;
use App\Models\Demande;
use App\Services\AllocationCalculator;
use App\Services\DemandeNotifier;
use App\Services\FacturePdfService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LiquidationController extends Controller
{
    public function __construct(
        private DemandeNotifier $demandeNotifier,
        private FacturePdfService $facturePdfService
    ) {
    }

    public function index()
    {
        $demandes = Demande::where('statut', Demande::STATUT_APPROUVEE)
            ->whereDoesntHave('liquidation')
            ->with(['travailleur', 'entreprise'])
            ->latest()
            ->get();

        $montants = app(AllocationCalculator::class)->montantsParType();

        return view('admin.liquidations.index', compact('demandes', 'montants'));
    }

    public function historique()
    {
        $liquidations = Liquidation::with(['demande.travailleur', 'administrateur'])
            ->latest()
            ->paginate(10);

        return view('admin.liquidations.historique', compact('liquidations'));
    }

    public function store(StoreLiquidationRequest $request)
    {
        $liquidation = null;

        try {
            DB::transaction(function () use ($request, &$liquidation) {
                $data = $request->validated();
                $data['administrateur_id'] = Auth::guard('administrateur')->id();

                $demande = Demande::where('id', $data['demande_id'])
                    ->where('statut', Demande::STATUT_APPROUVEE)
                    ->whereDoesntHave('liquidation')
                    ->firstOrFail();

                $liquidation = Liquidation::create(array_merge($data, [
                    'numero_facture' => $this->facturePdfService->genererNumeroFacture(),
                ]));

                $demande->changeStatut(
                    Demande::STATUT_PAYEE,
                    'administrateur',
                    Auth::guard('administrateur')->id()
                );
            });

            if ($liquidation) {
                $demande = Demande::with(['entreprise', 'travailleur'])->findOrFail($liquidation->demande_id);
                $emailSent = $this->demandeNotifier->notifyLiquidee($demande, $liquidation);
            }

            $redirect = redirect()->route('admin.liquidations.index')
                ->with('success', 'Liquidation enregistrée avec succès.');

            if (isset($emailSent) && !$emailSent) {
                $redirect->with('error', 'Liquidation enregistrée, mais l\'envoi des emails a échoué. Vérifiez la configuration SMTP dans .env.');
            }

            return $redirect;
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.liquidations.index')
                ->with('error', 'Cette demande n\'est plus disponible pour liquidation.')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Erreur création liquidation', [
                'message' => $e->getMessage(),
                'demande_id' => $request->input('demande_id'),
            ]);

            $message = config('app.debug')
                ? 'Erreur lors de la création de la liquidation : ' . $e->getMessage()
                : 'Erreur lors de la création de la liquidation. Veuillez réessayer.';

            return redirect()->route('admin.liquidations.index')
                ->with('error', $message)
                ->withInput();
        }
    }

    public function show(Liquidation $liquidation)
    {
        $liquidation->load(['demande.travailleur', 'demande.entreprise', 'administrateur']);

        return view('admin.liquidations.show', compact('liquidation'));
    }

    public function destroy(Liquidation $liquidation)
    {
        try {
            DB::transaction(function () use ($liquidation) {
                $demande = $liquidation->demande;
                $liquidation->delete();

                if ($demande && $demande->statut === Demande::STATUT_PAYEE) {
                    $demande->changeStatut(
                        Demande::STATUT_APPROUVEE,
                        'administrateur',
                        Auth::guard('administrateur')->id()
                    );
                }
            });

            return redirect()->route('admin.liquidations.historique')
                ->with('success', 'Liquidation supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de la liquidation.');
        }
    }
}
