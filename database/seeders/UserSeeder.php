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
            'name' => 'Admin General',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
        $user->assignRole('admin');
        $user->assignPermision('todos');
    }
}
