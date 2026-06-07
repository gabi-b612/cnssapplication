<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Travailleur extends Authenticatable
{
    use Notifiable;

    protected $table = 'travailleurs';
    protected $guarded = ['id'];

    protected $fillable = [
        'entreprise_id',
        'nom',
        'postnom',
        'prenom',
        'email',
        'password',
        'telephone',
        'date_naissance',
        'sexe',
        'etat_civil',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
