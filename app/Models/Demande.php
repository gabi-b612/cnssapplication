<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Demande extends Model
{
    public const STATUT_BROUILLON = 'brouillon';
    public const STATUT_SOUMISE = 'soumise';
    public const STATUT_EN_VERIFICATION = 'en_verification';
    public const STATUT_APPROUVEE = 'approuvee';
    public const STATUT_PAYEE = 'payee';
    public const STATUT_REJETEE = 'rejetee';

    public const STATUTS = [
        self::STATUT_BROUILLON,
        self::STATUT_SOUMISE,
        self::STATUT_EN_VERIFICATION,
        self::STATUT_APPROUVEE,
        self::STATUT_PAYEE,
        self::STATUT_REJETEE,
    ];

    public const STATUTS_EN_COURS = [
        self::STATUT_BROUILLON,
        self::STATUT_SOUMISE,
        self::STATUT_EN_VERIFICATION,
    ];

    public const STATUTS_TERMINAUX = [
        self::STATUT_APPROUVEE,
        self::STATUT_PAYEE,
        self::STATUT_REJETEE,
    ];

    protected $table = 'demandes';
    protected $guarded = ['id'];

    protected $fillable = [
        'entreprise_id',
        'travailleur_id',
        'apf_id',
        'type_allocation',
        'statut',
        'motif_rejet',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function statutLabel(?string $statut): string
    {
        return match ($statut) {
            self::STATUT_BROUILLON => 'Brouillon',
            self::STATUT_SOUMISE => 'Soumise',
            self::STATUT_EN_VERIFICATION => 'En vérification',
            self::STATUT_APPROUVEE => 'Approuvée',
            self::STATUT_PAYEE => 'Payée',
            self::STATUT_REJETEE => 'Rejetée',
            default => ucfirst(str_replace('_', ' ', (string) $statut)),
        };
    }

    public static function statutBadgeClasses(?string $statut): string
    {
        return match ($statut) {
            self::STATUT_BROUILLON => 'bg-gray-100 text-gray-700',
            self::STATUT_SOUMISE => 'bg-blue-100 text-blue-800',
            self::STATUT_EN_VERIFICATION => 'bg-yellow-100 text-yellow-800',
            self::STATUT_APPROUVEE => 'bg-green-100 text-green-700',
            self::STATUT_PAYEE => 'bg-my-green/10 text-my-green',
            self::STATUT_REJETEE => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public static function statutIcon(?string $statut): string
    {
        return match ($statut) {
            self::STATUT_BROUILLON => 'fa-file-alt',
            self::STATUT_SOUMISE => 'fa-paper-plane',
            self::STATUT_EN_VERIFICATION => 'fa-search',
            self::STATUT_APPROUVEE => 'fa-check-circle',
            self::STATUT_PAYEE => 'fa-money-bill-wave',
            self::STATUT_REJETEE => 'fa-times-circle',
            default => 'fa-circle',
        };
    }

    public function getStatutLabelAttribute(): string
    {
        return self::statutLabel($this->statut);
    }

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function travailleur(): BelongsTo
    {
        return $this->belongsTo(Travailleur::class);
    }

    public function apf(): BelongsTo
    {
        return $this->belongsTo(Apf::class);
    }

    public function liquidation()
    {
        return $this->hasOne(Liquidation::class);
    }

    public function statutHistoriques(): HasMany
    {
        return $this->hasMany(DemandeStatutHistorique::class)->orderBy('created_at');
    }

    public function reclamations(): HasMany
    {
        return $this->hasMany(Reclamation::class)->latest();
    }

    public function changeStatut(
        string $nouveauStatut,
        ?string $acteurType = null,
        ?int $acteurId = null,
        ?string $motifRejet = null
    ): void {
        $ancienStatut = $this->statut;

        if ($ancienStatut === $nouveauStatut) {
            return;
        }

        $data = ['statut' => $nouveauStatut];

        if ($motifRejet !== null) {
            $data['motif_rejet'] = $motifRejet;
        }

        $this->update($data);

        $this->statutHistoriques()->create([
            'ancien_statut' => $ancienStatut,
            'nouveau_statut' => $nouveauStatut,
            'acteur_type' => $acteurType,
            'acteur_id' => $acteurId,
        ]);
    }
}
