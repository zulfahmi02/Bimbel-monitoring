<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();
        $games = Game::where('teacher_id', $teacher->id)
            ->with(['template', 'subject'])
            ->withCount('questions')
            ->latest()
            ->take(5)
            ->get();
            
        return view('teacher.dashboard', compact('games'));
    }
}
