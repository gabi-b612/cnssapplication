<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reclamation extends Model
{
    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_TRAITEE = 'traitee';

    protected $fillable = [
        'demande_id',
        'travailleur_id',
        'message',
        'statut',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function demande(): BelongsTo
    {
        return $this->belongsTo(Demande::class);
    }

    public function travailleur(): BelongsTo
    {
        return $this->belongsTo(Travailleur::class);
    }
}
