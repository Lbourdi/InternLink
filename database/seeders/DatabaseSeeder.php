<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Créer un compte de test pour TOI (pour te connecter facilement)
        User::factory()->create([
            'name'     => 'Recruteur Test',
            'email'    => 'recruteur@example.com',
            'password' => 'password',
            'role'     => 'company', // <--- On lui donne le rôle entreprise
        ]);

        User::factory()->create([
            'name'     => 'Etudiant Test',
            'email'    => 'etudiant@example.com',
            'password' => 'password',
            'role'     => 'student', // <--- On lui donne le rôle étudiant
        ]);

        // 2. Créer 10 utilisateurs aléatoires qui ont chacun 3 offres de stage
        User::factory(10)
            ->has(\App\Models\Offer::factory()->count(3), 'offers') // Relation magique
            ->create();
    }
}
