@extends('layouts.app')

@section('title', 'Programs - CLSU ADSO')

@section('content')
<!-- Hero Carousel -->
<div class="relative w-full h-[60vh] min-h-[500px] overflow-hidden" id="heroCarousel">
    <!-- Slides -->
    <div class="flex h-full transition-transform duration-700 ease-in-out" id="carouselTrack">
        <div class="w-full flex-shrink-0 relative">
            <img src="{{ asset('images/slider/slider_1.png') }}" alt="CLSU Campus" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>
        </div>
        <div class="w-full flex-shrink-0 relative">
            <img src="{{ asset('images/slider/slider_2.jpg') }}" alt="CLSU Campus" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>
        </div>
    </div>

    <!-- Prev/Next Arrows -->
    <button onclick="moveCarousel(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-black/30 hover:bg-black/50 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all transform hover:scale-110" aria-label="Previous">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button onclick="moveCarousel(1)" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-black/30 hover:bg-black/50 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all transform hover:scale-110" aria-label="Next">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    <!-- Dots -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-20" id="carouselDots">
        <button onclick="goToSlide(0)" class="w-3 h-3 rounded-full bg-white transition-all scale-125 shadow-lg" aria-label="Slide 1"></button>
        <button onclick="goToSlide(1)" class="w-3 h-3 rounded-full bg-white/50 transition-all shadow-lg" aria-label="Slide 2"></button>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gradient-to-br from-clsu-gold/5 via-clsu-yellow/5 to-clsu-gold/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-green-cobra mb-2">All Programs</h2>
                    <p class="text-gray-600">Discover programs designed to support and develop our employees</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($programs as $program)
                    <a href="{{ route('programs.show', $program->slug) }}" class="group">
                        <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border-2 border-gray-100 hover:border-clsu-gold h-full flex flex-col transform hover:-translate-y-2">
                            <!-- Decorative Background -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-clsu-gold/20 to-clsu-yellow/20 rounded-bl-full"></div>
                            
                            <!-- Content -->
                            <div class="relative p-8 flex-grow flex flex-col">
                                <div class="flex items-start justify-between mb-4">
                                    @if($program->office)
                                        <span class="px-4 py-2 bg-clsu-gold text-green-cobra text-xs font-bold rounded-full">{{ $program->office->acronym }}</span>
                                    @endif
                                    <div class="w-12 h-12 bg-clsu-gold/10 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-transform">
                                        <svg class="w-6 h-6 text-clsu-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-2xl font-bold text-green-cobra mb-4 group-hover:text-clsu-gold transition-colors">{{ $program->name }}</h3>
                                <p class="text-gray-600 text-sm leading-relaxed line-clamp-4 mb-6 flex-grow">{{ $program->description }}</p>
                                <div class="flex items-center text-clsu-gold font-semibold text-sm group-hover:underline">
                                    Discover Program
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Bottom Accent -->
                            <div class="h-1 bg-gradient-to-r from-clsu-gold via-clsu-yellow to-clsu-gold"></div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-lg p-12 text-center border-2 border-gray-100">
                            <div class="w-20 h-20 bg-clsu-gold/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-clsu-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-green-cobra mb-2">No Programs Available</h3>
                            <p class="text-gray-600">Programs will be posted here soon. Please check back later.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const track = document.getElementById('carouselTrack');
    const dots = document.getElementById('carouselDots').children;
    const totalSlides = 2;
    let currentSlide = 0;
    let autoPlay;

    function goToSlide(index) {
        currentSlide = index;
        track.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';
        Array.from(dots).forEach(function(dot, i) {
            dot.className = i === currentSlide
                ? 'w-3 h-3 rounded-full bg-white transition-all scale-125 shadow-lg'
                : 'w-3 h-3 rounded-full bg-white/50 transition-all shadow-lg';
        });
    }

    function moveCarousel(direction) {
        var next = currentSlide + direction;
        if (next < 0) next = totalSlides - 1;
        if (next >= totalSlides) next = 0;
        goToSlide(next);
        resetAutoPlay();
    }

    function resetAutoPlay() {
        clearInterval(autoPlay);
        autoPlay = setInterval(function() { moveCarousel(1); }, 5000);
    }

    autoPlay = setInterval(function() { moveCarousel(1); }, 5000);

    document.getElementById('heroCarousel').addEventListener('mouseenter', function() { clearInterval(autoPlay); });
    document.getElementById('heroCarousel').addEventListener('mouseleave', resetAutoPlay);
</script>
@endpush
