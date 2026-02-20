<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CLSU - Administrative Services Office')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.tailwindcss.com"></script>
        <script>
            @php
                $adsoThemeColor = \App\Models\Office::where('code', 'ADSO')->value('website_theme_color') ?? '#009639';
            @endphp
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'clsu-green': '{{ $adsoThemeColor }}',
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
        
        /* Scroll Animation Styles */
        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        
        .scroll-animate.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Stagger animation delays for multiple elements */
        .scroll-animate:nth-child(1) { transition-delay: 0.1s; }
        .scroll-animate:nth-child(2) { transition-delay: 0.2s; }
        .scroll-animate:nth-child(3) { transition-delay: 0.3s; }
        .scroll-animate:nth-child(4) { transition-delay: 0.4s; }
        .scroll-animate:nth-child(5) { transition-delay: 0.5s; }
        .scroll-animate:nth-child(6) { transition-delay: 0.6s; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Top Header Bar -->
    <div class="bg-green-cobra text-white text-xs py-2">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="mailto:op@clsu.edu.ph" class="flex items-center space-x-1 hover:text-clsu-yellow transition-colors">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        <span>op@clsu.edu.ph</span>
                    </a>
                    <a href="tel:+63449408785" class="flex items-center space-x-1 hover:text-clsu-yellow transition-colors">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                        <span>(044) 940 8785</span>
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="https://www.facebook.com/clsuofficialpage" target="_blank" class="hover:text-clsu-yellow transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://x.com/clsu_official" target="_blank" class="hover:text-clsu-yellow transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/clsu.official" target="_blank" class="hover:text-clsu-yellow transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/company/central-luzon-state-university/" target="_blank" class="hover:text-clsu-yellow transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="https://www.youtube.com/@clsutube" target="_blank" class="hover:text-clsu-yellow transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Header -->
    <header class="bg-clsu-green shadow-md sticky top-0 z-50">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-4">
                        <img src="{{ asset('images/clsu-logo-green.png') }}" alt="CLSU Logo" class="h-16 w-16 object-contain">
                        <div>
                            <h1 class="text-2xl font-bold text-white">CLSU ADSO</h1>
                            <p class="text-xs text-clsu-yellow">Administrative Services Office</p>
                        </div>
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md transition-colors {{ request()->routeIs('home') ? 'bg-white/20' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('services.index') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md transition-colors {{ request()->routeIs('services.*') ? 'bg-white/20' : '' }}">
                        Services
                    </a>
                    <a href="{{ route('programs.index') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md transition-colors {{ request()->routeIs('programs.*') ? 'bg-white/20' : '' }}">
                        Programs
                    </a>
                    <a href="{{ route('news.index') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md transition-colors {{ request()->routeIs('news.*') ? 'bg-white/20' : '' }}">
                        News & Events
                    </a>
                    <div class="relative group">
                        <button class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md transition-colors flex items-center">
                            Offices
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute top-full left-0 mt-1 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('office.show', 'HRMO') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-clsu-green hover:text-white">HRMO</a>
                            <a href="{{ route('office.show', 'PMO') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-clsu-green hover:text-white">Procurement</a>
                            <a href="{{ route('office.show', 'PSO') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-clsu-green hover:text-white">Property & Supply</a>
                            <a href="{{ route('office.show', 'RMO') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-clsu-green hover:text-white">Records</a>
                        </div>
                    </div>
                    <a href="{{ route('inquiries.create') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md transition-colors {{ request()->routeIs('inquiries.*') ? 'bg-white/20' : '' }}">
                        Contact
                    </a>
                    <a href="https://www.clsu.edu.ph" target="_blank" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md transition-colors flex items-center">
                        CLSU Website
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    @if (Route::has('login'))
                        <div class="ml-4 pl-4 border-l border-white/20">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-white border-2 border-white rounded-md hover:bg-white hover:text-clsu-green transition-colors">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-white hover:text-clsu-yellow transition-colors">
                                    Log in
                                </a>
                            @endif
                        </div>
                    @endif
                </nav>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md {{ request()->routeIs('home') ? 'bg-white/20' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('services.index') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                        Services
                    </a>
                    <a href="{{ route('programs.index') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                        Programs
                    </a>
                    <a href="{{ route('news.index') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                        News & Events
                    </a>
                    <a href="{{ route('inquiries.create') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                        Contact
                    </a>
                    <a href="https://www.clsu.edu.ph" target="_blank" class="px-4 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md flex items-center">
                        CLSU Website
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    @if (Route::has('login'))
                        <div class="pt-2 border-t border-white/20">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm font-medium text-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm font-medium text-white">
                                    Log in
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-green-cobra mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <!-- Official Seals -->
                    <div class="flex flex-wrap items-center gap-4 mb-4">
                        <img src="{{ asset('images/seal/foi-logo-2025-2.png') }}" alt="Freedom of Information - Philippines" class="h-20 w-20 object-contain">
                        <img src="{{ asset('images/seal/transparency_seal.png') }}" alt="Philippine Transparency Seal" class="h-20 w-20 object-contain">
                        <img src="{{ asset('images/seal/logo-white-footer2.png') }}" alt="Central Luzon State University Seal" class="h-20 w-20 object-contain">
                    </div>
                    <p class="text-white/80 text-sm">
                        Central Luzon State University<br>
                        Science City of Muñoz, Nueva Ecija
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-white/80 hover:text-clsu-yellow transition-colors">Home</a></li>
                        <li><a href="{{ route('services.index') }}" class="text-white/80 hover:text-clsu-yellow transition-colors">Services</a></li>
                        <li><a href="{{ route('programs.index') }}" class="text-white/80 hover:text-clsu-yellow transition-colors">Programs</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-white/80 hover:text-clsu-yellow transition-colors">News & Updates</a></li>
                        <li><a href="{{ route('inquiries.create') }}" class="text-white/80 hover:text-clsu-yellow transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Offices</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('office.show', 'HRMO') }}" class="text-white/80 hover:text-clsu-yellow transition-colors">HRMO</a></li>
                        <li><a href="{{ route('office.show', 'PMO') }}" class="text-white/80 hover:text-clsu-yellow transition-colors">Procurement</a></li>
                        <li><a href="{{ route('office.show', 'PSO') }}" class="text-white/80 hover:text-clsu-yellow transition-colors">Property & Supply</a></li>
                        <li><a href="{{ route('office.show', 'RMO') }}" class="text-white/80 hover:text-clsu-yellow transition-colors">Records</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Contact</h3>
                    <p class="text-white/80 text-sm">
                        <span class="font-semibold text-clsu-yellow">Director:</span><br>
                        Dr. Cheryl G. Ramos<br>
                        <a href="mailto:cgramos@clsu.edu.ph" class="text-clsu-yellow hover:text-white">cgramos@clsu.edu.ph</a><br>
                        <a href="tel:+63444560107" class="text-clsu-yellow hover:text-white">(044) 456-0107</a>
                    </p>
                </div>
            </div>
            <div class="border-t border-white/20 mt-8 pt-6">
                <p class="text-center text-sm text-white/80">
                    &copy; {{ date('Y') }} Central Luzon State University. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
        
        // Scroll Animation Observer
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-add scroll-animate class to common sections
            const autoAnimateSelectors = [
                'section',
                '.bg-white',
                '.card',
                '.grid > div',
                'article',
                '.service-card',
                '.program-card',
                '.news-card'
            ];
            
            autoAnimateSelectors.forEach(selector => {
                document.querySelectorAll(selector).forEach(element => {
                    // Only add if it doesn't already have the class and is not a child of another animated element
                    if (!element.classList.contains('scroll-animate') && 
                        !element.closest('.scroll-animate')) {
                        element.classList.add('scroll-animate');
                    }
                });
            });
            
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                        // Optional: stop observing after animation
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            // Observe all elements with scroll-animate class
            const animateElements = document.querySelectorAll('.scroll-animate');
            animateElements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
