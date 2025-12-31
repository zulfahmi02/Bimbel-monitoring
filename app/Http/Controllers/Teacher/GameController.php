<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameTemplate;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();
        $games = Game::where('teacher_id', $teacher->id)->latest()->get();
        return view('teacher.games.index', compact('games'));
    }

    public function create()
    {
        $templates = GameTemplate::all();
        $subjects = Auth::guard('teacher')->user()->subjects;
        // Fallback if teacher has no subjects assigned yet, though they should
        if($subjects->isEmpty()) {
             $subjects = Subject::all();
        }
        
        return view('teacher.games.create', compact('templates', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'template_id' => 'required|exists:game_templates,id',
            'subject_id' => 'required|exists:subjects,id',
            'education_level' => 'required|in:MI,SMP,MA,ALL',
            'class_level' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $game = Game::create([
            'teacher_id' => Auth::guard('teacher')->id(),
            'template_id' => $request->template_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(6),
            'description' => $request->description,
            'education_level' => $request->education_level,
            'class_level' => $request->class_level,
            'week_number' => now()->weekOfYear,
            'active' => true,
        ]);

        return redirect()->route('teacher.games.edit', $game)->with('success', 'Game berhasil dibuat! Silahkan tambahkan soal.');
    }

    public function edit(Game $game)
    {
        // Ensure teacher owns the game
        if ($game->teacher_id !== Auth::guard('teacher')->id()) {
            abort(403);
        }

        $templates = GameTemplate::all();
        $subjects = Auth::guard('teacher')->user()->subjects;
         if($subjects->isEmpty()) {
             $subjects = Subject::all();
        }

        return view('teacher.games.edit', compact('game', 'templates', 'subjects'));
    }

    public function update(Request $request, Game $game)
    {
        if ($game->teacher_id !== Auth::guard('teacher')->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'education_level' => 'required|in:MI,SMP,MA,ALL',
            'class_level' => 'required|string',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $game->update([
            'title' => $request->title,
            'subject_id' => $request->subject_id,
            'description' => $request->description,
            'education_level' => $request->education_level,
            'class_level' => $request->class_level,
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('teacher.games.index')->with('success', 'Game berhasil diperbarui!');
    }

    public function destroy(Game $game)
    {
        if ($game->teacher_id !== Auth::guard('teacher')->id()) {
            abort(403);
        }

        $game->delete();

        return redirect()->route('teacher.games.index')->with('success', 'Game berhasil dihapus.');
    }
}
