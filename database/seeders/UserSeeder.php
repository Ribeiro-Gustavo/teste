<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
          'name' => 'Admin',
          'email' => 'admin@exemplo.com',
          'password' => 'minhasenha123', // cast ‘hashed’ criptografa
        ]);
    }
}