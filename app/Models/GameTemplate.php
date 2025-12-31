<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameTemplate extends Model
{
    protected $fillable = [
        'title',
        'description',
        'game_type',
        'html_template',
        'css_style',
        'js_code',
        'thumbnail',
    ];

    // Relationships
    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'template_id');
    }

    // Helper methods
    public function isMultipleChoice(): bool
    {
        return $this->game_type === 'multiple_choice';
    }

    public function isFillBlank(): bool
    {
        return $this->game_type === 'fill_blank';
    }

    public function isMatching(): bool
    {
        return $this->game_type === 'matching';
    }
}
