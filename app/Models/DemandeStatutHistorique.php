<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeStatutHistorique extends Model
{
    protected $table = 'demande_statut_historiques';

    protected $fillable = [
        'demande_id',
        'ancien_statut',
        'nouveau_statut',
        'acteur_type',
        'acteur_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function demande(): BelongsTo
    {
        return $this->belongsTo(Demande::class);
    }

    public function getNouveauStatutLabelAttribute(): string
    {
        return Demande::statutLabel($this->nouveau_statut);
    }

    public function getAncienStatutLabelAttribute(): ?string
    {
        return $this->ancien_statut ? Demande::statutLabel($this->ancien_statut) : null;
    }
}
