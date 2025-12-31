<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Matematika', 'description' => 'Ilmu tentang bilangan, ruang, dan struktur'],
            ['name' => 'Bahasa Indonesia', 'description' => 'Bahasa nasional Indonesia'],
            ['name' => 'Bahasa Inggris', 'description' => 'Bahasa internasional'],
            ['name' => 'IPA (Ilmu Pengetahuan Alam)', 'description' => 'Ilmu tentang alam dan fenomena alam'],
            ['name' => 'IPS (Ilmu Pengetahuan Sosial)', 'description' => 'Ilmu tentang masyarakat dan kehidupan sosial'],
            ['name' => 'Pendidikan Agama Islam', 'description' => 'Pendidikan agama Islam'],
            ['name' => 'Pendidikan Kewarganegaraan', 'description' => 'Pendidikan tentang kewarganegaraan'],
            ['name' => 'Seni Budaya', 'description' => 'Seni dan budaya Indonesia'],
            ['name' => 'Pendidikan Jasmani', 'description' => 'Pendidikan jasmani, olahraga, dan kesehatan'],
            ['name' => 'Prakarya', 'description' => 'Keterampilan dan prakarya'],
            ['name' => 'Fisika', 'description' => 'Ilmu tentang materi dan energi'],
            ['name' => 'Kimia', 'description' => 'Ilmu tentang zat dan perubahannya'],
            ['name' => 'Biologi', 'description' => 'Ilmu tentang makhluk hidup'],
            ['name' => 'Sejarah', 'description' => 'Ilmu tentang peristiwa masa lalu'],
            ['name' => 'Geografi', 'description' => 'Ilmu tentang bumi dan isinya'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
