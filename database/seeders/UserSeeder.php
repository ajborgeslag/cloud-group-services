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
            'address' => 'Edificio 891 apto. 25 Zona 5 Alamar, Habana del Este, La Habana, Cuba',
            'phone_number' => '+53 54601260',
            'password' => bcrypt('123456789')
        ]);
        $user->assignRole('admin');
        //$user->assignPermision('todos');
    }
}
