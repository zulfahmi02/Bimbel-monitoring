<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\GameSession;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $parent = Auth::guard('parent')->user();
        $children = $parent->students;
        $activeStudent = null;
        $dashboardData = [];

        if (session()->has('active_student_id')) {
            $activeStudent = $children->where('id', session('active_student_id'))->first();
            
            // Validate if active student still belongs to parent (security check)
            if (!$activeStudent) {
                session()->forget('active_student_id');
            } else {
                // Load comprehensive dashboard data
                $dashboardData = $this->getStudentDashboardData($activeStudent);
            }
        }

        return view('parent.dashboard', array_merge(
            compact('children', 'activeStudent'),
            $dashboardData
        ));
    }

    private function getStudentDashboardData(Student $student)
    {
        // Get current week date range
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Get game sessions for this week
        $weeklyGameSessions = GameSession::where('student_id', $student->id)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->with(['game.subject'])
            ->get();

        // Get all game sessions for history
        $allGameSessions = GameSession::where('student_id', $student->id)
            ->with(['game.subject', 'game.template'])
            ->latest()
            ->take(10)
            ->get();

        // Calculate weekly statistics
        $weeklyStats = [
            'total_sessions' => $weeklyGameSessions->count(),
            'completed_sessions' => $weeklyGameSessions->where('status', 'completed')->count(),
            'average_score' => round($weeklyGameSessions->where('status', 'completed')->avg('score') ?? 0, 2),
            'total_points' => $weeklyGameSessions->where('status', 'completed')->sum('score'),
            'completion_rate' => $weeklyGameSessions->count() > 0 
                ? round(($weeklyGameSessions->where('status', 'completed')->count() / $weeklyGameSessions->count()) * 100, 2)
                : 0,
        ];

        // Get schedules for current week
        $schedules = Schedule::where('student_id', $student->id)
            ->with('subject')
            ->orderByRaw("FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('start_time')
            ->get();

        // Get upcoming schedules (today and future)
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        $todayEnglish = Carbon::now()->format('l'); // Monday, Tuesday, etc.
        $today = $dayMap[$todayEnglish]; // Convert to Indonesian
        
        $upcomingSchedules = $schedules->filter(function($schedule) use ($today) {
            $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $todayIndex = array_search($today, $daysOfWeek);
            $scheduleIndex = array_search($schedule->day_of_week, $daysOfWeek);
            return $scheduleIndex >= $todayIndex;
        })->take(3);

        // Subject-wise performance
        $subjectPerformance = $allGameSessions->where('status', 'completed')
            ->groupBy('game.subject.name')
            ->map(function ($sessions) {
                return [
                    'sessions' => $sessions->count(),
                    'avg_score' => round($sessions->avg('score'), 2),
                    'total_points' => $sessions->sum('score'),
                ];
            });

        return [
            'weeklyStats' => $weeklyStats,
            'schedules' => $schedules,
            'upcomingSchedules' => $upcomingSchedules,
            'recentGameSessions' => $allGameSessions,
            'subjectPerformance' => $subjectPerformance,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
        ];
    }

    public function selectChild(Student $student)
    {
        $parent = Auth::guard('parent')->user();
        
        // Convert to integers to ensure proper comparison
        $studentParentId = (int) $student->parent_id;
        $loggedInParentId = (int) $parent->id;
        
        // Debug logging
        \Log::info('SelectChild Debug', [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'student_parent_id' => $studentParentId,
            'student_parent_id_type' => gettype($student->parent_id),
            'logged_in_parent_id' => $loggedInParentId,
            'logged_in_parent_id_type' => gettype($parent->id),
            'logged_in_parent_name' => $parent->name,
            'match' => $studentParentId === $loggedInParentId
        ]);
        
        // Ensure student belongs to authorized parent
        if ($studentParentId !== $loggedInParentId) {
            \Log::warning('Unauthorized child selection attempt', [
                'parent_id' => $loggedInParentId,
                'parent_name' => $parent->name,
                'student_id' => $student->id,
                'student_name' => $student->name,
                'student_parent_id' => $studentParentId
            ]);
            
            return redirect()->route('parent.dashboard')
                ->with('error', "Anda tidak memiliki akses ke profil siswa ini. (Student parent_id: {$studentParentId}, Your ID: {$loggedInParentId})");
        }

        session(['active_student_id' => $student->id]);

        return redirect()->route('parent.dashboard')->with('success', "Profil siswa {$student->name} dipilih.");
    }

    public function viewSchedules()
    {
        $parent = Auth::guard('parent')->user();
        $activeStudent = $this->getActiveStudent($parent);

        if (!$activeStudent) {
            return redirect()->route('parent.dashboard')->with('error', 'Pilih siswa terlebih dahulu.');
        }

        $schedules = Schedule::where('student_id', $activeStudent->id)
            ->with('subject')
            ->orderByRaw("FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('start_time')
            ->get();

        return view('parent.schedules', compact('activeStudent', 'schedules'));
    }

    public function viewProgress()
    {
        $parent = Auth::guard('parent')->user();
        $activeStudent = $this->getActiveStudent($parent);

        if (!$activeStudent) {
            return redirect()->route('parent.dashboard')->with('error', 'Pilih siswa terlebih dahulu.');
        }

        // Get game sessions for last 4 weeks
        $fourWeeksAgo = Carbon::now()->subWeeks(4);
        $gameSessions = GameSession::where('student_id', $activeStudent->id)
            ->where('created_at', '>=', $fourWeeksAgo)
            ->with(['game.subject'])
            ->get();

        // Weekly trend data
        $weeklyTrend = [];
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $weekSessions = $gameSessions->filter(function($session) use ($weekStart, $weekEnd) {
                return $session->created_at->between($weekStart, $weekEnd);
            });

            $weeklyTrend[] = [
                'week' => 'Minggu ' . (4 - $i),
                'sessions' => $weekSessions->count(),
                'avg_score' => round($weekSessions->where('status', 'completed')->avg('score') ?? 0, 2),
            ];
        }

        // Subject performance
        $subjectPerformance = $gameSessions->where('status', 'completed')
            ->groupBy('game.subject.name')
            ->map(function ($sessions) {
                return [
                    'sessions' => $sessions->count(),
                    'avg_score' => round($sessions->avg('score'), 2),
                    'total_points' => $sessions->sum('score'),
                ];
            });

        return view('parent.progress', compact('activeStudent', 'weeklyTrend', 'subjectPerformance', 'gameSessions'));
    }

    public function viewGameResults()
    {
        $parent = Auth::guard('parent')->user();
        $activeStudent = $this->getActiveStudent($parent);

        if (!$activeStudent) {
            return redirect()->route('parent.dashboard')->with('error', 'Pilih siswa terlebih dahulu.');
        }

        $gameSessions = GameSession::where('student_id', $activeStudent->id)
            ->with(['game.subject', 'game.template'])
            ->latest()
            ->paginate(15);

        return view('parent.game-results', compact('activeStudent', 'gameSessions'));
    }

    private function getActiveStudent($parent)
    {
        if (!session()->has('active_student_id')) {
            return null;
        }

        $student = $parent->students()->find(session('active_student_id'));
        
        if (!$student) {
            session()->forget('active_student_id');
            return null;
        }

        return $student;
    }
}
