<?php

namespace Database\Seeders;

use App\Models\Apf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ApfSeeder extends Seeder
{
    public const string DEFAULT_PASSWORD = 'Admin@123';

    public function run(): void
    {
        $password = Hash::make(self::DEFAULT_PASSWORD);

        $apfs = [
            [
                'nom' => 'Mukendi',
                'prenom' => 'Paul',
                'email' => 'apf1@cnss.local',
            ],
            [
                'nom' => 'Tshilombo',
                'prenom' => 'Grace',
                'email' => 'apf2@cnss.local',
            ],
        ];

        foreach ($apfs as $apf) {
            Apf::updateOrCreate(
                ['email' => $apf['email']],
                array_merge($apf, ['password' => $password])
            );
        }
    }
}
