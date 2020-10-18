<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! App::isLocal()) return;
        DB::table('users')->insert([
            [
                'name' => 'test1',
                'email' => 'test1@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'test2',
                'email' => 'test2@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'test3',
                'email' => 'test3@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'test4',
                'email' => 'test4@example.com',
                'password' => bcrypt('password'),
            ],
        ]);
    }
}
