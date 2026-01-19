<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkillsFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_skills_on_profile()
    {
        $user = User::factory()->create(['role' => 'student']);
        $skill = Skill::factory()->create(['name' => 'PHP']);

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
                'skills' => [$skill->id],
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('skill_user', [
            'user_id' => $user->id,
            'skill_id' => $skill->id,
        ]);
    }

    public function test_company_can_create_offer_with_skills()
    {
        $company = User::factory()->create(['role' => 'company']);
        $skills = Skill::factory()->count(2)->create();

        $response = $this
            ->actingAs($company)
            ->post('/offers', [
                'title' => 'Stage Laravel',
                'company_name' => 'ACME',
                'description' => 'Description',
                'skills' => $skills->pluck('id')->toArray(),
            ]);

        $response->assertRedirect('/dashboard');

        $offer = Offer::where('title', 'Stage Laravel')->first();
        $this->assertNotNull($offer);

        foreach ($skills as $skill) {
            $this->assertDatabaseHas('offer_skill', [
                'offer_id' => $offer->id,
                'skill_id' => $skill->id,
            ]);
        }
    }

    public function test_filter_offers_by_skill()
    {
        $skillA = Skill::factory()->create(['name' => 'A']);
        $skillB = Skill::factory()->create(['name' => 'B']);

        $offer1 = Offer::factory()->create(['title' => 'Offer with A']);
        $offer1->skills()->attach($skillA->id);

        $offer2 = Offer::factory()->create(['title' => 'Offer with B']);
        $offer2->skills()->attach($skillB->id);

        $response = $this->get('/offers?skills[]=' . $skillA->id);

        $response->assertStatus(200);
        $response->assertSee('Offer with A');
        $response->assertDontSee('Offer with B');
    }
}

