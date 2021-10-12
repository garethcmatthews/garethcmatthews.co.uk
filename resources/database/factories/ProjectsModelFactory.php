<?php

namespace Database\Factories;

use App\Modules\Projects\Repository\Models\ProjectsModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectsModelFactory extends Factory
{
    /** @var string */
    protected $model = ProjectsModel::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->text(64),
            'description' => $this->faker->sentence(12),
            'image'       => $this->faker->text(32),
            'isgithub'    => true,
            'url'         => $this->faker->url(),
            'orderby'     => 1,
            'active'      => true,
        ];
    }

    public function inactive(): ProjectsModelFactory
    {
        return $this->state(function (array $attributes) {
            return ['active' => false];
        });
    }
}
