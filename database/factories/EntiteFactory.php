<?php

namespace Database\Factories;

use App\Enums\EntiteType;
use App\Models\Entite;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EntiteFactory extends Factory
{
    protected $model = Entite::class;

    public function definition(): array
    {
        return [
            'uid' => (string) Str::uuid(),

            'name' => fake()->company(),

            'parent_uid' => null,

            'type' => fake()->randomElement(EntiteType::cases()),

            'short_description' => fake()->sentence(),

            'description' => fake()->paragraphs(3, true),

            'founded_year' => fake()->numberBetween(1950, now()->year),

            'visible' => true,

            'color_1' => fake()->hexColor(),
            'color_2' => fake()->hexColor(),

            'email' => fake()->companyEmail(),

            'logo' => null,
        ];
    }
}