@extends('layouts.app')

@section('title', 'Monitor Perkembangan - ' . $activeStudent->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Monitor Perkembangan</h1>
            <p class="text-gray-600 mt-2">Analisis hasil belajar <span class="font-semibold">{{ $activeStudent->name }}</span></p>
        </div>
        <a href="{{ route('parent.dashboard') }}" class="flex items-center text-gray-600 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        {{-- Weekly Trend Chart --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="font-bold text-lg text-gray-900 mb-4">Tren Nilai Rata-rata (4 Minggu Terakhir)</h3>
            <div class="h-64">
                <canvas id="weeklyTrendChart"></canvas>
            </div>
        </div>

        {{-- Subject Performance Chart --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="font-bold text-lg text-gray-900 mb-4">Performa per Mata Pelajaran</h3>
            <div class="h-64">
                <canvas id="subjectPerformanceChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-lg text-gray-900">Detail Performa Mata Pelajaran</h3>
        </div>
        
        @if($subjectPerformance->isEmpty())
             <div class="text-center py-12 text-gray-500">
                <p>Belum ada data permainan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sesi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata Skor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Poin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($subjectPerformance as $subject => $stats)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $subject }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $stats['sessions'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold {{ $stats['avg_score'] >= 80 ? 'text-green-600' : ($stats['avg_score'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $stats['avg_score'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-blue-600 font-medium">{{ $stats['total_points'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($stats['avg_score'] >= 80)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sangat Baik</span>
                                    @elseif($stats['avg_score'] >= 60)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Baik</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Perlu Peningkatan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Weekly Trend Chart
        const weeklyCtx = document.getElementById('weeklyTrendChart').getContext('2d');
        const weeklyTrendData = @json($weeklyTrend);
        
        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: weeklyTrendData.map(d => d.week),
                datasets: [{
                    label: 'Rata-rata Skor',
                    data: weeklyTrendData.map(d => d.avg_score),
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Subject Performance Chart
        const subjectCtx = document.getElementById('subjectPerformanceChart').getContext('2d');
        const subjectData = @json($subjectPerformance);
        const subjects = Object.keys(subjectData);
        
        new Chart(subjectCtx, {
            type: 'bar',
            data: {
                labels: subjects,
                datasets: [{
                    label: 'Rata-rata Skor',
                    data: subjects.map(s => subjectData[s].avg_score),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    });
</script>
@endsection
