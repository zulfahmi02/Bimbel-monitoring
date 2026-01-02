@extends('layouts.app')

@section('title', 'Edit Soal - ' . $game->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('teacher.games.edit', ['game' => $game->id, 'tab' => 'questions']) }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Game
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Edit Soal</h1>
        <p class="text-gray-600 mt-1">Edit pertanyaan untuk game "{{ $game->title }}"</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('teacher.games.questions.update', [$game, $question]) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="questionForm()">
            @csrf
            @method('PUT')

            <!-- Question Text -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                <textarea name="question_text" rows="3" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" placeholder="Tulis pertanyaan disini..." required>{{ old('question_text', $question->question_text) }}</textarea>
                @error('question_text') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar (Opsional)</label>
                @if($question->image)
                    <div class="mb-2 relative inline-block">
                        <img src="{{ asset('storage/' . $question->image) }}" class="h-32 object-cover rounded-lg">
                        <div class="flex items-center gap-2 mt-2">
                            <input type="checkbox" name="remove_image" id="remove_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <label for="remove_image" class="text-sm text-red-600 font-medium cursor-pointer">Hapus Gambar</label>
                        </div>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Options & Correct Answer -->
            <div class="border-t pt-6">
                <label class="block text-sm font-medium text-gray-900 mb-4">Pilihan Jawaban</label>
                <p class="text-xs text-gray-500 mb-3">Pilih radio button untuk menandai jawaban yang benar</p>
                
                <input type="hidden" name="correct_answer" x-model="getCorrectAnswer()">
                
                <div class="space-y-3">
                    <template x-for="(option, index) in options" :key="index">
                        <div class="flex items-center gap-3">
                            <input type="radio" :name="'correct_index'" :value="index" x-model="correctIndex" class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer" required title="Pilih sebagai jawaban benar">
                            <input type="text" :name="'options[]'" x-model="option.value" class="flex-1 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" :placeholder="'Pilihan ' + (index + 1)" required>
                            <button type="button" @click="removeOption(index)" class="text-gray-400 hover:text-red-500" x-show="options.length > 2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="addOption()" class="mt-3 text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Pilihan Lain
                </button>
                @error('options') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                @error('correct_answer') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Points -->
            <div class="border-t pt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Poin Nilai</label>
                <input type="number" name="points" value="{{ old('points', $question->points) }}" min="1" class="w-24 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" required>
                <p class="text-xs text-gray-500 mt-1">Nilai yang didapat siswa jika menjawab benar.</p>
            </div>

            <div class="pt-6 border-t flex justify-end">
                <button type="submit" class="bg-primary-600 text-white px-8 py-3 rounded-xl hover:bg-primary-700 transition shadow-lg shadow-primary-500/30 font-bold">
                    Update Soal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function questionForm() {
        const correctAnswer = '{{ $question->correct_answer }}';
        const initialOptions = @json(array_map(fn($opt) => ['value' => $opt], $question->options));
        
        return {
            correctIndex: initialOptions.findIndex(opt => opt.value === correctAnswer) || 0,
            options: initialOptions,
            addOption() {
                this.options.push({ value: '' });
            },
            removeOption(index) {
                if (this.correctIndex === index) {
                    this.correctIndex = 0;
                } else if (this.correctIndex > index) {
                    this.correctIndex--;
                }
                this.options.splice(index, 1);
            },
            getCorrectAnswer() {
                return this.options[this.correctIndex]?.value || '';
            }
        }
    }
</script>
@endsection
