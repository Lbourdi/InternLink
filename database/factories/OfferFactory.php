<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(), // Génère un titre de métier
            'company_name' => fake()->company(), // Génère un nom d'entreprise
            'description' => fake()->paragraph(3), // Génère un texte de 3 phrases
            'user_id' => \App\Models\User::factory(), // Crée un user associé automatiquement
        ];
    }
}
