<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->defineAs(\App\Models\Roles::class, 'manager', function (Faker $faker) {
    return [

        'role_name' => "manager"
    ];
});
$factory->defineAs(\App\Models\Roles::class, 'client', function (Faker $faker) {
    return [

        'role_name' => "cilent"
    ];
});
