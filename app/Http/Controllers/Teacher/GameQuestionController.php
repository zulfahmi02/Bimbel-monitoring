<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GameQuestionController extends Controller
{
    public function create(Game $game)
    {
        $this->authorize('manageQuestions', $game);

        return view('teacher.questions.create', compact('game'));
    }

    public function store(Request $request, Game $game)
    {
        $this->authorize('manageQuestions', $game);

        $request->validate([
            'question_text' => 'required|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string',
            'points' => 'required|integer|min:1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('question-images', 'public');
        }

        // Validate correct answer is one of the options
        if (!in_array($request->correct_answer, $request->options)) {
            return back()->withErrors(['correct_answer' => 'Jawaban benar harus merupakan salah satu dari opsi.'])->withInput();
        }

        $game->questions()->create([
            'question_text' => $request->question_text,
            'image' => $imagePath,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'points' => $request->points,
        ]);

        return redirect()->route('teacher.games.edit', ['game' => $game->id, 'tab' => 'questions'])
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit(Game $game, GameQuestion $question)
    {
        $this->authorize('manageQuestions', $game);
        
        if ($question->game_id !== $game->id) {
            abort(403);
        }

        return view('teacher.questions.edit', compact('game', 'question'));
    }

    public function update(Request $request, Game $game, GameQuestion $question)
    {
        $this->authorize('manageQuestions', $game);
        
        if ($question->game_id !== $game->id) {
            abort(403);
        }

        $request->validate([
            'question_text' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string',
            'points' => 'required|integer|min:1',
        ]);

        $data = [
            'question_text' => $request->question_text,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'points' => $request->points,
        ];

        if ($request->hasFile('image')) {
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
            $data['image'] = $request->file('image')->store('question-images', 'public');
        }
        
        // Remove image if requested
        if ($request->boolean('remove_image') && $question->image) {
            Storage::disk('public')->delete($question->image);
            $data['image'] = null;
        }

        if (!in_array($request->correct_answer, $request->options)) {
             return back()->withErrors(['correct_answer' => 'Jawaban benar harus merupakan salah satu dari opsi.'])->withInput();
        }

        $question->update($data);

        return redirect()->route('teacher.games.edit', ['game' => $game->id, 'tab' => 'questions'])
            ->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy(Game $game, GameQuestion $question)
    {
        $this->authorize('manageQuestions', $game);
        
        if ($question->game_id !== $game->id) {
            abort(403);
        }

        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }

        $question->delete();

        return back()->with('success', 'Soal berhasil dihapus.');
    }
}
