@extends('layouts.app')

@section('title', $news->title . ' - CLSU ADSO')

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

    <!-- Content Overlay -->
    <div class="absolute inset-0 flex items-center z-10 pointer-events-none">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-4 pointer-events-auto">
                <a href="{{ route('news.index') }}" class="text-clsu-yellow hover:text-white text-sm">← Back to News</a>
            </div>
            <p class="text-clsu-yellow text-sm mb-2">{{ $news->office->acronym ?? 'ADSO' }}</p>
            <h1 class="text-4xl font-bold mb-4 text-white drop-shadow-lg">{{ $news->title }}</h1>
            <div class="flex items-center text-sm text-white drop-shadow-md">
                <span>{{ $news->published_at->format('F d, Y') }}</span>
                @if($news->author)
                    <span class="mx-2">•</span>
                    <span>By {{ $news->author }}</span>
                @endif
                <span class="mx-2">•</span>
                <span>{{ $news->views }} views</span>
            </div>
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

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="prose max-w-none">
            <p class="text-xl text-gray-700 mb-6 font-medium">{{ $news->excerpt }}</p>
            <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $news->content }}</div>
        </div>
    </div>

    @if($recentNews->count() > 0)
    <div>
        <h2 class="text-2xl font-bold text-green-cobra mb-6">Recent News</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($recentNews as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="group">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all border border-gray-200 hover:border-clsu-green">
                        <div class="bg-gradient-to-br from-clsu-green to-green-cobra px-6 py-4">
                            <h3 class="text-lg font-bold text-white line-clamp-2 group-hover:text-clsu-yellow transition-colors">{{ $item->title }}</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $item->excerpt }}</p>
                            <span class="text-clsu-green text-sm group-hover:underline">Read More →</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
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
