@extends('layouts.app')

@section('title', 'Buat Game Baru')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('teacher.games.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Buat Game Baru</h1>
        <p class="text-gray-600 mt-1">Pilih template dan isi detail permainan.</p>
    </div>

    <form action="{{ route('teacher.games.store') }}" method="POST" class="space-y-8" x-data="{ selectedTemplate: null }">
        @csrf

        <!-- Template Selection -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4">1. Pilih Template Game</h2>
            
            @if($templates->isEmpty())
                <div class="text-center p-8 bg-gray-50 rounded-xl text-gray-500">
                    Belum ada template game tersedia dari Admin.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($templates as $template)
                        <label class="cursor-pointer group relative">
                            <input type="radio" name="template_id" value="{{ $template->id }}" class="peer sr-only" x-model="selectedTemplate" required>
                            <div class="rounded-xl border-2 border-gray-200 p-4 hover:border-primary-400 peer-checked:border-primary-600 peer-checked:bg-primary-50 transition h-full flex flex-col">
                                <div class="h-32 bg-gray-100 rounded-lg mb-3 overflow-hidden">
                                     @if($template->thumbnail)
                                        <img src="{{ asset('storage/' . $template->thumbnail) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-4xl">🎮</div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-gray-900 mb-1">{{ $template->title }}</h3>
                                <p class="text-xs text-gray-500 line-clamp-3">{{ $template->description }}</p>
                                <div class="mt-auto pt-3 flex justify-between items-center text-xs text-gray-400">
                                    <span class="capitalize">{{ str_replace('_', ' ', $template->game_type) }}</span>
                                </div>
                            </div>
                            <div class="absolute top-4 right-4 text-primary-600 opacity-0 peer-checked:opacity-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 bg-white rounded-full" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('template_id') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
            @endif
        </div>

        <!-- Game Details -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100" x-show="selectedTemplate" x-transition>
            <h2 class="text-lg font-bold text-gray-900 mb-4">2. Detail Permainan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Game</label>
                    <input type="text" name="title" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" placeholder="Contoh: Kuis Matematika Perkalian" value="{{ old('title') }}" required>
                    @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                    <select name="subject_id" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" required>
                        <option value="">Pilih Mapel...</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang</label>
                        <select name="education_level" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" required>
                            <option value="MI">MI</option>
                            <option value="SMP">SMP</option>
                            <option value="MA">MA</option>
                            <option value="ALL">Semua</option>
                        </select>
                         @error('education_level') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="class_level" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" required>
                            <option value="ALL">Semua</option>
                            @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}">Kelas {{ $i }}</option>
                            @endfor
                        </select>
                        @error('class_level') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Tambahan (Opsional)</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-primary-600 text-white px-8 py-3 rounded-xl hover:bg-primary-700 transition shadow-lg shadow-primary-500/30 font-bold text-lg">
                    Buat & Lanjut ke Soal →
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
