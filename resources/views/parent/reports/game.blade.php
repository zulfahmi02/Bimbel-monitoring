<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Game - {{ $game->title }}</title>
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

        .score-box {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
        }

        .score-value {
            font-size: 48px;
            font-weight: bold;
            color: #166534;
        }

        .score-label {
            font-size: 14px;
            color: #166534;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
        }

        .answer-list {
            margin-top: 30px;
        }

        .question-item {
            margin-bottom: 15px;
            page-break-inside: avoid;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .question-text {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .answer-status {
            font-size: 12px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-left: 10px;
        }

        .correct {
            background: #dcfce7;
            color: #166534;
        }

        .incorrect {
            background: #fee2e2;
            color: #991b1b;
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
        <div class="title">Laporan Hasil Game</div>
        <div>{{ $game->title }}</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Nama Siswa</strong></td>
            <td width="35%">: {{ $student->name }}</td>
            <td width="15%"><strong>Mata Pelajaran</strong></td>
            <td width="35%">: {{ $game->subject->name }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>: {{ $session->created_at->format('d M Y H:i') }}</td>
            <td><strong>Durasi</strong></td>
            <td>: -</td> {{-- Handle duration later --}}
        </tr>
    </table>

    <div class="score-box">
        <div class="score-value">{{ $session->score }}</div>
        <div class="score-label">Skor Akhir</div>
    </div>

    <div class="answer-list">
        <h3>Detail Jawaban</h3>
        @forelse($answers as $index => $answer)
            <div class="question-item">
                <div class="question-text">
                    {{ $index + 1 }}. {{ $answer->question->question_text }}
                    @if($answer->is_correct)
                        <span class="answer-status correct">Benar (+{{ $answer->question->points }})</span>
                    @else
                        <span class="answer-status incorrect">Salah (0)</span>
                    @endif
                </div>
                {{-- Show answer details if needed, depending on model structure --}}
                {{-- <div>Jawaban Anda: {{ $answer->answer_text ?? '...' }}</div> --}}
            </div>
        @empty
            <p>Tidak ada detail jawaban tersimpan.</p>
        @endforelse
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Taman Belajar Sedjati.
    </div>
</body>

</html>