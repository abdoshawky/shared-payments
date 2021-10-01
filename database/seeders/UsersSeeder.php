<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Abdo', 'email' => 'abdo@email.com', 'password' => bcrypt('123456789')],
            ['name' => 'Aamer', 'email' => 'aamer@email.com', 'password' => bcrypt('123456789')],
            ['name' => 'Keshta', 'email' => 'keshta@email.com', 'password' => bcrypt('123456789')]
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
