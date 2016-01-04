<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => config('default.root_user.name'),
            'email' => config('default.root_user.email'),
            'password' => bcrypt(config('default.root_user.password')),
            'is_admin' => true,
        ]);
    }
}
