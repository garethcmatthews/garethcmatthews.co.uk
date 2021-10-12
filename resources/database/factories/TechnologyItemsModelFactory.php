<?php

namespace Database\Factories;

use App\Modules\Technology\Repository\Models\TechnologyItemsModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechnologyItemsModelFactory extends Factory
{
    /** @var string */
    protected $model = TechnologyItemsModel::class;

    public function definition(): array
    {
        return [
            'title'   => $this->faker->text(32),
            'url'     => $this->faker->text(),
            'primary' => 1,
            'orderby' => 1,
            'active'  => true,
        ];
    }

    public function inactive(): TechnologyItemsModelFactory
    {
        return $this->state(function (array $attributes) {
            return ['active' => false];
        });
    }
}
