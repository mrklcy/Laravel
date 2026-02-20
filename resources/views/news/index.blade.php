@extends('layouts.app')

@section('title', 'News & Events - CLSU ADSO')

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
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <!-- ========== NEWS SECTION ========== -->
    <div class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-green-cobra mb-2">Latest News</h2>
                <p class="text-gray-600">Browse through our latest announcements and updates</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($news as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="group">
                    <article class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border-2 border-gray-100 hover:border-clsu-green h-full flex flex-col transform hover:-translate-y-2">
                        <!-- Header Section -->
                        <div class="bg-gradient-to-r from-clsu-green to-green-cobra px-6 py-5 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-bl-full"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-3 py-1 bg-clsu-yellow text-green-cobra text-xs font-bold rounded-full">{{ $item->office->acronym ?? 'ADSO' }}</span>
                                    <span class="text-white/80 text-xs font-medium">{{ $item->published_at->format('M d, Y') }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-white line-clamp-2 group-hover:text-clsu-yellow transition-colors">{{ $item->title }}</h3>
                            </div>
                        </div>
                        
                        <!-- Content Section -->
                        <div class="p-6 flex-grow flex flex-col">
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-4 mb-6 flex-grow">{{ $item->excerpt }}</p>
                            <div class="flex items-center text-clsu-green font-semibold text-sm group-hover:underline">
                                Read More
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Bottom Accent -->
                        <div class="h-1 bg-gradient-to-r from-clsu-green via-green-cobra to-clsu-green"></div>
                    </article>
                </a>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center border-2 border-gray-100">
                        <div class="w-20 h-20 bg-clsu-green/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-clsu-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-cobra mb-2">No News Available</h3>
                        <p class="text-gray-600">News and updates will be posted here soon. Please check back later.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- News Pagination -->
        @if($news->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="bg-white rounded-xl shadow-md p-4">
                {{ $news->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- ========== EVENTS SECTION ========== -->
    <div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-green-cobra mb-2">Upcoming Events</h2>
                <p class="text-gray-600">Stay updated with campus activities and important dates</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <article class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border-2 border-gray-100 hover:border-clsu-gold h-full flex flex-col transform hover:-translate-y-2 group">
                    <!-- Event Image / Date Header -->
                    @if($event->image)
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            @if($event->event_date)
                                <div class="absolute top-4 left-4 bg-white rounded-xl shadow-lg px-3 py-2 text-center">
                                    <div class="text-2xl font-bold text-clsu-green leading-none">{{ $event->event_date->format('d') }}</div>
                                    <div class="text-xs font-semibold text-gray-500 uppercase">{{ $event->event_date->format('M') }}</div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-gradient-to-br from-clsu-gold to-clsu-yellow px-6 py-6 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-bl-full"></div>
                            @if($event->event_date)
                                <div class="relative z-10 flex items-center gap-3">
                                    <div class="bg-white rounded-xl shadow px-3 py-2 text-center">
                                        <div class="text-2xl font-bold text-clsu-green leading-none">{{ $event->event_date->format('d') }}</div>
                                        <div class="text-xs font-semibold text-gray-500 uppercase">{{ $event->event_date->format('M Y') }}</div>
                                    </div>
                                    <div>
                                        <div class="text-white/80 text-sm font-medium">
                                            {{ $event->event_date->format('l') }}
                                            @if($event->event_end_date && $event->event_end_date->format('Y-m-d') !== $event->event_date->format('Y-m-d'))
                                                — {{ $event->event_end_date->format('M d') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="relative z-10">
                                    <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-lg font-bold text-green-cobra mb-2 line-clamp-2 group-hover:text-clsu-green transition-colors">{{ $event->title }}</h3>

                        @if($event->location)
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $event->location }}
                            </div>
                        @endif

                        @if($event->description)
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 flex-grow">{{ $event->description }}</p>
                        @endif
                    </div>

                    <!-- Bottom Accent -->
                    <div class="h-1 bg-gradient-to-r from-clsu-gold via-clsu-yellow to-clsu-gold"></div>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center border-2 border-gray-100">
                        <div class="w-20 h-20 bg-clsu-gold/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-clsu-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-cobra mb-2">No Upcoming Events</h3>
                        <p class="text-gray-600">Events and activities will be posted here soon. Please check back later.</p>
                    </div>
                </div>
            @endforelse
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
