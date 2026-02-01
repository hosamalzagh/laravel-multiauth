<?php

namespace CobraProjects\Multiauth\Database\Factories;

use CobraProjects\Multiauth\Model\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
