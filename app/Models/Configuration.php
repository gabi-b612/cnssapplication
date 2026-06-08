<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'configurations';
    protected $guarded = ['id'];

    protected $fillable = [
        'taux_cotisation',
        'taux_allocation_familiale',
        'taux_allocation_maternite',
        'taux_allocation_prenatale',
    ];

    protected $casts = [
        'taux_cotisation' => 'decimal:2',
        'taux_allocation_familiale' => 'decimal:2',
        'taux_allocation_maternite' => 'decimal:2',
        'taux_allocation_prenatale' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'taux_cotisation' => 6.50,
            'taux_allocation_familiale' => 100.00,
            'taux_allocation_maternite' => 100.00,
            'taux_allocation_prenatale' => 100.00,
        ]);
    }
}
