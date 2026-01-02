<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\Teacher;
use Illuminate\Auth\Access\Response;

class GamePolicy
{
    /**
     * Determine whether the teacher can view the game.
     */
    public function view(Teacher $teacher, Game $game): bool
    {
        return (int)$game->teacher_id === (int)$teacher->id;
    }

    /**
     * Determine whether the teacher can update the game.
     */
    public function update(Teacher $teacher, Game $game): bool
    {
        return (int)$game->teacher_id === (int)$teacher->id;
    }

    /**
     * Determine whether the teacher can delete the game.
     */
    public function delete(Teacher $teacher, Game $game): bool
    {
        return (int)$game->teacher_id === (int)$teacher->id;
    }

    /**
     * Determine whether the teacher can manage questions for the game.
     */
    public function manageQuestions(Teacher $teacher, Game $game): bool
    {
        return (int)$game->teacher_id === (int)$teacher->id;
    }
}
