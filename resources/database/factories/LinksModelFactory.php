<?php

namespace Database\Factories;

use App\Modules\Links\Repository\Models\LinksModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinksModelFactory extends Factory
{
    /** @var string */
    protected $model = LinksModel::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->text(100),
            'description' => $this->faker->sentence(12),
            'url'         => $this->faker->url(),
            'image'       => $this->faker->text(24),
            'active'      => true,
        ];
    }

    public function inactive(): LinksModelFactory
    {
        return $this->state(function (array $attributes) {
            return ['active' => false];
        });
    }
}
