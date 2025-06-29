<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create([
            'role' => 'guru',
        ]);

        return [
            'user_id' => $user->id,
            'nama'    => $this->faker->name,
            'nip'     => rand(1900000000000000, 1900009999999999),
            'nuptk'   => rand(8000000000000000, 8000009999999999),
        ];
    }
}
