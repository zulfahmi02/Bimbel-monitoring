@extends('layouts.app')

@section('title', 'Bermain: ' . $game->title)

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col" x-data="gamePlayer()">
    <!-- Top Bar -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-secondary-100 rounded-full flex items-center justify-center text-xl">
                    {{ $student->gender == 'female' ? '👧' : '👦' }}
                </div>
                <div>
                    <h1 class="text-sm font-bold text-gray-900 leading-none">{{ $student->name }}</h1>
                    <p class="text-xs text-secondary-600 font-medium leading-none mt-1">Sedang Bermain...</p>
                </div>
            </div>
            
            <div class="text-center hidden md:block">
                <h2 class="font-bold text-gray-800">{{ $game->title }}</h2>
            </div>
            
            <div class="font-mono font-bold text-xl text-primary-600 bg-primary-50 px-3 py-1 rounded-lg">
                <span x-text="formatTime(timer)">00:00</span>
            </div>
        </div>
        <!-- Progress Bar -->
        <div class="h-1.5 w-full bg-gray-100">
            <div class="h-full bg-secondary-500 transition-all duration-500" :style="`width: ${(currentQuestionIndex + 1) / totalQuestions * 100}%`"></div>
        </div>
    </div>

    <!-- Game Area -->
    <div class="flex-grow flex items-center justify-center p-4">
        <div class="max-w-3xl w-full">
            
            <!-- Question Card -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden min-h-[500px] flex flex-col relative">
                
                <!-- Loading State -->
                <div x-show="loading" style="display: none;" class="absolute inset-0 bg-white z-20 flex items-center justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-secondary-600"></div>
                </div>

                <!-- Content -->
                <div class="p-8 flex-grow flex flex-col" x-show="!loading" x-transition>
                    
                    <div class="flex justify-between items-center mb-6 text-sm font-medium text-gray-400 uppercase tracking-widest">
                        <span>Soal <span x-text="currentQuestionIndex + 1"></span> dari <span x-text="totalQuestions"></span></span>
                        <span><span x-text="currentQuestion.points"></span> Poin</span>
                    </div>

                    <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 leading-relaxed" x-text="currentQuestion.question_text"></h3>

                    <template x-if="currentQuestion.image">
                        <div class="mb-8 rounded-xl overflow-hidden shadow-inner bg-gray-50 border border-gray-100">
                            <img :src="'/storage/' + currentQuestion.image" class="max-h-64 mx-auto object-contain">
                        </div>
                    </template>

                    <!-- Options Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-auto">
                        <template x-for="(option, index) in currentQuestion.options" :key="index">
                            <button 
                                @click="selectAnswer(option)"
                                :class="{'ring-4 ring-secondary-400 bg-secondary-50 border-secondary-500 text-secondary-900': responses[currentQuestion.id] === option, 'hover:border-secondary-300 hover:bg-gray-50 bg-white border-gray-200 text-gray-700': responses[currentQuestion.id] !== option}"
                                class="p-4 rounded-xl border-2 text-left transition-all duration-200 font-semibold text-lg flex items-center gap-3 group"
                            > 
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold bg-gray-100 group-hover:bg-white transition-colors border border-gray-200" x-text="String.fromCharCode(65 + index)"></span>
                                <span x-text="option"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Footer Navigation -->
                <div class="bg-gray-50 p-6 border-t border-gray-100 flex justify-between items-center">
                    <button 
                        @click="prevQuestion" 
                        :disabled="currentQuestionIndex === 0"
                        class="px-6 py-2 rounded-xl font-bold text-gray-500 hover:bg-gray-200 disabled:opacity-30 disabled:cursor-not-allowed transition"
                    >
                        &larr; Sebelumnya
                    </button>
                    
                    <button 
                        @click="nextQuestion" 
                        x-show="currentQuestionIndex < totalQuestions - 1"
                        class="bg-primary-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-primary-700 shadow-lg shadow-primary-500/30 transition transform hover:scale-105"
                    >
                        Selanjutnya &rarr;
                    </button>

                    <button 
                        @click="submitAnswers" 
                        x-show="currentQuestionIndex === totalQuestions - 1"
                        class="bg-secondary-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-secondary-700 shadow-lg shadow-secondary-500/30 transition transform hover:scale-105"
                    >
                        Selesai & Kumpulkan! 🎉
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function gamePlayer() {
        return {
            questions: @json($game->questions),
            currentQuestionIndex: 0,
            responses: {}, // Holds student answers { question_id: 'answer' }
            loading: false,
            timer: 0,
            timerInterval: null,
            isSubmitting: false,

            get currentQuestion() {
                return this.questions[this.currentQuestionIndex];
            },

            get totalQuestions() {
                return this.questions.length;
            },

            init() {
                this.startTimer();
                // Ensure options are parsed if they are strings (Laravel casts might return array but blade json directive is safe)
            },

            startTimer() {
                this.timerInterval = setInterval(() => {
                    this.timer++;
                }, 1000);
            },

            formatTime(seconds) {
                const m = Math.floor(seconds / 60).toString().padStart(2, '0');
                const s = (seconds % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            },

            selectAnswer(option) {
                this.responses[this.currentQuestion.id] = option;
            },

            nextQuestion() {
                if (this.currentQuestionIndex < this.totalQuestions - 1) {
                    this.currentQuestionIndex++;
                }
            },

            prevQuestion() {
                if (this.currentQuestionIndex > 0) {
                    this.currentQuestionIndex--;
                }
            },

            submitAnswers() {
                if(!confirm('Apakah kamu yakin sudah selesai mengerjakan semua soal?')) return;
                
                this.loading = true;
                clearInterval(this.timerInterval);

                fetch('{{ route("parent.games.answer", $session) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        answers: this.responses
                    })
                })
                .then(async response => {
                    const data = await response.json();
                    
                    if (!response.ok) {
                        throw new Error(data.message || 'Validation error');
                    }
                    
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message + '. Pastikan semua soal telah dijawab.');
                    this.loading = false;
                    this.startTimer(); // Resume timer if failed
                });
            }
        }
    }
</script>
@endsection
