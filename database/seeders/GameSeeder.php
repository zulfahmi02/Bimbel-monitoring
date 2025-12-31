<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\GameTemplate;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $multipleChoiceTemplate = GameTemplate::where('game_type', 'multiple_choice')->first();
        $fillBlankTemplate = GameTemplate::where('game_type', 'fill_blank')->first();

        $games = [
            // Matematika Games
            [
                'teacher_id' => 1,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Matematika')->first()->id,
                'title' => 'Penjumlahan dan Pengurangan Dasar',
                'description' => 'Game untuk melatih kemampuan penjumlahan dan pengurangan',
                'education_level' => 'MI',
                'class_level' => '1',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
            [
                'teacher_id' => 1,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Matematika')->first()->id,
                'title' => 'Perkalian dan Pembagian',
                'description' => 'Latihan perkalian dan pembagian untuk kelas 3',
                'education_level' => 'MI',
                'class_level' => '3',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
            [
                'teacher_id' => 1,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Fisika')->first()->id,
                'title' => 'Hukum Newton',
                'description' => 'Memahami hukum-hukum Newton tentang gerak',
                'education_level' => 'MA',
                'class_level' => '1',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],

            // Bahasa Indonesia Games
            [
                'teacher_id' => 2,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Bahasa Indonesia')->first()->id,
                'title' => 'Mengenal Huruf dan Kata',
                'description' => 'Belajar mengenal huruf dan kata sederhana',
                'education_level' => 'MI',
                'class_level' => '1',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
            [
                'teacher_id' => 2,
                'template_id' => $fillBlankTemplate->id,
                'subject_id' => Subject::where('name', 'Bahasa Indonesia')->first()->id,
                'title' => 'Ejaan Yang Disempurnakan (EYD)',
                'description' => 'Latihan penggunaan EYD yang benar',
                'education_level' => 'SMP',
                'class_level' => '1',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
            [
                'teacher_id' => 2,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Bahasa Inggris')->first()->id,
                'title' => 'English Vocabulary - Animals',
                'description' => 'Learn vocabulary about animals in English',
                'education_level' => 'MI',
                'class_level' => '4',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],

            // IPA Games
            [
                'teacher_id' => 3,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'IPA (Ilmu Pengetahuan Alam)')->first()->id,
                'title' => 'Bagian-Bagian Tumbuhan',
                'description' => 'Mengenal bagian-bagian tumbuhan dan fungsinya',
                'education_level' => 'MI',
                'class_level' => '2',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
            [
                'teacher_id' => 3,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Biologi')->first()->id,
                'title' => 'Sistem Pencernaan Manusia',
                'description' => 'Memahami sistem pencernaan pada manusia',
                'education_level' => 'SMP',
                'class_level' => '2',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
            [
                'teacher_id' => 3,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Kimia')->first()->id,
                'title' => 'Tabel Periodik Unsur',
                'description' => 'Mengenal unsur-unsur dalam tabel periodik',
                'education_level' => 'MA',
                'class_level' => '1',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],

            // IPS Games
            [
                'teacher_id' => 4,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'IPS (Ilmu Pengetahuan Sosial)')->first()->id,
                'title' => 'Mengenal Profesi',
                'description' => 'Belajar tentang berbagai profesi di masyarakat',
                'education_level' => 'MI',
                'class_level' => '2',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
            [
                'teacher_id' => 4,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Sejarah')->first()->id,
                'title' => 'Proklamasi Kemerdekaan Indonesia',
                'description' => 'Memahami peristiwa proklamasi kemerdekaan RI',
                'education_level' => 'SMP',
                'class_level' => '2',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
            [
                'teacher_id' => 4,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Geografi')->first()->id,
                'title' => 'Peta dan Komponen Peta',
                'description' => 'Mengenal peta dan komponen-komponennya',
                'education_level' => 'SMP',
                'class_level' => '1',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],

            // Seni & Prakarya
            [
                'teacher_id' => 5,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Seni Budaya')->first()->id,
                'title' => 'Alat Musik Tradisional Indonesia',
                'description' => 'Mengenal alat musik tradisional dari berbagai daerah',
                'education_level' => 'MI',
                'class_level' => '5',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
            [
                'teacher_id' => 5,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Prakarya')->first()->id,
                'title' => 'Kerajinan dari Barang Bekas',
                'description' => 'Belajar membuat kerajinan dari barang bekas',
                'education_level' => 'SMP',
                'class_level' => '1',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],

            // PKN
            [
                'teacher_id' => 1,
                'template_id' => $multipleChoiceTemplate->id,
                'subject_id' => Subject::where('name', 'Pendidikan Kewarganegaraan')->first()->id,
                'title' => 'Pancasila dan UUD 1945',
                'description' => 'Memahami nilai-nilai Pancasila dan UUD 1945',
                'education_level' => 'MA',
                'class_level' => '1',
                'week_number' => now()->weekOfYear,
                'active' => true,
            ],
        ];

        foreach ($games as $game) {
            // Generate slug from title
            $game['slug'] = \Illuminate\Support\Str::slug($game['title']) . '-' . \Illuminate\Support\Str::random(6);
            Game::create($game);
        }
    }
}
