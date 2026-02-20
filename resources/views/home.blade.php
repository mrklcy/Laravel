<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CLSU Offices - Central Luzon State University</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'clsu-green': '#009639',
                            'clsu-yellow': '#FFD700',
                            'green-cobra': '#1E6031',
                            'clsu-gold': '#E0A70D',
                        }
                    }
                }
            }
        </script>
    @endif
    
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-clsu-green shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">CLSU Offices</h1>
                    <p class="text-sm text-clsu-yellow mt-1">Central Luzon State University</p>
                </div>
                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-white border-2 border-white rounded-md hover:bg-white hover:text-clsu-green transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-white hover:text-clsu-yellow transition-colors">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-clsu-green bg-clsu-yellow rounded-md hover:bg-clsu-gold transition-colors">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Carousel -->
    <div class="relative w-full overflow-hidden" id="heroCarousel" style="height: 480px;">
        <!-- Slides -->
        <div class="flex transition-transform duration-700 ease-in-out h-full" id="carouselTrack">
            <div class="w-full flex-shrink-0 relative">
                <img src="{{ asset('images/slider/slider_1.png') }}" alt="CLSU Campus" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="text-3xl md:text-5xl font-bold text-white mb-3 drop-shadow-lg">Welcome to CLSU Offices</h2>
                        <p class="text-lg md:text-xl text-gray-200 max-w-2xl">Explore the various offices and departments of Central Luzon State University</p>
                    </div>
                </div>
            </div>
            <div class="w-full flex-shrink-0 relative">
                <img src="{{ asset('images/slider/slider_2.jpg') }}" alt="CLSU Campus" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="text-3xl md:text-5xl font-bold text-white mb-3 drop-shadow-lg">Central Luzon State University</h2>
                        <p class="text-lg md:text-xl text-gray-200 max-w-2xl">Administrative and Support Offices serving the CLSU community</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prev/Next Arrows -->
        <button onclick="moveCarousel(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all" aria-label="Previous">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button onclick="moveCarousel(1)" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all" aria-label="Next">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2" id="carouselDots">
            <button onclick="goToSlide(0)" class="w-3 h-3 rounded-full bg-white transition-all" aria-label="Slide 1"></button>
            <button onclick="goToSlide(1)" class="w-3 h-3 rounded-full bg-white/50 transition-all" aria-label="Slide 2"></button>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Offices Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($offices as $office)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-clsu-green">
                    <!-- Office Header -->
                    <div class="bg-gradient-to-r from-clsu-green to-green-cobra px-6 py-4">
                        <h3 class="text-xl font-bold text-white">{{ $office->name }}</h3>
                        @if($office->acronym)
                            <p class="text-clsu-yellow text-sm mt-1 font-medium">{{ $office->acronym }}</p>
                        @endif
                    </div>
                    
                    <!-- Office Content -->
                    <div class="p-6">
                        @if($office->overview)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $office->overview }}</p>
                        @endif
                        
                        <!-- Sub-offices -->
                        @if($office->children->count() > 0)
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Sub-offices:</h4>
                                <ul class="space-y-2">
                                    @foreach($office->children as $child)
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900">{{ $child->name }}</span>
                                                @if($child->acronym)
                                                    <span class="text-xs text-clsu-gold ml-2 font-medium">({{ $child->acronym }})</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No offices found</h3>
                        <p class="mt-1 text-sm text-gray-500">There are no offices available at this time.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-green-cobra mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-white">
                &copy; {{ date('Y') }} Central Luzon State University. All rights reserved.
            </p>
        </div>
    </footer>
<script>
    const track = document.getElementById('carouselTrack');
    const dots = document.getElementById('carouselDots').children;
    const totalSlides = 2;
    let currentSlide = 0;
    let autoPlay;

    function goToSlide(index) {
        currentSlide = index;
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
        Array.from(dots).forEach((dot, i) => {
            dot.className = i === currentSlide
                ? 'w-3 h-3 rounded-full bg-white transition-all scale-125'
                : 'w-3 h-3 rounded-full bg-white/50 transition-all';
        });
    }

    function moveCarousel(direction) {
        let next = currentSlide + direction;
        if (next < 0) next = totalSlides - 1;
        if (next >= totalSlides) next = 0;
        goToSlide(next);
        resetAutoPlay();
    }

    function resetAutoPlay() {
        clearInterval(autoPlay);
        autoPlay = setInterval(() => moveCarousel(1), 5000);
    }

    // Auto-play
    autoPlay = setInterval(() => moveCarousel(1), 5000);

    // Pause on hover
    document.getElementById('heroCarousel').addEventListener('mouseenter', () => clearInterval(autoPlay));
    document.getElementById('heroCarousel').addEventListener('mouseleave', resetAutoPlay);
</script>
</body>
</html>
