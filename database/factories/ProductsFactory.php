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
    public function definition()
    {
        return [
            //
            'ten' => $this->faker->name(),
            'gia' => $this->faker->number(),
            'mau_sac' => $this->faker->text(),
            'ngay_nhap' => $this->faker->date(),
            'trang_thai' => $this->faker->text(),
        ];
    }
}
