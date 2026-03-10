<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed akun admin ke database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'          => 'Administrator',
                'nik'           => '0000000000000000',
                'username'      => 'admin',
                'email'         => 'admin@libschool.com',
                'telepon'       => '000000000000',
                'tanggal_lahir' => '2000-01-01',
                'gender'        => 'Laki-laki',
                'password'      => Hash::make('admin123'),
                'role'          => 'admin',
            ]
        );
    }
}
