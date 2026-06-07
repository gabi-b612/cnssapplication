<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Entreprise extends Authenticatable
{
    use Notifiable;

    protected $table = 'entreprises';
    protected $guarded = ['id'];

    protected $fillable = [
        'raison_sociale',
        'siege_social',
        'email',
        'password',
        'telephone',
        'forme_juridique',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function travailleurs()
    {
        return $this->hasMany(Travailleur::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
