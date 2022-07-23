<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Timer;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Timer::class, function (Faker $faker) {
    return [
        'type' => \App\RumRunning\Crimes\Crime::class,
        'ends_at' => Carbon::now()
    ];
});
