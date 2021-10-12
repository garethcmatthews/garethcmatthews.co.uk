<?php

namespace Database\Factories;

use App\Modules\SiteMenus\Repository\Models\MenusModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenusModelFactory extends Factory
{
    /** @var string */
    protected $model = MenusModel::class;

    public function definition(): array
    {
        return [
            'name'   => $this->faker->text(32),
            'active' => true,
        ];
    }

    public function inactive(): MenusModelFactory
    {
        return $this->state(function (array $attributes) {
            return ['active' => false];
        });
    }
}
