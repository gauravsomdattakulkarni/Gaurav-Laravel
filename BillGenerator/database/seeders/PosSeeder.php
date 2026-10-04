<?php

namespace Database\Seeders;

use App\Models\Pos;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        Pos::updateOrCreate(
            ['username' => 'gauravkulkarni'],
            [
                'name' => 'Gaurav Kulkarni',
                'password' => Hash::make('kulkarni@12345'),
                'account_status' => 'active',
                'last_login_date_time' => null,
            ]
        );
    }
}
