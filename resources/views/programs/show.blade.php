@extends('layouts.app')

@section('title', $program->name . ' - CLSU ADSO')

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
                <a href="{{ route('programs.index') }}" class="text-clsu-yellow hover:text-white text-sm">← Back to Programs</a>
            </div>
            @if($program->office)
                <p class="text-clsu-yellow text-sm mb-2">{{ $program->office->acronym }}</p>
            @endif
            <h1 class="text-4xl font-bold mb-4 text-white drop-shadow-lg">{{ $program->name }}</h1>
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
        <h2 class="text-2xl font-bold text-green-cobra mb-4">Description</h2>
        <p class="text-gray-700 leading-relaxed mb-6">{{ $program->description }}</p>
        
        @if($program->details)
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Program Details</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $program->details }}</p>
            </div>
        @endif

        @if($program->benefits)
            <div class="mb-6 bg-clsu-gold/10 p-6 rounded-lg border-l-4 border-clsu-gold">
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Benefits</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $program->benefits }}</p>
            </div>
        @endif

        @if($program->eligibility)
            <div class="mb-6 bg-gray-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Eligibility</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $program->eligibility }}</p>
            </div>
        @endif

        @if($program->contact_person || $program->contact_email || $program->contact_phone)
            <div class="bg-gradient-to-r from-clsu-green to-green-cobra rounded-lg p-6 text-white">
                <h3 class="text-xl font-bold mb-4">Contact Information</h3>
                <div class="space-y-2">
                    @if($program->contact_person)
                        <p><span class="font-semibold text-clsu-yellow">Contact Person:</span> {{ $program->contact_person }}</p>
                    @endif
                    @if($program->contact_email)
                        <p><span class="font-semibold text-clsu-yellow">Email:</span> {{ $program->contact_email }}</p>
                    @endif
                    @if($program->contact_phone)
                        <p><span class="font-semibold text-clsu-yellow">Phone:</span> {{ $program->contact_phone }}</p>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @if($relatedPrograms->count() > 0)
    <div>
        <h2 class="text-2xl font-bold text-green-cobra mb-6">Related Programs</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($relatedPrograms as $related)
                <a href="{{ route('programs.show', $related->slug) }}" class="group">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all border border-gray-200 hover:border-clsu-green">
                        <div class="bg-gradient-to-br from-clsu-gold to-clsu-yellow px-6 py-4">
                            <h3 class="text-lg font-bold text-green-cobra">{{ $related->name }}</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $related->description }}</p>
                            <span class="text-clsu-green text-sm group-hover:underline">Learn More →</span>
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
