@extends('layouts.app')

@section('title', 'Contact Us - CLSU ADSO')

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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <h1 class="text-4xl md:text-5xl font-bold mb-2 text-white drop-shadow-2xl">Contact Us</h1>
            <p class="text-lg md:text-xl text-clsu-yellow drop-shadow-lg">We're here to help. Send us your inquiry or feedback.</p>
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

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('inquiries.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-clsu-green focus:border-clsu-green"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-clsu-green focus:border-clsu-green"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="text" name="phone" id="phone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-clsu-green focus:border-clsu-green"
                        value="{{ old('phone') }}">
                </div>

                <div>
                    <label for="office_id" class="block text-sm font-medium text-gray-700 mb-2">Office (Optional)</label>
                    <select name="office_id" id="office_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-clsu-green focus:border-clsu-green">
                        <option value="">Select an office</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" {{ old('office_id') == $office->id || $officeId == $office->id ? 'selected' : '' }}>
                                {{ $office->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label for="inquiry_type" class="block text-sm font-medium text-gray-700 mb-2">Inquiry Type</label>
                <select name="inquiry_type" id="inquiry_type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-clsu-green focus:border-clsu-green">
                    <option value="general" {{ old('inquiry_type') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                    <option value="service" {{ old('inquiry_type') == 'service' ? 'selected' : '' }}>Service Request</option>
                    <option value="program" {{ old('inquiry_type') == 'program' ? 'selected' : '' }}>Program Inquiry</option>
                    <option value="complaint" {{ old('inquiry_type') == 'complaint' ? 'selected' : '' }}>Complaint</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                <input type="text" name="subject" id="subject" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-clsu-green focus:border-clsu-green"
                    value="{{ old('subject') }}">
                @error('subject')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                <textarea name="message" id="message" rows="6" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-clsu-green focus:border-clsu-green">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-clsu-green text-white font-semibold rounded-md hover:bg-green-cobra transition-colors">
                    Submit Inquiry
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 bg-gradient-to-r from-clsu-green to-green-cobra rounded-lg shadow-md p-8 text-white">
        <h2 class="text-2xl font-bold mb-4">Other Ways to Reach Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-clsu-yellow mb-2">Location</h3>
                <p class="text-white/90">Central Luzon State University<br>Science City of Muñoz, Nueva Ecija</p>
            </div>
            <div>
                <h3 class="font-semibold text-clsu-yellow mb-2">Contact</h3>
                <p class="text-white/90">
                    <span class="font-semibold">Director:</span> Dr. Cheryl G. Ramos<br>
                    Email: <a href="mailto:cgramos@clsu.edu.ph" class="text-clsu-yellow hover:text-white underline">cgramos@clsu.edu.ph</a><br>
                    Phone: <a href="tel:+63444560107" class="text-clsu-yellow hover:text-white underline">(044) 456-0107</a>
                </p>
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
