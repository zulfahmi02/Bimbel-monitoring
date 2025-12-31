@extends('layouts.app')

@section('title', 'Hasil Game - ' . $activeStudent->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Hasil Game</h1>
            <p class="text-gray-600 mt-2">Daftar permainan yang telah diselesaikan <span class="font-semibold">{{ $activeStudent->name }}</span></p>
        </div>
        <a href="{{ route('parent.dashboard') }}" class="flex items-center text-gray-600 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if($gameSessions->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500">Belum ada riwayat permainan.</p>
                <a href="{{ route('parent.games.index') }}" class="inline-block mt-4 bg-secondary-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-secondary-700 transition">
                    Mulai Bermain
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Game</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($gameSessions as $session)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $session->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $session->game->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $session->game->template->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $session->game->subject->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($session->status == 'completed')
                                        <div class="text-sm font-bold {{ $session->score >= 70 ? 'text-green-600' : 'text-orange-600' }}">
                                            {{ $session->score }}
                                        </div>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Berlangsung
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('parent.reports.game', $session) }}" class="text-blue-600 hover:text-blue-900" title="Download Laporan PDF">
                                            📄 PDF
                                        </a>
                                        {{-- Optional: Add link to verify specific answers --}}
                                        {{-- <a href="#" class="text-gray-600 hover:text-gray-900">Detail</a> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $gameSessions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
