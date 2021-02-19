<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $id = method_exists($this->faker, 'randomDigitNot') ?
            $this->faker->randomDigitNot(User::ADMIN) :
            2;

        return [
            'id'         => $id,
            'name'       => $this->faker->name,
            'email'      => $this->faker->unique()->safeEmail,
            'password'   => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'created_by' => $id,
            'updated_by' => $id,
        ];
    }
}
