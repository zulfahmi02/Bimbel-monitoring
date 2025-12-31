<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'budi.santoso@padosilmu.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567801',
                'status' => 'approved',
                'approved_at' => now(),
                'subjects' => ['Matematika', 'Fisika']
            ],
            [
                'name' => 'Siti Nurhaliza, M.Pd',
                'email' => 'siti.nurhaliza@padosilmu.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567802',
                'status' => 'approved',
                'approved_at' => now(),
                'subjects' => ['Bahasa Indonesia', 'Bahasa Inggris']
            ],
            [
                'name' => 'Ahmad Fauzi, S.Si',
                'email' => 'ahmad.fauzi@padosilmu.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567803',
                'status' => 'approved',
                'approved_at' => now(),
                'subjects' => ['IPA (Ilmu Pengetahuan Alam)', 'Biologi', 'Kimia']
            ],
            [
                'name' => 'Dewi Lestari, S.Pd',
                'email' => 'dewi.lestari@padosilmu.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567804',
                'status' => 'approved',
                'approved_at' => now(),
                'subjects' => ['IPS (Ilmu Pengetahuan Sosial)', 'Sejarah', 'Geografi']
            ],
            [
                'name' => 'Rizki Ramadhan, S.Kom',
                'email' => 'rizki.ramadhan@padosilmu.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567805',
                'status' => 'approved',
                'approved_at' => now(),
                'subjects' => ['Prakarya', 'Seni Budaya']
            ],
            [
                'name' => 'Andi Wijaya, S.Pd',
                'email' => 'andi.wijaya@padosilmu.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567806',
                'status' => 'pending',
                'approved_at' => null,
                'subjects' => ['Pendidikan Jasmani']
            ],
            [
                'name' => 'Maya Sari, S.Ag',
                'email' => 'maya.sari@padosilmu.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567807',
                'status' => 'pending',
                'approved_at' => null,
                'subjects' => ['Pendidikan Agama Islam']
            ],
        ];

        foreach ($teachers as $teacherData) {
            $subjectNames = $teacherData['subjects'];
            unset($teacherData['subjects']);

            $teacher = Teacher::create($teacherData);

            // Attach subjects
            $subjects = Subject::whereIn('name', $subjectNames)->get();
            $teacher->subjects()->attach($subjects->pluck('id'));
        }
    }
}
