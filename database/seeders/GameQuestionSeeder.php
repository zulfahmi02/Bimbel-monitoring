<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\GameQuestion;

class GameQuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Get all games
        $games = Game::all();

        foreach ($games as $game) {
            // Create 5-8 questions per game
            $questionCount = rand(5, 8);
            
            for ($i = 1; $i <= $questionCount; $i++) {
                $this->createQuestionForGame($game, $i);
            }
        }
    }

    private function createQuestionForGame(Game $game, int $order): void
    {
        $questions = $this->getQuestionsBySubject($game->subject->name, $order);
        
        GameQuestion::create([
            'game_id' => $game->id,
            'question_text' => $questions['question'],
            'options' => json_encode($questions['options']),
            'correct_answer' => $questions['correct'],
            'points' => 10,
            'order' => $order,
        ]);
    }

    private function getQuestionsBySubject(string $subject, int $order): array
    {
        $questionBank = [
            'Matematika' => [
                ['question' => 'Berapa hasil dari 5 + 3?', 'options' => ['6', '7', '8', '9'], 'correct' => '8'],
                ['question' => 'Berapa hasil dari 10 - 4?', 'options' => ['4', '5', '6', '7'], 'correct' => '6'],
                ['question' => 'Berapa hasil dari 3 × 4?', 'options' => ['10', '11', '12', '13'], 'correct' => '12'],
                ['question' => 'Berapa hasil dari 20 ÷ 5?', 'options' => ['3', '4', '5', '6'], 'correct' => '4'],
                ['question' => 'Berapa hasil dari 7 + 8?', 'options' => ['13', '14', '15', '16'], 'correct' => '15'],
            ],
            'Bahasa Indonesia' => [
                ['question' => 'Apa ibu kota Indonesia?', 'options' => ['Bandung', 'Surabaya', 'Jakarta', 'Medan'], 'correct' => 'Jakarta'],
                ['question' => 'Kata "berlari" termasuk jenis kata?', 'options' => ['Kata benda', 'Kata kerja', 'Kata sifat', 'Kata keterangan'], 'correct' => 'Kata kerja'],
                ['question' => 'Apa antonim dari kata "tinggi"?', 'options' => ['Besar', 'Rendah', 'Kecil', 'Lebar'], 'correct' => 'Rendah'],
                ['question' => 'Kalimat yang menyatakan perintah disebut?', 'options' => ['Kalimat tanya', 'Kalimat berita', 'Kalimat perintah', 'Kalimat seru'], 'correct' => 'Kalimat perintah'],
                ['question' => 'Apa sinonim dari kata "cantik"?', 'options' => ['Jelek', 'Indah', 'Buruk', 'Kotor'], 'correct' => 'Indah'],
            ],
            'IPA (Ilmu Pengetahuan Alam)' => [
                ['question' => 'Bagian tumbuhan yang berfungsi menyerap air adalah?', 'options' => ['Daun', 'Batang', 'Akar', 'Bunga'], 'correct' => 'Akar'],
                ['question' => 'Proses tumbuhan membuat makanan disebut?', 'options' => ['Respirasi', 'Fotosintesis', 'Transpirasi', 'Evaporasi'], 'correct' => 'Fotosintesis'],
                ['question' => 'Hewan yang berkembang biak dengan bertelur disebut?', 'options' => ['Mamalia', 'Ovipar', 'Vivipar', 'Ovovivipar'], 'correct' => 'Ovipar'],
                ['question' => 'Planet terdekat dengan matahari adalah?', 'options' => ['Venus', 'Bumi', 'Merkurius', 'Mars'], 'correct' => 'Merkurius'],
                ['question' => 'Air mendidih pada suhu?', 'options' => ['50°C', '75°C', '100°C', '125°C'], 'correct' => '100°C'],
            ],
            'Bahasa Inggris' => [
                ['question' => 'What is the English word for "kucing"?', 'options' => ['Dog', 'Cat', 'Bird', 'Fish'], 'correct' => 'Cat'],
                ['question' => 'What color is the sky?', 'options' => ['Red', 'Green', 'Blue', 'Yellow'], 'correct' => 'Blue'],
                ['question' => 'How do you say "Selamat pagi" in English?', 'options' => ['Good night', 'Good morning', 'Good afternoon', 'Good evening'], 'correct' => 'Good morning'],
                ['question' => 'What is the opposite of "big"?', 'options' => ['Large', 'Small', 'Huge', 'Giant'], 'correct' => 'Small'],
                ['question' => 'What is the English word for "meja"?', 'options' => ['Chair', 'Table', 'Desk', 'Bed'], 'correct' => 'Table'],
            ],
            'Fisika' => [
                ['question' => 'Hukum Newton pertama berbicara tentang?', 'options' => ['Gaya', 'Inersia', 'Aksi-Reaksi', 'Gravitasi'], 'correct' => 'Inersia'],
                ['question' => 'Satuan gaya dalam SI adalah?', 'options' => ['Joule', 'Newton', 'Watt', 'Pascal'], 'correct' => 'Newton'],
                ['question' => 'Rumus energi kinetik adalah?', 'options' => ['mgh', '1/2mv²', 'Fd', 'Pt'], 'correct' => '1/2mv²'],
            ],
            'Biologi' => [
                ['question' => 'Organ pencernaan yang menghasilkan enzim pepsin adalah?', 'options' => ['Mulut', 'Lambung', 'Usus', 'Hati'], 'correct' => 'Lambung'],
                ['question' => 'Proses penyerapan sari makanan terjadi di?', 'options' => ['Lambung', 'Usus halus', 'Usus besar', 'Kerongkongan'], 'correct' => 'Usus halus'],
            ],
            'Kimia' => [
                ['question' => 'Simbol kimia untuk emas adalah?', 'options' => ['Au', 'Ag', 'Fe', 'Cu'], 'correct' => 'Au'],
                ['question' => 'Air memiliki rumus kimia?', 'options' => ['H2O', 'CO2', 'O2', 'N2'], 'correct' => 'H2O'],
            ],
        ];

        // Default questions if subject not in bank
        $default = [
            ['question' => "Soal {$order} untuk {$subject}", 'options' => ['A', 'B', 'C', 'D'], 'correct' => 'A'],
        ];

        $questions = $questionBank[$subject] ?? $default;
        $index = ($order - 1) % count($questions);
        
        return $questions[$index];
    }
}
