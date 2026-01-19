<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'PHP',
            'Laravel',
            'JavaScript',
            'Vue.js',
            'React',
            'HTML',
            'CSS',
            'SQL',
            'MySQL',
            'PostgreSQL',
            'Git',
            'Docker',
            'API REST',
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill]);
        }
    }
}
