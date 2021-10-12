<?php

namespace Database\Factories;

use App\Modules\Links\Repository\Models\LinksTagsModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinksTagsModelFactory extends Factory
{
    /** @var string */
    protected $model = LinksTagsModel::class;

    public function definition(): array
    {
        return [
            'name'  => $this->faker->unique()->text(32),
            'title' => $this->faker->text(64),
        ];
    }
}
