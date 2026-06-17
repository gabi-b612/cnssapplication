<?php

namespace App\Notifications;

use App\Models\Demande;
use App\Models\Entreprise;
use App\Services\AllocationCalculator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeApprouveeNotification extends Notification
{
    use Queueable;

    public function __construct(public Demande $demande)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->demande->loadMissing(['travailleur', 'entreprise']);

        $montant = AllocationCalculator::formaterMontant(
            app(AllocationCalculator::class)->montantPourType($this->demande->type_allocation)
        );

        $url = $notifiable instanceof Entreprise
            ? route('entreprise.demandes.show', $this->demande)
            : route('travailleur.demandes.show', $this->demande);

        $travailleur = trim(implode(' ', array_filter([
            $this->demande->travailleur?->nom,
            $this->demande->travailleur?->postnom,
            $this->demande->travailleur?->prenom,
        ])));

        return (new MailMessage)
            ->subject('Demande #' . $this->demande->id . ' approuvée — CNSS')
            ->greeting('Bonjour,')
            ->line('La demande d\'allocation **#' . $this->demande->id . '** a été approuvée par un agent APF.')
            ->line('**Travailleur :** ' . $travailleur)
            ->line('**Type :** ' . AllocationCalculator::labelType($this->demande->type_allocation))
            ->line('**Montant de référence :** ' . $montant)
            ->line('La demande sera transmise à l\'administration pour liquidation.')
            ->action('Consulter la demande', $url)
            ->salutation('CNSS — Caisse Nationale de Sécurité Sociale');
    }
}
