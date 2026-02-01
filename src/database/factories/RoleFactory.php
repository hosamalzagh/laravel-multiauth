<?php

namespace CobraProjects\Multiauth\Database\Factories;

use CobraProjects\Multiauth\Model\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
