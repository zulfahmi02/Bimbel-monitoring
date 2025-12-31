@extends('layouts.app')

@section('title', 'Daftar Game Belajar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Game Belajar</h1>
            <p class="text-gray-600 mt-1">Daftar permainan untuk <span class="font-bold text-secondary-600">{{ $student->name }}</span> ({{ $student->class_level }})</p>
        </div>
        <a href="{{ route('parent.dashboard') }}" class="text-gray-500 hover:text-gray-700 font-medium">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @if($games->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="text-6xl mb-4">🎮</div>
            <h3 class="text-xl font-bold text-gray-900">Belum ada game tersedia</h3>
            <p class="text-gray-500 mt-2">Belum ada game yang cocok untuk jenjang kelasmu saat ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($games as $game)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition transform hover:-translate-y-1 overflow-hidden border border-gray-100 flex flex-col">
                    <div class="h-40 bg-gray-100 relative">
                        @if ($game->template && $game->template->thumbnail)
                             <img src="{{ asset('storage/' . $game->template->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-400 to-secondary-500 text-white text-5xl">
                                🎲
                            </div>
                        @endif
                         <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold shadow-sm">
                            {{ $game->subject->name }}
                        </div>
                    </div>
                    <div class="p-5 flex-grow flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 leading-tight">{{ $game->title }}</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $game->description ?? 'Ayo mainkan game seru ini!' }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-xs text-gray-400 font-medium">{{ $game->questions_count ?? $game->questions->count() }} Soal</span>
                            <form action="{{ route('parent.games.start', $game) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-secondary-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-secondary-700 transition">
                                    Main Sekarang!
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
