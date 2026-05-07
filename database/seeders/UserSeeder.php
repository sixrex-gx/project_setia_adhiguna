<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin TokoAdv',
            'email'    => 'admin@tokoadv.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'kasir@tokoadv.id',
            'password' => Hash::make('kasir123'),
            'role'     => 'kasir',
        ]);
    }
}