<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate UUIDs for each user
        $adminUuid = Str::uuid();
        $bidanUuid = Str::uuid();
        $pasienUuid = Str::uuid();

        User::create([
            'id' => $adminUuid,
            'nama_lengkap' => 'Admin User',
            'tanggal_lahir' => '1980-01-01',
            'jenis_kelamin' => 'Perempuan',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'role' => 'Admin',
            'pekerjaan' => 'Administrator',
            'created_by' => $adminUuid,
            'updated_by' => $adminUuid,
        ]);

        User::create([
            'id' => $bidanUuid,
            'nama_lengkap' => 'Bidan User',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Perempuan',
            'username' => 'bidan',
            'password' => Hash::make('password'),
            'no_hp' => '081234567891',
            'role' => 'Bidan',
            'pekerjaan' => 'Bidan',
            'created_by' => $bidanUuid,
            'updated_by' => $bidanUuid,
        ]);

        User::create([
            'id' => $pasienUuid,
            'nama_lengkap' => 'Pasien User',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'Perempuan',
            'username' => 'pasien',
            'password' => Hash::make('password'),
            'no_hp' => '081234567892',
            'role' => 'Pasien',
            'pekerjaan' => 'Ibu Rumah Tangga',
            'created_by' => $pasienUuid,
            'updated_by' => $pasienUuid,
        ]);
    }
}
