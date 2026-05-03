<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrator', 'slug' => 'admin', 'description' => 'Akses penuh sistem'],
            ['name' => 'Marketing', 'slug' => 'marketing', 'description' => 'Input pengajuan kredit'],
            ['name' => 'Surveyor', 'slug' => 'surveyor', 'description' => 'Verifikasi lapangan'],
            ['name' => 'Kolektor', 'slug' => 'kolektor', 'description' => 'Penagihan dan pembayaran'],
            ['name' => 'Klien', 'slug' => 'klien', 'description' => 'Klien pengajuan kredit'],
            ['name' => 'Manager', 'slug' => 'manager', 'description' => 'Manajer Cabang'],
            ['name' => 'Owner', 'slug' => 'owner', 'description' => 'Pemilik Bisnis'],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
