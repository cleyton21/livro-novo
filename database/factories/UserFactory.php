<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'postograd' => fake()->randomElement($array = array ('Cel','Ten Cel','Maj', 'Cap', '1º Ten', '2º Ten', 'Asp', 'ST', '1º Sgt', '2º Sgt', '3º Sgt', 'Cb', 'Sd')),
            'nome_guerra' => fake()->firstName(),
            'nome_completo' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'cel' => fake()->tollFreePhoneNumber(),
            'perfil' => fake()->randomElement($array = array ('Admin', 'Secretaria', 'Sargenteante', 'Usuário Comum')),
            'status' => fake()->randomElement($array = array ('0', '1', '2')),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
