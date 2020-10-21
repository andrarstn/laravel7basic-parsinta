<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Andra R.',
            'username' => 'andraristiano',
            'password' => bcrypt('password'),
            'email'=>'andrailjimae@gmail.com'
        ]);
    }
}
