<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  Create Admin
        User::create([
            'name' => 'Rizky Ibrahim',
            'username' => 'rizky98ibrahim',
            'email' => 'rizky98ibrahim@gmail.com',
            'phone_number' => '6285932990070',
            'address' => 'Jl. Primadana VII Blok C8 No.28, RT.06/RW.10, Jatisari, Jatiasih, Kota Bekasi, Jawa Barat 17426',
            'password' => bcrypt('12345678'),
            'status' => 'active',
            'email_verified_at' => now(),
            'last_login' => now(),
        ]);
    }
}
