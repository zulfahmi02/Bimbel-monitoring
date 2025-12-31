<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Game extends Model
{
    protected $fillable = [
        'teacher_id',
        'template_id',
        'subject_id',
        'title',
        'description',
        'slug',
        'education_level',
        'class_level',
        'week_number',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Boot method to auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            if (empty($game->slug)) {
                $game->slug = Str::slug($game->title) . '-' . Str::random(6);
            }
        });
    }

    // Relationships
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(GameTemplate::class, 'template_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(GameQuestion::class)->orderBy('order');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(GameSession::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeForEducationLevel($query, $educationLevel)
    {
        return $query->where(function ($q) use ($educationLevel) {
            $q->where('education_level', $educationLevel)
              ->orWhere('education_level', 'ALL');
        });
    }

    public function scopeForClassLevel($query, $classLevel)
    {
        return $query->where(function ($q) use ($classLevel) {
            $q->where('class_level', $classLevel)
              ->orWhere('class_level', 'ALL');
        });
    }

    public function scopeForStudent($query, Student $student)
    {
        return $query->forEducationLevel($student->education_level)
                     ->forClassLevel($student->class_level);
    }

    public function scopeCurrentWeek($query)
    {
        $currentWeek = now()->weekOfYear;
        return $query->where('week_number', $currentWeek);
    }

    // Helper methods
    public function getGameType(): string
    {
        return $this->template ? $this->template->game_type : 'multiple_choice';
    }

    public function getTotalQuestions(): int
    {
        return $this->questions()->count();
    }
}
