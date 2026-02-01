<?php

namespace CobraProjects\Multiauth\Database\Factories;

use CobraProjects\Multiauth\Model\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$04$sJbJqpv7TH5RrgTPq0raburfQ6g1XOQtgd59Dgz.VCGlr8f5gUvm6', //secret
            'remember_token' => Str::random(10),
            'active' => true,
        ];
    }
}
