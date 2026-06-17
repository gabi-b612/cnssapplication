<?php

namespace App\Notifications;

use App\Models\Demande;
use App\Models\Entreprise;
use App\Models\Liquidation;
use App\Services\AllocationCalculator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeLiquideeNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Demande $demande,
        public Liquidation $liquidation
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->demande->loadMissing(['travailleur', 'entreprise']);

        $url = $notifiable instanceof Entreprise
            ? route('entreprise.demandes.show', $this->demande)
            : route('travailleur.demandes.show', $this->demande);

        $travailleur = trim(implode(' ', array_filter([
            $this->demande->travailleur?->nom,
            $this->demande->travailleur?->postnom,
            $this->demande->travailleur?->prenom,
        ])));

        return (new MailMessage)
            ->subject('Demande #' . $this->demande->id . ' payée — CNSS')
            ->greeting('Bonjour,')
            ->line('La liquidation de la demande **#' . $this->demande->id . '** a été enregistrée.')
            ->line('**Travailleur :** ' . $travailleur)
            ->line('**Type :** ' . AllocationCalculator::labelType($this->demande->type_allocation))
            ->line('**Montant versé :** ' . AllocationCalculator::formaterMontant($this->liquidation->montant))
            ->line('**Date de liquidation :** ' . $this->liquidation->date_liquidation->format('d/m/Y'))
            ->action('Consulter la demande', $url)
            ->line('**Facture :** ' . route('factures.download', $this->liquidation))
            ->salutation('CNSS — Caisse Nationale de Sécurité Sociale');
    }
}
