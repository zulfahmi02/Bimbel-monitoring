<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameQuestion extends Model
{
    protected $fillable = [
        'game_id',
        'question_text',
        'correct_answer',
        'options',
        'points',
        'image',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // Relationships
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(GameAnswer::class, 'question_id');
    }

    // Helper methods
    public function checkAnswer(string $answer): bool
    {
        return strtolower(trim($answer)) === strtolower(trim($this->correct_answer));
    }

    public function hasOptions(): bool
    {
        return !empty($this->options) && is_array($this->options);
    }
}
