@extends('layouts.app')

@section('title', 'Dashboard Orang Tua')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 shadow-sm border border-green-100 animate-fade-in-down">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 shadow-sm border border-red-100">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Orang Tua</h1>
        <p class="text-gray-600 mt-2">Selamat datang, <span class="font-semibold">{{ Auth::guard('parent')->user()->name }}</span>. Pantau perkembangan belajar anak Anda.</p>
    </div>

    @if($activeStudent)
        {{-- Active Student Header --}}
        <div class="bg-gradient-to-r from-secondary-600 to-secondary-800 rounded-2xl shadow-lg p-6 mb-10 text-white relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 p-4 rounded-full backdrop-blur-sm">
                        <span class="text-4xl">🎓</span>
                    </div>
                    <div>
                        <p class="text-secondary-100 text-sm font-medium uppercase tracking-wider">Siswa Aktif</p>
                        <h2 class="text-3xl font-bold">{{ $activeStudent->name }}</h2>
                        <p class="opacity-90 mt-1">{{ $activeStudent->education_level }} - Kelas {{ $activeStudent->class_level }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                     <a href="{{ route('parent.games.index') }}" class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-yellow-300 transition transform hover:scale-105 flex items-center gap-2 border-2 border-yellow-500">
                        <span>🎮</span> Dashboard Game
                    </a>
                </div>
            </div>
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-white opacity-5"></div>
        </div>

        {{-- Quick Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Sesi Minggu Ini</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $weeklyStats['total_sessions'] }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <span class="text-2xl">📊</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Rata-rata Skor</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $weeklyStats['average_score'] }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <span class="text-2xl">⭐</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Tingkat Selesai</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $weeklyStats['completion_rate'] }}%</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <span class="text-2xl">✅</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Poin</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $weeklyStats['total_points'] }}</p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-lg">
                        <span class="text-2xl">🏆</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            
            {{-- Jadwal Bimbel Section --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span>📅</span> Jadwal Bimbel Minggu Ini
                    </h3>
                    <a href="{{ route('parent.schedules') }}" class="text-secondary-600 hover:text-secondary-700 text-sm font-semibold">
                        Lihat Semua →
                    </a>
                </div>

                @if($upcomingSchedules->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <p>Tidak ada jadwal yang akan datang</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($upcomingSchedules as $schedule)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="bg-secondary-100 p-3 rounded-lg">
                                    <p class="text-xs font-bold text-secondary-700">{{ substr($schedule->day_of_week, 0, 3) }}</p>
                                </div>
                                <div class="flex-grow">
                                    <p class="font-semibold text-gray-900">{{ $schedule->subject->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Menu Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('parent.progress') }}" class="block p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:from-blue-100 hover:to-blue-200 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📈</span>
                            <div>
                                <p class="font-semibold text-gray-900">Monitor Perkembangan</p>
                                <p class="text-xs text-gray-600">Lihat progress detail</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('parent.game-results') }}" class="block p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg hover:from-green-100 hover:to-green-200 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🎯</span>
                            <div>
                                <p class="font-semibold text-gray-900">Hasil Game</p>
                                <p class="text-xs text-gray-600">Riwayat permainan</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('parent.reports.weekly', $activeStudent) }}" class="block p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg hover:from-purple-100 hover:to-purple-200 transition">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📄</span>
                            <div>
                                <p class="font-semibold text-gray-900">Laporan Mingguan</p>
                                <p class="text-xs text-gray-600">Download PDF</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('parent.games.index') }}" class="block p-4 bg-gradient-to-r from-yellow-200 to-yellow-300 rounded-lg hover:from-yellow-300 hover:to-yellow-400 transition border-2 border-yellow-500 shadow-md">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🎮</span>
                            <div>
                                <p class="font-bold text-gray-900">Mainkan Game</p>
                                <p class="text-xs text-gray-700 font-medium">Akses game edukasi</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Game Sessions --}}
        <div class="bg-white rounded-xl shadow-md p-6 mb-10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <span>🎮</span> Aktivitas Game Terbaru
                </h3>
                <a href="{{ route('parent.game-results') }}" class="text-secondary-600 hover:text-secondary-700 text-sm font-semibold">
                    Lihat Semua →
                </a>
            </div>

            @if($recentGameSessions->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <p>Belum ada aktivitas game</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Game</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentGameSessions as $session)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $session->game->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $session->game->subject->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $session->score ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($session->status === 'completed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Berlangsung
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $session->created_at->format('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Subject Performance Overview --}}
        @if($subjectPerformance->isNotEmpty())
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span>📚</span> Performa per Mata Pelajaran
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($subjectPerformance as $subject => $stats)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="font-semibold text-gray-900 mb-2">{{ $subject }}</p>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sesi:</span>
                                <span class="font-bold">{{ $stats['sessions'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Rata-rata:</span>
                                <span class="font-bold text-green-600">{{ $stats['avg_score'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Poin:</span>
                                <span class="font-bold text-blue-600">{{ $stats['total_points'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    @endif

    {{-- Student Selection Section --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary-500" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
            </svg>
            Daftar Anak
        </h2>
    </div>

    @if($children->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
            <p class="text-gray-500 mb-2">Belum ada data siswa yang terhubung.</p>
            <p class="text-sm text-gray-400">Silahkan hubungi Admin untuk menambahkan data anak Anda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($children as $child)
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden hover:shadow-lg transition cursor-pointer group flex flex-col h-full relative {{ $activeStudent && $activeStudent->id === $child->id ? 'ring-2 ring-secondary-500 ring-offset-2' : '' }}">
                     {{-- Selection Form Overlay --}}
                     <form action="{{ route('parent.select-child', $child) }}" method="POST" class="absolute inset-0 z-10 opacity-0 group-hover:opacity-100 transition duration-300 bg-secondary-900/10 flex items-center justify-center backdrop-blur-[1px]">
                        @csrf
                        @if(!$activeStudent || $activeStudent->id !== $child->id)
                            <button type="submit" class="bg-white text-secondary-700 px-6 py-2 rounded-full font-bold shadow-lg transform scale-90 group-hover:scale-100 transition">
                                Pilih Profil Ini
                            </button>
                        @endif
                    </form>

                    <div class="h-24 bg-gradient-to-br from-secondary-100 to-secondary-200 relative">
                        <div class="absolute -bottom-8 left-6">
                            <div class="w-16 h-16 bg-white rounded-full p-1 shadow-sm {{ $activeStudent && $activeStudent->id === $child->id ? 'border-2 border-secondary-500' : '' }}">
                                <div class="w-full h-full bg-secondary-50 rounded-full flex items-center justify-center text-3xl">
                                    {{ $child->gender == 'female' ? '👧' : '👦' }}
                                </div>
                            </div>
                        </div>
                        @if($activeStudent && $activeStudent->id === $child->id)
                            <div class="absolute top-4 right-4 bg-secondary-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                Aktif
                            </div>
                        @endif
                    </div>
                    
                    <div class="pt-10 p-6 flex-grow">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-secondary-600 transition">{{ $child->name }}</h3>
                        <p class="text-sm text-gray-500 font-medium">{{ $child->education_level }} - Kelas {{ $child->class_level }}</p>
                        
                        <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                             {{-- Stats Placeholder --}}
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Total Sesi Game</span>
                                <span class="font-bold text-gray-700">{{ $child->gameSessions()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
