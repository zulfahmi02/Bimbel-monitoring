<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameSession extends Model
{
    protected $fillable = [
        'game_id',
        'student_id',
        'total_score',
        'correct_answers',
        'total_questions',
        'accuracy',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'accuracy' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(GameAnswer::class, 'session_id');
    }

    // Helper methods
    public function isCompleted(): bool
    {
        return !is_null($this->completed_at);
    }

    public function calculateAccuracy(): void
    {
        if ($this->total_questions > 0) {
            $this->accuracy = ($this->correct_answers / $this->total_questions) * 100;
            $this->save();
        }
    }

    public function addAnswer(GameQuestion $question, string $answer): GameAnswer
    {
        $isCorrect = $question->checkAnswer($answer);
        $pointsEarned = $isCorrect ? $question->points : 0;

        // Update session stats
        $this->total_questions++;
        if ($isCorrect) {
            $this->correct_answers++;
            $this->total_score += $pointsEarned;
        }
        $this->calculateAccuracy();

        // Create answer record
        return $this->answers()->create([
            'question_id' => $question->id,
            'answer' => $answer,
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
        ]);
    }

    public function complete(): void
    {
        $this->completed_at = now();
        $this->save();
    }
}
