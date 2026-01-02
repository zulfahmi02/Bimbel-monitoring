@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Guru</h1>
        <a href="{{ route('teacher.games.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition shadow-lg flex items-center gap-2">
            <span>+</span> Buat Game Baru
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium">Total Game Dibuat</div>
            <div class="text-3xl font-bold text-gray-900 mt-2">12</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium">Total Siswa Bermain</div>
            <div class="text-3xl font-bold text-gray-900 mt-2">45</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium">Rata-rata Nilai</div>
            <div class="text-3xl font-bold text-primary-600 mt-2">85.5</div>
        </div>
    </div>

    <!-- Recent Games -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">Game Terbaru</h2>
            <a href="{{ route('teacher.games.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat Semua →</a>
        </div>
        <div class="p-6">
            @if($games->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    Belum ada game yang dibuat. Mulai buat game sekarang!
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($games as $game)
                        <div class="border border-gray-100 rounded-xl p-4 hover:shadow-md transition group">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">{{ $game->subject->name }}</span>
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $game->active ? 'bg-green-50 text-green-600 border border-green-100' : 'bg-gray-50 text-gray-600 border border-gray-100' }}">
                                            {{ $game->active ? 'Active' : 'Draft' }}
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-gray-900 group-hover:text-primary-600 transition line-clamp-2">{{ $game->title }}</h3>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ $game->description ?: 'Tidak ada deskripsi' }}</p>
                            <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                                <span class="text-xs text-gray-400">{{ $game->questions_count }} Soal</span>
                                <a href="{{ route('teacher.games.edit', $game) }}" class="text-xs font-medium text-primary-600 hover:text-primary-700">Edit →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
