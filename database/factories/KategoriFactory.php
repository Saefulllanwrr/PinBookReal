<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
class KategoriFactory extends Factory
{
    protected $model = \App\Models\Kategori::class;

    public function definition(): array
    {
        return [
            'nama_kategori' => $this->faker->word(),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
