<?php

namespace Database\Factories;

use App\Modules\Contact\Repository\Models\ContactBlockedListModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactBlockedListModelFactory extends Factory
{
    /** @var string */
    protected $model = ContactBlockedListModel::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
        ];
    }
}
