@extends('layouts.app')

@section('title', 'Human Resources Management Office - CLSU ADSO')

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
            <div class="mb-4 pointer-events-auto">
                <a href="{{ route('home') }}" class="text-clsu-yellow hover:text-white transition-colors text-sm inline-flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    ADSO
                </a>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-2 drop-shadow-2xl">Human Resources Management Office</h1>
            <p class="text-xl md:text-2xl text-clsu-yellow font-medium drop-shadow-lg">HRMO</p>
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
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Overview Section -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-green-cobra mb-4">Overview</h2>
        <p class="text-gray-700 leading-relaxed text-lg">
            {{ $office->overview }}
        </p>
    </div>

    <!-- Main Functions Section -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-green-cobra mb-8 text-center">Our Main Functions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Function 1: Recruitment & Appointment -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all border-2 border-transparent hover:border-clsu-green">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Recruitment & Appointment</h3>
                <p class="text-gray-600 text-sm text-center mb-4">Manage the recruitment and appointment process for all university personnel</p>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Job Posting & Advertisement
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Application Screening
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Interview & Selection
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Appointment Processing
                    </li>
                </ul>
            </div>

            <!-- Function 2: Terms & Conditions -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all border-2 border-transparent hover:border-clsu-green">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Terms & Conditions of Employment</h3>
                <p class="text-gray-600 text-sm text-center mb-4">Establish and manage employment terms and conditions</p>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Employment Contracts
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Job Descriptions
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Salary & Compensation
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Work Schedule & Policies
                    </li>
                </ul>
            </div>

            <!-- Function 3: Performance Evaluation -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all border-2 border-transparent hover:border-clsu-green">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Performance Evaluation</h3>
                <p class="text-gray-600 text-sm text-center mb-4">Conduct regular performance evaluations and assessments</p>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Annual Performance Review
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Performance Metrics
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Goal Setting & Monitoring
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Performance Improvement Plans
                    </li>
                </ul>
            </div>

            <!-- Function 4: Personnel Relations -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all border-2 border-transparent hover:border-clsu-green">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Personnel Relations</h3>
                <p class="text-gray-600 text-sm text-center mb-4">Foster positive workplace relationships and handle employee concerns</p>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Conflict Resolution
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Employee Counseling
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Grievance Handling
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Workplace Harmony
                    </li>
                </ul>
            </div>

            <!-- Function 5: Welfare Services -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all border-2 border-transparent hover:border-clsu-green">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Welfare Services</h3>
                <p class="text-gray-600 text-sm text-center mb-4">Provide comprehensive welfare services and support programs</p>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Health & Wellness Programs
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Employee Assistance Programs
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Family Support Services
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Emergency Assistance
                    </li>
                </ul>
            </div>

            <!-- Function 6: Employee Benefits & Privileges -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all border-2 border-transparent hover:border-clsu-green">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Employee Benefits & Privileges</h3>
                <p class="text-gray-600 text-sm text-center mb-4">Administer employee benefits and entitlements</p>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Health Insurance
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Retirement Plans
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Leave Benefits
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-clsu-green mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Other Privileges
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Detailed Services Section -->
    @if($services && $services->count() > 0)
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-green-cobra mb-8 text-center">Our Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($services as $service)
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-clsu-green hover:shadow-xl transition-all">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $service->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                    @if($service->requirements)
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-900 mb-2">Requirements:</h4>
                            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $service->requirements }}</p>
                        </div>
                    @endif
                    @if($service->process)
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-900 mb-2">Process:</h4>
                            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $service->process }}</p>
                        </div>
                    @endif
                    @if($service->contact_email || $service->contact_phone)
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                @if($service->contact_email)
                                    <span class="font-semibold">Email:</span> {{ $service->contact_email }}
                                @endif
                                @if($service->contact_phone)
                                    <br><span class="font-semibold">Phone:</span> {{ $service->contact_phone }}
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Programs Section -->
    @if($programs && $programs->count() > 0)
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-green-cobra mb-8 text-center">HRMO Programs</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($programs as $program)
                <div class="bg-gradient-to-br from-clsu-gold/10 to-clsu-yellow/10 rounded-lg shadow-md p-6 border-l-4 border-clsu-gold">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $program->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $program->description }}</p>
                    @if($program->benefits)
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-900 mb-2">Benefits:</h4>
                            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $program->benefits }}</p>
                        </div>
                    @endif
                    @if($program->eligibility)
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-900 mb-2">Eligibility:</h4>
                            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $program->eligibility }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Process Flow Section -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-green-cobra mb-6">How We Work</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">1</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Submit Request</h3>
                <p class="text-sm text-gray-600">Submit your request or application through our office or online portal</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">2</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Review & Process</h3>
                <p class="text-sm text-gray-600">Our team reviews and processes your request according to policies</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">3</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Verification</h3>
                <p class="text-sm text-gray-600">We verify documents and information as needed</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-clsu-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">4</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Completion</h3>
                <p class="text-sm text-gray-600">Request is completed and you are notified of the result</p>
            </div>
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class="bg-gradient-to-r from-clsu-green to-green-cobra rounded-lg shadow-md p-8 mb-8 text-white">
        <h2 class="text-2xl font-bold mb-6 text-center">Quick Links</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('inquiries.create', ['office_id' => $office->id]) }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-colors">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <p class="text-sm font-medium">Submit Inquiry</p>
            </a>
            <a href="{{ route('services.index') }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-colors">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <p class="text-sm font-medium">View Services</p>
            </a>
            <a href="{{ route('programs.index') }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-colors">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                <p class="text-sm font-medium">View Programs</p>
            </a>
            <a href="{{ route('news.index') }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-colors">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <p class="text-sm font-medium">News & Updates</p>
            </a>
        </div>
    </div>

    <!-- Chief/Head Section -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8 border-l-4 border-clsu-green">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <div class="w-24 h-24 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-bold text-green-cobra mb-2">Chief, HRMO</h2>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Mr. Jonathan T. Gurion</h3>
                <div class="space-y-2 text-gray-700">
                    <p class="flex items-center justify-center md:justify-start">
                        <svg class="w-5 h-5 text-clsu-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:hrmo@clsu.edu.ph" class="hover:text-clsu-green transition-colors">hrmo@clsu.edu.ph</a>
                    </p>
                    <p class="flex items-center justify-center md:justify-start">
                        <svg class="w-5 h-5 text-clsu-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:+63444560107" class="hover:text-clsu-green transition-colors">(044) 456-0107</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-gradient-to-r from-clsu-green to-green-cobra rounded-lg shadow-md p-8 text-white">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-2xl font-bold mb-4">Contact HRMO</h2>
            <p class="text-lg mb-6 text-white/90">
                For inquiries or assistance, please contact the Human Resources Management Office
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div>
                    <h3 class="font-semibold text-clsu-yellow mb-2">Location</h3>
                    <p class="text-white/90">Central Luzon State University<br>Science City of Muñoz, Nueva Ecija</p>
                </div>
                <div>
                    <h3 class="font-semibold text-clsu-yellow mb-2">Contact</h3>
                    <p class="text-white/90">
                        Chief: Mr. Jonathan T. Gurion<br>
                        Email: <a href="mailto:hrmo@clsu.edu.ph" class="text-clsu-yellow hover:text-white underline">hrmo@clsu.edu.ph</a><br>
                        Phone: <a href="tel:+63444560107" class="text-clsu-yellow hover:text-white underline">(044) 456-0107</a>
                    </p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('inquiries.create', ['office_id' => $office->id]) }}" class="inline-block px-6 py-3 bg-clsu-yellow text-clsu-green font-semibold rounded-md hover:bg-clsu-gold transition-colors">
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
