<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataInicial = $this->faker->dateTimeBetween('now', '+5 days');

        return [
            'dt_ini' => $dataInicial,
            'dt_end' => $this->faker->dateTimeBetween($dataInicial, $dataInicial->format('Y-m-d').' +10 days'),
            'texto' => fake()->text(),
            'usuario_id' => $this->faker->randomElement(User::pluck('id')),
        ];
    }
}
