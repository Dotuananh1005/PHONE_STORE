<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clients>
 */
class ClientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'ten_kh' => $this->faker->name(),
            'dia_chi' => $this->faker->address(),
            'ngay_sinh' => $this->faker->date(),
            'trang_thai' => $this->faker->text(),

        ];
    }
}
