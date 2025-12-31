<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParentModel;
use Illuminate\Support\Facades\Hash;

class ParentSeeder extends Seeder
{
    public function run(): void
    {
        $parents = [
            [
                'name' => 'Agus Setiawan',
                'email' => 'agus.setiawan@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561001',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Rina Wati',
                'email' => 'rina.wati@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561002',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Bambang Hermawan',
                'email' => 'bambang.hermawan@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561003',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Sari Indah',
                'email' => 'sari.indah@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561004',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Hendra Gunawan',
                'email' => 'hendra.gunawan@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561005',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Lina Marlina',
                'email' => 'lina.marlina@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561006',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi.kurniawan@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561007',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Yuni Astuti',
                'email' => 'yuni.astuti@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561008',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi.hartono@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561009',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Fitri Handayani',
                'email' => 'fitri.handayani@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561010',
                'status' => 'approved',
                'approved_at' => now(),
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko.widodo@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561011',
                'status' => 'pending',
                'approved_at' => null,
            ],
            [
                'name' => 'Mega Sari',
                'email' => 'mega.sari@gmail.com',
                'password' => Hash::make('password123'),
                'phone' => '081234561012',
                'status' => 'pending',
                'approved_at' => null,
            ],
        ];

        foreach ($parents as $parent) {
            ParentModel::create($parent);
        }
    }
}
