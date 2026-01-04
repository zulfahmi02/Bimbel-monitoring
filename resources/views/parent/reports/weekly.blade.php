<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Mingguan - {{ $student->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
        }

        .title {
            font-size: 20px;
            margin-top: 10px;
            font-weight: bold;
        }

        .date {
            color: #666;
            font-size: 14px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .stat-box {
            display: table-cell;
            text-align: center;
            padding: 15px;
            border: 1px solid #eee;
            background: #f9fafb;
            width: 25%;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
        }

        .stat-label {
            font-size: 12px;
            color: #6B7280;
            text-transform: uppercase;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            color: #374151;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #e5e7eb;
            padding: 8px 12px;
            text-align: left;
        }

        .data-table th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #374151;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #9CA3AF;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">Taman Belajar Sedjati</div>
        <div class="title">Laporan Perkembangan Mingguan</div>
        <div class="date">Periode: {{ $startOfWeek->format('d M Y') }} - {{ $endOfWeek->format('d M Y') }}</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Nama Siswa</strong></td>
            <td width="35%">: {{ $student->name }}</td>
            <td width="15%"><strong>Kelas</strong></td>
            <td width="35%">: {{ $student->education_level }} - Kelas {{ $student->class_level }}</td>
        </tr>
        <tr>
            <td><strong>Orang Tua</strong></td>
            <td>: {{ $parent->name }}</td>
            <td><strong>Tanggal Cetak</strong></td>
            <td>: {{ $generatedAt->format('d M Y H:i') }}</td>
        </tr>
    </table>

    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-value">{{ $totalSessions }}</div>
            <div class="stat-label">Total Sesi</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $averageScore }}</div>
            <div class="stat-label">Rata-rata Skor</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $totalPoints }}</div>
            <div class="stat-label">Total Poin</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $completedSessions }}</div>
            <div class="stat-label">Sesi Selesai</div>
        </div>
    </div>

    <div class="section-title">Performa Mata Pelajaran</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Sesi</th>
                <th>Rata-rata Skor</th>
                <th>Total Poin</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjectStats as $stat)
                <tr>
                    <td>{{ $stat['subject'] }}</td>
                    <td>{{ $stat['sessions'] }}</td>
                    <td>{{ $stat['avg_score'] }}</td>
                    <td>{{ $stat['total_points'] }}</td>
                    <td>
                        @if($stat['avg_score'] >= 80) Sangat Baik
                        @elseif($stat['avg_score'] >= 60) Baik
                        @else Perlu Peningkatan
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data aktivitas belajar minggu ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Jadwal Minggu Ini</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam</th>
                <th>Mata Pelajaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->day_of_week }}</td>
                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                    <td>{{ $schedule->subject->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada jadwal.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} Taman Belajar Sedjati. Laporan ini dibuat secara otomatis oleh sistem.
    </div>
</body>

</html>