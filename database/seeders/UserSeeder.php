<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $users =
        [
            [
                'name' => 'Super Admin',
                'email' => 'super@cashier.app',
                'password' => bcrypt('superadminapp'),
                'level' => 2
            ],
            [
                'name' => 'Cashier',
                'email' => 'cashier@cashier.app',
                'password' => bcrypt('cashierapp'),
                'level' => 1
            ]
        ];

        foreach ($users as $key => $value) {
            User::create($value);
        }
    }
}
