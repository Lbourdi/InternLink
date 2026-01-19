<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Offer;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Skills
        $this->call(SkillSeeder::class);
        $skills = Skill::all();

        // Comptes de test
        $recruiter = User::factory()->create([
            'name' => 'Recruteur Test',
            'email' => 'recruteur@example.com',
            'role' => 'company',
        ]);

        $student = User::factory()->create([
            'name' => 'Etudiant Test',
            'email' => 'etudiant@example.com',
            'role' => 'student',
        ]);

        // Skills utilisateurs
        $recruiter->skills()->attach($skills->random(5));
        $student->skills()->attach($skills->random(4));

        // Offres associées au recruteur de test
        Offer::factory()
            ->count(30) // nombre total d’offres
            ->for($recruiter) // 🔥 association explicite
            ->afterCreating(function (Offer $offer) use ($skills) {
                $offer->skills()->attach(
                    $skills->random(rand(2, 4))
                );
            })
            ->create();
    }
}
