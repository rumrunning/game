<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\SkillSet;
use Faker\Generator as Faker;

$factory->define(SkillSet::class, function (Faker $faker) {
    return [
        'class' => \App\RumRunning\Crimes\Crime::class
    ];
});
