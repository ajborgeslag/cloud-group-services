<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'General',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
        $user->assignRole('admin');
        //$user->assignPermision('todos');
    }
}
