<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['username' => 'sara'],
            [
                'password' => Hash::make('sara'),
                'nama' => 'sara',
                'nisn' => '081331821',
                'role' => 'siswa',
            ]
        );

        $user = User::firstOrCreate(
            ['username' => 'leona'],
            [
                'password' => Hash::make('leona'),
                'nama' => 'Leona',
                'nisn' => '081331822',
                'role' => 'siswa',
            ]
        );

        $user = User::firstOrCreate(
            ['username' => 'leon'],
            [
                'password' => Hash::make('leon'),
                'nama' => 'Leon',
                'nisn' => '081331823',
                'role' => 'siswa',
            ]
        );

        $user = User::firstOrCreate(
            ['username' => 'yuri'],
            [
                'password' => Hash::make('yuri'),
                'nama' => 'Yuri',
                'nisn' => '081331824',
                'role' => 'admin',
            ]
        );

        $user = User::firstOrCreate(
            ['username' => 'shion'],
            [
                'password' => Hash::make('shion'),
                'nama' => 'Shion',
                'nisn' => '081331825',
                'role' => 'kepsek',
            ]
        );

        Siswa::firstOrCreate(
            ['nisn' => '081331821'],
            [
                'nama' => 'sara',
                'kelas' => '9',
                'jurusan' => 'ips',
            ]
        );

        Siswa::firstOrCreate(
            ['nisn' => '081331822'],
            [
                'nama' => 'Leona',
                'kelas' => '1',
                'jurusan' => 'ipa',
            ]
        );

        Siswa::firstOrCreate(
            ['nisn' => '081331823'],
            [
                'nama' => 'Leon',
                'kelas' => '9',
                'jurusan' => 'ipa',
            ]
        );

        $kategoriList = [
            'Aspirasi',
            'Pengaduan',
            'Permintaan Informasi',
        ];

        foreach ($kategoriList as $nama) {
            Kategori::firstOrCreate(['nama' => $nama]);
        }
    }
}
