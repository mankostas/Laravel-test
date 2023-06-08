<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {    
        $tags = fake()->randomElements(['tag1','tag2','tag3','tag4','tag5','tag6','tag7','tag8','tag9','tag10'], $count = 3);
        $codes = 'prd_' . fake()->unique()->numberBetween(0000,100000);

        fake()->addProvider(new \Liior\Faker\Prices(fake()));

        return [
            'name' => fake()->text(10),
            'code' => $codes,
            'category' => fake()->randomElement(['Cat1','Cat2','Cat3','Cat4','Cat5','Cat6','Cat7']),
            'price' => fake()->price($min = 10, $max = 500, $psychologicalPrice = true, $decimals = true),
            'tags' => $tags,
            'release_date' => fake()->dateTimeBetween($startDate = '-3 months', $endDate = '+30 days', $timezone = 'Europe/Athens'),
        ];
    }
}
