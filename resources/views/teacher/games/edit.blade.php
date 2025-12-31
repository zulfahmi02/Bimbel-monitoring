@extends('layouts.app')

@section('title', 'Edit Game')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'questions' }">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('teacher.games.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Game: {{ $game->title }}</h1>
        </div>
        <div class="flex gap-2">
             <a href="#" target="_blank" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
                Preview
            </a>
            <button form="update-game-form" type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition font-medium">
                Simpan Perubahan
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 flex items-center gap-3 border border-green-100 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex gap-6 items-start">
        <!-- Sidebar Navigation -->
        <div class="w-64 flex-shrink-0 bg-white rounded-xl shadow-sm border border-gray-100 p-2 sticky top-24">
            <button @click="activeTab = 'settings'" :class="activeTab === 'settings' ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-3 rounded-lg font-medium transition flex items-center gap-3 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                Pengaturan Game
            </button>
            <button @click="activeTab = 'questions'" :class="activeTab === 'questions' ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-3 rounded-lg font-medium transition flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                </svg>
                Kelola Soal ({{ $game->questions->count() }})
            </button>
        </div>

        <!-- Content Area -->
        <div class="flex-grow">
            
            <!-- Settings Tab -->
            <div x-show="activeTab === 'settings'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-4">Pengaturan Dasar</h2>
                    
                    <form id="update-game-form" action="{{ route('teacher.games.update', $game) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Game</label>
                            <input type="text" name="title" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" value="{{ old('title', $game->title) }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                            <select name="subject_id" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" required>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $game->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang</label>
                                <select name="education_level" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" required>
                                    <option value="MI" {{ $game->education_level == 'MI' ? 'selected' : '' }}>MI</option>
                                    <option value="SMP" {{ $game->education_level == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="MA" {{ $game->education_level == 'MA' ? 'selected' : '' }}>MA</option>
                                    <option value="ALL" {{ $game->education_level == 'ALL' ? 'selected' : '' }}>Semua</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                <select name="class_level" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" required>
                                    <option value="ALL" {{ $game->class_level == 'ALL' ? 'selected' : '' }}>Semua</option>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ $game->class_level == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">{{ old('description', $game->description) }}</textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-2">
                             <input type="checkbox" id="active" name="active" value="1" {{ $game->active ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                             <label for="active" class="font-medium text-gray-700">Publikasikan Game (Agar bisa dimainkan siswa)</label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Questions Tab -->
            <div x-show="activeTab === 'questions'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6 border-b pb-4">
                        <h2 class="text-lg font-bold text-gray-900">Daftar Soal</h2>
                        <a href="{{ route('teacher.games.questions.create', $game) }}" class="bg-primary-50 text-primary-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-100 transition">
                            + Tambah Soal
                        </a>
                    </div>

                    @if($game->questions->isEmpty())
                         <div class="text-center py-12 bg-gray-50 rounded-xl dashed-border border-2 border-dashed border-gray-200">
                            <p class="text-gray-500 mb-3">Belum ada soal ditambahkan.</p>
                             <a href="{{ route('teacher.games.questions.create', $game) }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-700 transition shadow-md inline-block">
                                Buat Soal Pertama
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($game->questions as $index => $question)
                                <div class="border border-gray-200 rounded-xl p-4 hover:border-primary-300 transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex gap-3">
                                            <span class="bg-gray-100 text-gray-600 w-6 h-6 rounded flex items-center justify-center text-xs font-bold">{{ $index + 1 }}</span>
                                            <h4 class="font-medium text-gray-900">{{ $question->question_text }}</h4>
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('teacher.games.questions.edit', [$game, $question]) }}" class="text-gray-400 hover:text-blue-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <form action="{{ route('teacher.games.questions.destroy', [$game, $question]) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                            </form>
                                        </div>
                                    </div>
                                    @if($question->image)
                                        <img src="{{ asset('storage/' . $question->image) }}" class="h-20 object-cover rounded-lg mb-2">
                                    @endif
                                    <div class="text-sm text-gray-500 pl-9">
                                        Jawaban Benar: <span class="font-bold text-green-600">{{ $question->correct_answer }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
