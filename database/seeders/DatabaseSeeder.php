<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Category::insert([
            ['nama' => 'Undangan', 'keterangan' => 'Surat undangan rapat, koordinasi, dll.'],
            ['nama' => 'Pengumuman', 'keterangan' => 'Surat-surat terkait pengumuman.'],
            ['nama' => 'Nota Dinas', 'keterangan' => 'Surat nota dinas internal/eksternal.'],
            ['nama' => 'Pemberitahuan', 'keterangan' => 'Surat pemberitahuan resmi.'],
        ]);
    }
}
