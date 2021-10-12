<?php

namespace Database\Factories;

use App\Modules\Technology\Repository\Models\TechnologyModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechnologyModelFactory extends Factory
{
    /** @var string */
    protected $model = TechnologyModel::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(64),
            'tag'         => $this->faker->text(32),
            'active'      => true,
        ];
    }

    public function inactive(): TechnologyModelFactory
    {
        return $this->state(function (array $attributes) {
            return ['active' => false];
        });
    }
}
