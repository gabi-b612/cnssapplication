<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Apf extends Authenticatable
{
    use Notifiable;

    protected $table = 'apfs';
    protected $guarded = ['id'];

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
