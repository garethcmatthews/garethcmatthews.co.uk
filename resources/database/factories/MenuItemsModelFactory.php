<?php

namespace Database\Factories;

use App\Modules\SiteMenus\Repository\Models\MenuItemsModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemsModelFactory extends Factory
{
    /** @var string */
    protected $model = MenuItemsModel::class;

    public function definition(): array
    {
        return [
            'menu_id'    => 1,
            'active'     => true,
            'orderby'    => 1,
            'title'      => $this->faker->text(32),
            'routename'  => $this->faker->text(),
            'parameters' => $this->faker->text(),
        ];
    }

    public function inactive(): MenuItemsModelFactory
    {
        return $this->state(function (array $attributes) {
            return ['active' => false];
        });
    }
}
