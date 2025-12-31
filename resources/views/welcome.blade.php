@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="relative min-h-screen bg-[#F8FAFC] overflow-hidden selection:bg-primary-500 selection:text-white">

    <!-- Ambient Background Effects -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-primary-400/20 rounded-full blur-[120px] mix-blend-multiply animate-blob"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-secondary-400/20 rounded-full blur-[120px] mix-blend-multiply animate-blob animation-delay-2000"></div>
        <div class="absolute top-[20%] left-[20%] w-[400px] h-[400px] bg-purple-400/20 rounded-full blur-[120px] mix-blend-multiply animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-center min-h-[calc(100vh-80px)]">
        
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Column: Content -->
            <div class="text-center lg:text-left space-y-8 animate-fade-in-up">
                
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/50 backdrop-blur-md border border-white/60 shadow-sm">
                    <span class="flex h-2 w-2 rounded-full bg-secondary-500"></span>
                    <span class="text-sm font-medium text-slate-600">Terpercaya oleh 500+ Sekolah</span>
                </div>

                <h1 class="font-display text-5xl sm:text-7xl font-bold tracking-tight text-slate-900 leading-[1.1]">
                    Belajar Jadi <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600 relative inline-block">
                        Petualangan 🚀
                        <!-- Decorative Underline -->
                        <svg class="absolute w-full h-3 -bottom-2 left-0 text-primary-300 opacity-60" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" />
                        </svg>
                    </span>
                </h1>
                
                <p class="text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Platform monitoring akademik yang menggabungkan manajemen sekolah dengan <strong class="text-slate-900">Game Edukasi Interaktif</strong>. Pantau perkembangan anak sambil bermain!
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('parent.login') }}" class="group relative w-full sm:w-auto px-8 py-4 bg-gradient-to-br from-secondary-500 to-secondary-600 text-white rounded-2xl font-bold text-lg shadow-lg hover:shadow-secondary-500/30 transition-all transform hover:-translate-y-1 hover:scale-105 overflow-hidden">
                        <div class="absolute inset-0 w-full h-full bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        <span class="relative flex items-center justify-center gap-2">
                            Masuk Orang Tua 👨‍👩‍👧‍👦
                        </span>
                    </a>
                    
                    <a href="{{ route('teacher.login') }}" class="group w-full sm:w-auto px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold text-lg shadow-sm hover:shadow-md hover:border-primary-200 transition-all transform hover:-translate-y-1">
                        <span class="flex items-center justify-center gap-2 group-hover:text-primary-600 transition-colors">
                            Masuk Guru 👨‍🏫
                        </span>
                    </a>
                </div>

                <div class="pt-8 flex items-center justify-center lg:justify-start gap-8 text-slate-400">
                    <!-- Tech Logos / Badges Placeholder -->
                    <div class="flex items-center gap-2 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition duration-500">
                        <div class="h-8 w-8 bg-slate-200 rounded-lg"></div>
                        <span class="text-sm font-semibold">Kurikulum Merdeka</span>
                    </div>
                     <div class="flex items-center gap-2 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition duration-500">
                        <div class="h-8 w-8 bg-slate-200 rounded-lg"></div>
                        <span class="text-sm font-semibold">Game Based Learning</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Hero Image -->
            <div class="relative lg:h-[600px] flex items-center justify-center animate-float">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary-200/40 to-secondary-200/40 rounded-full blur-[80px] transform scale-75"></div>
                 <!-- Glass Card Behind -->
                <div class="absolute -right-8 top-20 w-64 h-40 bg-white/40 backdrop-blur-xl border border-white/50 rounded-2xl shadow-xl z-20 animate-float-delayed hidden lg:block p-4">
                     <div class="flex items-center gap-3 mb-3">
                         <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-xl">🏆</div>
                         <div>
                             <p class="text-xs text-gray-500 font-bold">Top Player</p>
                             <p class="text-sm font-bold text-gray-800">Budi Santoso</p>
                         </div>
                     </div>
                     <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                         <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                     </div>
                     <p class="text-right text-xs font-bold text-green-600">+150 Poin</p>
                </div>

                <img src="{{ asset('storage/hero_education_3d_1767202083141.png') }}" alt="Children Learning" class="relative z-10 w-full max-w-lg lg:max-w-xl object-contain drop-shadow-2xl hover:scale-105 transition duration-700 ease-out rounded-3xl">
            </div>

        </div>

        <!-- Admin Login Link -->
        <!-- <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-center">
             <a href="/admin" class="text-xs font-semibold text-slate-400 hover:text-primary-600 transition flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Area Administrator
            </a>
        </div> -->

    </div>
</div>

<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    .animate-float-delayed {
        animation: float 5s ease-in-out infinite 1s;
    }

    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out forwards;
    }
</style>
@endsection
