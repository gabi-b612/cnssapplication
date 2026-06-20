<?php

namespace Database\Seeders;

use App\Models\Administrateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministrateurSeeder extends Seeder
{
    public const DEFAULT_PASSWORD = 'Admin@123';

    public function run(): void
    {
        $password = Hash::make(self::DEFAULT_PASSWORD);

        $administrateurs = [
            [
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'email' => 'admin@cnss.local',
            ],
            [
                'nom' => 'Kabila',
                'prenom' => 'Marie',
                'email' => 'marie.kabila@cnss.local',
            ],
        ];

        foreach ($administrateurs as $administrateur) {
            Administrateur::updateOrCreate(
                ['email' => $administrateur['email']],
                array_merge($administrateur, ['password' => $password])
            );
        }
    }
}
