@extends('layouts.app')

@section('title', 'Hasil: ' . $session->game->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-secondary-50 to-primary-50 py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    
    <div class="max-w-md w-full">
        <!-- Result Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden relative text-center pb-8 animate-fade-in-up">
            
            <!-- Confetti / Decoration -->
            <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-b from-secondary-100 to-transparent opacity-50"></div>
            
            <div class="relative pt-12 px-6">
                <!-- Avatar -->
                <div class="w-24 h-24 bg-white rounded-full mx-auto shadow-lg flex items-center justify-center text-5xl mb-6 relative z-10 animate-bounce-slow">
                     {{ $student->gender == 'female' ? '👧' : '👦' }}
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-2">Hore! Selesai! 🎉</h1>
                <p class="text-gray-500">Kamu telah menyelesaikan game <br> <span class="font-bold text-secondary-600">{{ $session->game->title }}</span></p>
                
                <!-- Score Circle -->
                <div class="mt-8 mb-8 relative inline-block">
                    <svg class="w-40 h-40 transform -rotate-90">
                        <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="10" fill="transparent" class="text-gray-100" />
                        <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="10" fill="transparent" class="text-secondary-500" stroke-dasharray="440" stroke-dashoffset="{{ 440 - (440 * ($session->score / ($session->game->questions->sum('points') ?: 1))) }}" style="transition: stroke-dashoffset 1s ease-out;" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pt-2">
                        <span class="text-4xl font-black text-gray-800">{{ $session->score }}</span>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Poin</span>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="p-4 bg-green-50 rounded-2xl border border-green-100">
                        <span class="block text-2xl font-bold text-green-600">
                             {{ $session->answers->where('is_correct', true)->count() }}
                        </span>
                        <span class="text-xs font-medium text-green-800 uppercase">Benar</span>
                    </div>
                    <div class="p-4 bg-red-50 rounded-2xl border border-red-100">
                        <span class="block text-2xl font-bold text-red-600">
                            {{ $session->answers->where('is_correct', false)->count() }}
                        </span>
                        <span class="text-xs font-medium text-red-800 uppercase">Salah</span>
                    </div>
                </div>

                <a href="{{ route('parent.games.index') }}" class="block w-full bg-secondary-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-secondary-700 transition transform hover:scale-105">
                    Main Game Lainnya 🚀
                </a>

                <a href="{{ route('parent.dashboard') }}" class="block w-full text-gray-500 font-medium py-4 mt-2 hover:text-gray-900 transition">
                    Kembali ke Dashboard
                </a>

            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }
    .animate-bounce-slow {
        animation: bounce 3s infinite;
    }
</style>
@endsection
