<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Bimbel Pados Ilmu</title>
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="@yield('description', 'Platform monitoring akademik yang menggabungkan manajemen sekolah dengan Game Edukasi Interaktif. Pantau perkembangan anak sambil bermain!')">
    <meta name="keywords" content="@yield('keywords', 'bimbel, game edukasi, monitoring akademik, platform pendidikan, game based learning, kurikulum merdeka, bimbel online')">
    <meta name="author" content="Bimbel Pados Ilmu">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    
    {{-- Open Graph Meta Tags for Social Media --}}
    <meta property="og:title" content="@yield('og_title', (trim(View::yieldContent('title')) ?: 'Dashboard') . ' - Bimbel Pados Ilmu')">
    <meta property="og:description" content="@yield('og_description', 'Platform monitoring akademik yang menggabungkan manajemen sekolah dengan Game Edukasi Interaktif. Pantau perkembangan anak sambil bermain!')">
    <meta property="og:image" content="@yield('og_image', asset('storage/logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Bimbel Pados Ilmu">
    
    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', (trim(View::yieldContent('title')) ?: 'Dashboard') . ' - Bimbel Pados Ilmu')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Platform monitoring akademik yang menggabungkan manajemen sekolah dengan Game Edukasi Interaktif.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('storage/logo.png'))">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        secondary: {
                            50: '#f0fdf4',
                            500: '#22c55e',
                            600: '#16a34a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    @unless(request()->routeIs('login') || request()->routeIs('register'))
    <nav class="glass sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center gap-3">
                        <img src="{{ asset('storage/logo.png') }}" alt="Bimbel Pados Ilmu" class="h-10 w-10 object-contain">
                        <div class="flex flex-col">
                            <span class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-indigo-600">
                                Bimbel Pados Ilmu
                            </span>
                            <span class="text-xs text-gray-500">Monitoring & Game Edukasi</span>
                        </div>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    @auth('teacher')
                        <span class="text-sm text-gray-600">Halo, {{ Auth::guard('teacher')->user()->name }} (Guru)</span>
                         <form action="{{ route('teacher.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition">Logout</button>
                        </form>
                    @endauth
                    
                    @auth('parent')
                        <span class="text-sm text-gray-600">Halo, {{ Auth::guard('parent')->user()->name }} (Ortu)</span>
                        <form action="{{ route('parent.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition">Logout</button>
                        </form>
                    @endauth

                    @unless(Auth::guard('teacher')->check() || Auth::guard('parent')->check() || request()->routeIs('landing'))
                        <a href="{{ route('landing') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">Home</a>
                    @endunless
                </div>
            </div>
        </div>
    </nav>
    @endunless

    <!-- Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Bimbel Pados Ilmu. Platform Monitoring & Game Edukasi.
            </p>
        </div>
    </footer>

</body>
</html>
