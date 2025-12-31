<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ParentModel;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            // MI (Madrasah Ibtidaiyah - Elementary)
            ['name' => 'Andi Pratama', 'parent_id' => 1, 'education_level' => 'MI', 'class_level' => 1],
            ['name' => 'Budi Santoso Jr', 'parent_id' => 1, 'education_level' => 'MI', 'class_level' => 3],
            ['name' => 'Citra Dewi', 'parent_id' => 2, 'education_level' => 'MI', 'class_level' => 2],
            ['name' => 'Dina Amelia', 'parent_id' => 2, 'education_level' => 'MI', 'class_level' => 5],
            ['name' => 'Eko Prasetyo', 'parent_id' => 3, 'education_level' => 'MI', 'class_level' => 4],
            ['name' => 'Farah Nabila', 'parent_id' => 3, 'education_level' => 'MI', 'class_level' => 6],
            
            // SMP (Junior High School)
            ['name' => 'Gilang Ramadhan', 'parent_id' => 4, 'education_level' => 'SMP', 'class_level' => 1],
            ['name' => 'Hana Safitri', 'parent_id' => 4, 'education_level' => 'SMP', 'class_level' => 2],
            ['name' => 'Irfan Hakim', 'parent_id' => 5, 'education_level' => 'SMP', 'class_level' => 1],
            ['name' => 'Jasmine Putri', 'parent_id' => 5, 'education_level' => 'SMP', 'class_level' => 3],
            ['name' => 'Krisna Wijaya', 'parent_id' => 6, 'education_level' => 'SMP', 'class_level' => 2],
            ['name' => 'Laila Sari', 'parent_id' => 6, 'education_level' => 'SMP', 'class_level' => 1],
            
            // MA (Madrasah Aliyah - Senior High)
            ['name' => 'Muhammad Rizki', 'parent_id' => 7, 'education_level' => 'MA', 'class_level' => 1],
            ['name' => 'Nadia Putri', 'parent_id' => 7, 'education_level' => 'MA', 'class_level' => 2],
            ['name' => 'Omar Abdullah', 'parent_id' => 8, 'education_level' => 'MA', 'class_level' => 1],
            ['name' => 'Putri Ayu', 'parent_id' => 8, 'education_level' => 'MA', 'class_level' => 3],
            ['name' => 'Qori Amalia', 'parent_id' => 9, 'education_level' => 'MA', 'class_level' => 2],
            ['name' => 'Rafi Ahmad', 'parent_id' => 9, 'education_level' => 'MA', 'class_level' => 1],
            ['name' => 'Sinta Bella', 'parent_id' => 10, 'education_level' => 'MA', 'class_level' => 3],
            ['name' => 'Taufik Hidayat', 'parent_id' => 10, 'education_level' => 'MA', 'class_level' => 2],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
