<?php

namespace Database\Factories;

use App\Modules\Contact\Repository\Models\ContactModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactModelFactory extends Factory
{
    /** @var string */
    protected $model = ContactModel::class;

    public function definition(): array
    {
        return [
            'fullname' => $this->faker->text(64),
            'company'  => $this->faker->text(64),
            'email'    => $this->faker->email(),
            'reason'   => $this->faker->text(255),
            'message'  => $this->faker->sentence(12),
        ];
    }
}
