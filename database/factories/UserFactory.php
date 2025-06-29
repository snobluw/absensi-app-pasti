<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username'       => $this->faker->unique()->userName,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => bcrypt('123'), // password
            'gender'         => ['L', 'P'][rand(0, 1)],
            'role'           => $this->faker->randomElement(['admin', 'guru']),
            'avatar'         => null,
            'remember_token' => Str::random(10),
        ];
    }
}
