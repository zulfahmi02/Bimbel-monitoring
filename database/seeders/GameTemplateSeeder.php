<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameTemplate;

class GameTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'title' => 'Pilihan Ganda',
                'game_type' => 'multiple_choice',
                'description' => 'Game dengan format pilihan ganda (A, B, C, D)',
                'html_template' => null,
                'css_style' => null,
                'js_code' => null,
                'thumbnail' => null,
            ],
            [
                'title' => 'Isian Singkat',
                'game_type' => 'fill_blank',
                'description' => 'Game dengan format isian singkat',
                'html_template' => null,
                'css_style' => null,
                'js_code' => null,
                'thumbnail' => null,
            ],
            [
                'title' => 'Mencocokkan',
                'game_type' => 'matching',
                'description' => 'Game dengan format mencocokkan pasangan',
                'html_template' => null,
                'css_style' => null,
                'js_code' => null,
                'thumbnail' => null,
            ],
        ];

        foreach ($templates as $template) {
            GameTemplate::create($template);
        }
    }
}
