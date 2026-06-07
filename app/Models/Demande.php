<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Demande extends Model
{
    protected $table = 'demandes';
    protected $guarded = ['id'];

    protected $fillable = [
        'entreprise_id',
        'travailleur_id',
        'apf_id',
        'type_allocation',
        'statut',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
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
}
