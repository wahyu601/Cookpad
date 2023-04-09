<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; //panggil model seeder

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //masukkan data user admin ke database
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('admin'), //isi password akan di hash dengan algoritma bcrypt
            'status' => 'aktif',
            'last_login' => now() //built in library untuk menampilkan tanggal saat ini
        ]);

        //panggil UserFactory, generate sebanyak 50 data
        User::factory()->count(50)->create();
    }
}
