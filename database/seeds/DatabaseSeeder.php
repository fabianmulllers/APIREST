<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        Eloquent\Model::unguard();
        factory('apirest\User', 10)->create();
        Eloquent\Model::reguard();


        }
}
