<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameSession;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameSessionController extends Controller
{
    private function getActiveStudent()
    {
        if (!session()->has('active_student_id')) {
            return null;
        }

        $studentId = session('active_student_id');
        $parent = Auth::guard('parent')->user();
        
        // Ensure student belongs to parent
        return $parent->students()->where('id', $studentId)->first();
    }

    public function index()
    {
        $student = $this->getActiveStudent();

        if (!$student) {
            return redirect()->route('parent.dashboard')->with('error', 'Silahkan pilih profil anak terlebih dahulu.');
        }

        // Fetch games matching education level and class level (or ALL) based on Student's data
        // Assuming strict filtering for now, can be loosened later
        $games = Game::query()
            ->where('active', true)
            ->where(function ($query) use ($student) {
                $query->where('education_level', $student->education_level)
                      ->orWhere('education_level', 'ALL');
            })
            ->where(function ($query) use ($student) {
                $query->where('class_level', $student->class_level)
                      ->orWhere('class_level', 'ALL');
            })
            ->with(['subject', 'teacher', 'template'])
            ->withCount('questions')
            ->latest()
            ->get();

        return view('student.games.index', compact('student', 'games'));
    }

    public function show(Game $game)
    {
        $student = $this->getActiveStudent();
        if (!$student) return redirect()->route('parent.dashboard');

        return view('student.games.show', compact('student', 'game'));
    }

    public function start(Game $game)
    {
        $student = $this->getActiveStudent();
        if (!$student) return redirect()->route('parent.dashboard');

        // Create new session
        $session = GameSession::create([
            'game_id' => $game->id,
            'student_id' => $student->id,
            'started_at' => now(),
            'score' => 0,
            'status' => 'in_progress',
        ]);

        return redirect()->route('parent.games.play', $session);
    }

    public function play(GameSession $session)
    {
        $student = $this->getActiveStudent();
        if (!$student || $session->student_id !== $student->id) {
            abort(403);
        }

        if ($session->status === 'completed') {
            return redirect()->route('parent.games.result', $session);
        }

        $game = $session->game()->with('questions')->first();
        
        // Logic to determine current question (simple version: find first unanswered question)
        // Or just load all questions for the view to handle via JS if we want a SPA feel?
        // Let's do SPA feel with Alpine.js since we already decided on that approach for the editor
        // We pass the full game data structure to the view
        
        return view('student.games.play', compact('session', 'game', 'student'));
    }

    public function answer(Request $request, GameSession $session)
    {
        // This endpoint will be used if we submit answers 1 by 1 via AJAX, OR to submit final score.
        // For simplicity and robustness, let's implement a "Finish Game" endpoint that accepts answers
        
        $student = $this->getActiveStudent();
        if (!$student || $session->student_id !== $student->id) {
            abort(403);
        }

        $validated = $request->validate([
             'answers' => 'required|array', // key: question_id, value: selected_option
             'answers.*' => 'required',
        ]);

        $score = 0;
        $correctCount = 0;
        $totalQuestions = $session->game->questions->count();
        $details = [];

        foreach ($session->game->questions as $question) {
            $userAnswer = $validated['answers'][$question->id] ?? null;
            $isCorrect = false;

            if ($userAnswer && $userAnswer == $question->correct_answer) {
                $isCorrect = true;
                $score += $question->points;
                $correctCount++;
            }

            // Save individual answer record
            $session->answers()->create([
                'question_id' => $question->id,
                'answer' => $userAnswer,
                'is_correct' => $isCorrect,
                'points_earned' => $isCorrect ? $question->points : 0,
            ]);
        }

        // Final score calculation (currently simple sum of points)
        // We could also normalize to 100 if needed, but let's stick to raw points for now
        
        $session->update([
            'score' => $score,
            'completed_at' => now(),
            'status' => 'completed'
        ]);

        return response()->json([
            'redirect' => route('parent.games.result', $session)
        ]);
    }

    public function result(GameSession $session)
    {
        $student = $this->getActiveStudent();
        if (!$student || $session->student_id !== $student->id) {
            abort(403);
        }

        $session->load(['game.questions', 'answers']);
        
        return view('student.games.result', compact('session', 'student'));
    }
}
