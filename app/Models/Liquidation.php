<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liquidation extends Model
{
    protected $table = 'liquidations';
    protected $guarded = ['id'];

    protected $fillable = [
        'numero_facture',
        'demande_id',
        'administrateur_id',
        'montant',
        'date_liquidation',
        'justification_ajustement',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_liquidation' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class);
    }
}
