@extends('layouts.app')

@section('title', 'Jadwal Bimbel - ' . $activeStudent->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Jadwal Bimbel</h1>
            <p class="text-gray-600 mt-2">Jadwal belajar untuk <span class="font-semibold">{{ $activeStudent->name }}</span></p>
        </div>
        <a href="{{ route('parent.dashboard') }}" class="flex items-center text-gray-600 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-lg text-gray-900">Jadwal Mingguan</h3>
            <span class="bg-secondary-100 text-secondary-800 text-xs font-bold px-3 py-1 rounded-full">
                {{ $schedules->count() }} Sesi / Minggu
            </span>
        </div>
        
        @if($schedules->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500">Belum ada jadwal yang diatur.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                    @php
                        $daySchedules = $schedules->where('day_of_week', $day);
                    @endphp
                    
                    @if($daySchedules->isNotEmpty())
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-100 px-4 py-2 font-bold text-gray-700 border-b border-gray-200 flex justify-between items-center">
                                <span>{{ $day }}</span>
                                <span class="bg-white text-gray-600 text-xs px-2 py-0.5 rounded-full border border-gray-300">{{ $daySchedules->count() }}</span>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @foreach($daySchedules as $schedule)
                                    <div class="p-4 hover:bg-gray-50 transition">
                                        <p class="font-bold text-secondary-700 text-lg">{{ $schedule->subject->name }}</p>
                                        <div class="flex items-center text-gray-500 text-sm mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
