@extends('layouts.app')
<!-- MARKER: ADSO_INDEX -->

@section('title', 'Administrative Services Office - CLSU')

@section('content')
<!-- Hero Carousel -->
<div class="relative w-full h-[70vh] min-h-[600px] overflow-hidden" id="heroCarousel">
    <!-- Slides -->
    <div class="flex h-full transition-transform duration-700 ease-in-out" id="carouselTrack">
        @if($sliders->count() > 0)
            @foreach($sliders as $slide)
            <div class="w-full flex-shrink-0 relative">
                <img src="{{ asset($slide->image) }}" alt="{{ $slide->title ?? 'CLSU Campus' }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/40"></div>
            </div>
            @endforeach
        @else
            <div class="w-full flex-shrink-0 relative">
                <img src="{{ asset('images/slider/slider_1.png') }}" alt="CLSU Campus" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/40"></div>
            </div>
            <div class="w-full flex-shrink-0 relative">
                <img src="{{ asset('images/slider/slider_2.jpg') }}" alt="CLSU Campus" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/40"></div>
            </div>
        @endif
    </div>

    <!-- Prev/Next Arrows -->
    <button onclick="moveCarousel(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all z-10" aria-label="Previous">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button onclick="moveCarousel(1)" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all z-10" aria-label="Next">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    <!-- Dots -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 z-10" id="carouselDots">
        @php $slideCount = $sliders->count() > 0 ? $sliders->count() : 2; @endphp
        @for($i = 0; $i < $slideCount; $i++)
            <button onclick="goToSlide({{ $i }})" class="w-3 h-3 rounded-full {{ $i === 0 ? 'bg-white' : 'bg-white/50' }} transition-all" aria-label="Slide {{ $i + 1 }}"></button>
        @endfor
    </div>
</div>

<!-- Quick Access Section -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('services.index') }}" class="group flex flex-col items-center p-6 rounded-xl bg-gradient-to-br from-clsu-green/10 to-green-cobra/10 hover:from-clsu-green/20 hover:to-green-cobra/20 transition-all duration-300 border-2 border-transparent hover:border-clsu-green">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-center">Services</h3>
                <p class="text-xs text-gray-600 text-center mt-1">View All</p>
            </a>
            <a href="{{ route('programs.index') }}" class="group flex flex-col items-center p-6 rounded-xl bg-gradient-to-br from-clsu-gold/10 to-clsu-yellow/10 hover:from-clsu-gold/20 hover:to-clsu-yellow/20 transition-all duration-300 border-2 border-transparent hover:border-clsu-gold">
                <div class="w-16 h-16 bg-clsu-gold rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-center">Programs</h3>
                <p class="text-xs text-gray-600 text-center mt-1">View All</p>
            </a>
            <a href="{{ route('news.index') }}" class="group flex flex-col items-center p-6 rounded-xl bg-gradient-to-br from-green-cobra/10 to-clsu-green/10 hover:from-green-cobra/20 hover:to-clsu-green/20 transition-all duration-300 border-2 border-transparent hover:border-green-cobra">
                <div class="w-16 h-16 bg-green-cobra rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-center">News</h3>
                <p class="text-xs text-gray-600 text-center mt-1">View All</p>
            </a>
            <a href="{{ route('inquiries.create') }}" class="group flex flex-col items-center p-6 rounded-xl bg-gradient-to-br from-clsu-yellow/10 to-clsu-gold/10 hover:from-clsu-yellow/20 hover:to-clsu-gold/20 transition-all duration-300 border-2 border-transparent hover:border-clsu-yellow">
                <div class="w-16 h-16 bg-clsu-yellow rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-green-cobra" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-center">Contact</h3>
                <p class="text-xs text-gray-600 text-center mt-1">Get in Touch</p>
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Mission/Vision Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
        <div class="relative overflow-hidden bg-gradient-to-br from-clsu-green to-green-cobra rounded-2xl shadow-xl p-8 text-white">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold mb-4">Our Mission</h2>
                <p class="text-lg text-white/90 leading-relaxed">
                    To provide responsive, relevant organizational support and implementable welfare programs 
                    for all employees of Central Luzon State University, ensuring efficient administrative 
                    services that support the university's goals and objectives.
                </p>
            </div>
        </div>
        <div class="relative overflow-hidden bg-gradient-to-br from-clsu-gold to-clsu-yellow rounded-2xl shadow-xl p-8 text-green-cobra">
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/20 rounded-full -ml-16 -mb-16"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/30 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-cobra" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold mb-4">Our Vision</h2>
                <p class="text-lg text-green-cobra/90 leading-relaxed">
                    To be a leading administrative services office that adapts to emerging demands and trends, 
                    providing comprehensive support services that enhance the welfare and productivity of all 
                    university employees.
                </p>
            </div>
        </div>
    </div>

    <!-- Latest News Section -->
    @if($latestNews->count() > 0)
    <div class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-4xl font-bold text-green-cobra mb-2">Latest News & Updates</h2>
                <p class="text-gray-600">Stay informed with the latest announcements from ADSO</p>
            </div>
            <a href="{{ route('news.index') }}" class="hidden md:flex items-center px-6 py-3 bg-clsu-green text-white font-semibold rounded-lg hover:bg-green-cobra transition-colors">
                View All News
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestNews as $news)
                <a href="{{ route('news.show', $news->slug) }}" class="group">
                    <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-200 hover:border-clsu-green h-full flex flex-col">
                        <div class="bg-gradient-to-r from-clsu-green to-green-cobra px-6 py-5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-3 py-1 bg-clsu-yellow text-green-cobra text-xs font-bold rounded-full">{{ $news->office->acronym ?? 'ADSO' }}</span>
                                <span class="text-white/80 text-xs">{{ $news->published_at->format('M d') }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-white line-clamp-2 group-hover:text-clsu-yellow transition-colors">{{ $news->title }}</h3>
                        </div>
                        <div class="p-6 flex-grow flex flex-col">
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">{{ $news->excerpt }}</p>
                            <div class="flex items-center text-clsu-green font-medium text-sm group-hover:underline">
                                Read More
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>
        <div class="mt-6 md:hidden text-center">
            <a href="{{ route('news.index') }}" class="inline-flex items-center px-6 py-3 bg-clsu-green text-white font-semibold rounded-lg hover:bg-green-cobra transition-colors">
                View All News
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
    @endif

    <!-- Featured Services Section -->
    @if($featuredServices->count() > 0)
    <div class="mb-16">
        <div class="text-center mb-12">
            <div class="inline-block mb-4">
                <span class="px-4 py-2 bg-clsu-green/10 text-clsu-green font-semibold rounded-full text-sm">Our Services</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-green-cobra mb-4">Comprehensive Administrative Services</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Providing efficient and responsive support for all CLSU employees</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredServices as $index => $service)
                <a href="{{ route('services.show', $service->slug) }}" class="group">
                    <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border-2 border-gray-100 hover:border-clsu-green h-full flex flex-col transform hover:-translate-y-2">
                        <!-- Icon Badge -->
                        <div class="absolute top-6 right-6 z-10">
                            <div class="w-14 h-14 bg-clsu-green rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-transform">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-8 flex-grow flex flex-col">
                            @if($service->office)
                                <span class="inline-block px-3 py-1 bg-clsu-green/10 text-clsu-green text-xs font-bold rounded-full mb-4 w-fit">{{ $service->office->acronym }}</span>
                            @endif
                            <h3 class="text-2xl font-bold text-green-cobra mb-4 group-hover:text-clsu-green transition-colors">{{ $service->name }}</h3>
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-4 mb-6 flex-grow">{{ $service->description }}</p>
                            <div class="flex items-center text-clsu-green font-semibold text-sm group-hover:underline">
                                Explore Service
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Bottom Accent -->
                        <div class="h-1 bg-gradient-to-r from-clsu-green via-green-cobra to-clsu-green"></div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-12 text-center">
            <a href="{{ route('services.index') }}" class="inline-flex items-center px-8 py-4 bg-clsu-green text-white font-bold rounded-xl hover:bg-green-cobra transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                View All Services
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
    @endif

    <!-- Active Programs Section -->
    @if($activePrograms->count() > 0)
    <div class="mb-16 bg-gradient-to-br from-clsu-gold/5 via-clsu-yellow/5 to-clsu-gold/5 rounded-3xl p-8 md:p-12">
        <div class="text-center mb-12">
            <div class="inline-block mb-4">
                <span class="px-4 py-2 bg-clsu-gold/20 text-green-cobra font-semibold rounded-full text-sm">Active Programs</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-green-cobra mb-4">Employee Welfare & Development</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Enhancing the well-being and growth of all CLSU employees</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($activePrograms as $program)
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
            @endforeach
        </div>
        <div class="mt-12 text-center">
            <a href="{{ route('programs.index') }}" class="inline-flex items-center px-8 py-4 bg-clsu-gold text-green-cobra font-bold rounded-xl hover:bg-clsu-yellow transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                View All Programs
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
    @endif

    <!-- Sub-Offices Section -->
    <div class="mb-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-green-cobra mb-3">Our Offices</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Explore the different offices under the Administrative Services Office</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($adso->children as $subOffice)
                <a href="{{ route('office.show', $subOffice->code) }}" class="group">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-200 hover:border-clsu-green h-full flex flex-col">
                        <div class="bg-gradient-to-br from-clsu-green to-green-cobra px-6 py-10 text-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
                            <div class="relative z-10">
                                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-white/30 transition-all duration-300">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-white mb-2">{{ $subOffice->name }}</h3>
                                @if($subOffice->acronym)
                                    <p class="text-clsu-yellow text-sm font-medium">{{ $subOffice->acronym }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="p-6 flex-grow flex flex-col">
                            @if($subOffice->overview)
                                <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow">{{ $subOffice->overview }}</p>
                            @endif
                            <div class="flex items-center text-clsu-green font-medium text-sm group-hover:underline">
                                Learn More
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Contact Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-clsu-green via-green-cobra to-clsu-green rounded-2xl shadow-2xl p-8 md:p-12 text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>
        <div class="relative z-10 max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold mb-4">Get in Touch</h2>
                <p class="text-xl text-white/90">
                    For inquiries or assistance, please contact the Administrative Services Office
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-clsu-yellow rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-cobra" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg">Location</h3>
                    </div>
                    <p class="text-white/90">Central Luzon State University<br>Science City of Muñoz, Nueva Ecija</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-clsu-yellow rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-cobra" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg">Contact</h3>
                    </div>
                    <p class="text-white/90">
                        <span class="font-semibold text-clsu-yellow">Director:</span> Dr. Cheryl G. Ramos<br>
                        Email: <a href="mailto:cgramos@clsu.edu.ph" class="text-clsu-yellow hover:text-white underline">cgramos@clsu.edu.ph</a><br>
                        Phone: <a href="tel:+63444560107" class="text-clsu-yellow hover:text-white underline">(044) 456-0107</a>
                    </p>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('inquiries.create') }}" class="inline-block px-8 py-4 bg-clsu-yellow text-green-cobra font-bold rounded-lg hover:bg-clsu-gold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    Submit an Inquiry
                </a>
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
                ? 'w-3 h-3 rounded-full bg-white transition-all scale-125'
                : 'w-3 h-3 rounded-full bg-white/50 transition-all';
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
