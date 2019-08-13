<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Roles::class, 'manager')->create()->save();
        factory(\App\Models\Roles::class, 'client')->create()->save();

    }
}
