<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(), // Menggunakan username untuk login
            'password' => static::$password ??= Hash::make('password'), // Password default: password
            'role' => fake()->randomElement(['superadmin', 'provinsi', 'daerah']), // Role acak
            'kode_wilayah' => null, // Diisi manual jika rolenya daerah
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * State khusus untuk role Superadmin
     */
    public function superadmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'superadmin',
        ]);
    }

    /**
     * State khusus untuk role Provinsi
     */
    public function provinsi(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'provinsi',
        ]);
    }

    /**
     * State khusus untuk role Daerah dengan kode wilayah
     */
    public function daerah(string $kodeWilayah): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'daerah',
            'kode_wilayah' => $kodeWilayah,
        ]);
    }
}