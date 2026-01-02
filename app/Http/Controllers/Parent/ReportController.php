<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\GameSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function weeklyReport(Student $student)
    {
        // Security: Ensure student belongs to authenticated parent
        $studentParentId = (int) $student->parent_id;
        $loggedInParentId = (int) Auth::guard('parent')->id();

        if ($studentParentId !== $loggedInParentId) {
            abort(403, "Unauthorized access to student data (Student Parent ID: {$studentParentId}, Your ID: {$loggedInParentId})");
        }

        // Get current week date range
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Get game sessions for this week
        $gameSessions = GameSession::where('student_id', $student->id)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->with(['game.subject', 'game.template'])
            ->get();

        // Calculate statistics
        $totalSessions = $gameSessions->count();
        $completedSessions = $gameSessions->where('status', 'completed')->count();
        $averageScore = $gameSessions->where('status', 'completed')->avg('score') ?? 0;
        $totalPoints = $gameSessions->where('status', 'completed')->sum('score');
        
        // Subject breakdown
        $subjectStats = $gameSessions->where('status', 'completed')
            ->groupBy('game.subject.name')
            ->map(function ($sessions, $subject) {
                return [
                    'subject' => $subject,
                    'sessions' => $sessions->count(),
                    'avg_score' => round($sessions->avg('score'), 2),
                    'total_points' => $sessions->sum('score'),
                ];
            });

        // Get schedules for the week
        $schedules = $student->schedules()
            ->with('subject')
            ->orderByRaw("FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('start_time')
            ->get();

        $data = [
            'student' => $student,
            'parent' => Auth::guard('parent')->user(),
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'gameSessions' => $gameSessions,
            'totalSessions' => $totalSessions,
            'completedSessions' => $completedSessions,
            'averageScore' => round($averageScore, 2),
            'totalPoints' => $totalPoints,
            'subjectStats' => $subjectStats,
            'schedules' => $schedules,
            'generatedAt' => Carbon::now(),
        ];

        $pdf = Pdf::loadView('parent.reports.weekly', $data);
        
        return $pdf->download('laporan-mingguan-' . $student->name . '-' . $startOfWeek->format('Y-m-d') . '.pdf');
    }

    public function gameReport(GameSession $session)
    {
        // Security: Ensure session belongs to authenticated parent's student
        $studentParentId = (int) $session->student->parent_id;
        $loggedInParentId = (int) Auth::guard('parent')->id();
        
        if ($studentParentId !== $loggedInParentId) {
            abort(403, 'Unauthorized access to game session');
        }

        $session->load(['game.subject', 'game.template', 'student', 'answers.question']);

        $data = [
            'session' => $session,
            'student' => $session->student,
            'parent' => Auth::guard('parent')->user(),
            'game' => $session->game,
            'answers' => $session->answers,
            'generatedAt' => Carbon::now(),
        ];

        $pdf = Pdf::loadView('parent.reports.game', $data);
        
        return $pdf->download('laporan-game-' . $session->game->title . '-' . $session->created_at->format('Y-m-d') . '.pdf');
    }
}
