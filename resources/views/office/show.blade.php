@extends('layouts.app')

@section('title', $office->name . ' - CLSU ADSO')

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

    <!-- Content Overlay (Office Name) -->
    <div class="absolute inset-0 flex items-center z-10 pointer-events-none">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="mb-4 pointer-events-auto">
                @if($office->parent)
                    <a href="{{ route('home') }}" class="text-clsu-yellow hover:text-white transition-colors text-sm inline-flex items-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        ADSO
                    </a>
                @endif
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-2 drop-shadow-2xl">{{ $office->name }}</h1>
            @if($office->acronym)
                <p class="text-xl md:text-2xl text-clsu-yellow font-medium drop-shadow-lg">{{ $office->acronym }}</p>
            @endif
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
    @if($office->overview)
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-green-cobra mb-4">Overview</h2>
            <p class="text-gray-700 leading-relaxed text-lg">{{ $office->overview }}</p>
        </div>
    @endif

    <!-- Sub-Offices Section -->
    @if($office->children->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-green-cobra mb-6">Sub-Offices</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($office->children as $child)
                    <a href="{{ route('office.show', $child->code) }}" class="group">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-clsu-green">
                            <div class="bg-gradient-to-br from-clsu-green to-green-cobra px-6 py-6">
                                <h3 class="text-lg font-bold text-white mb-2">{{ $child->name }}</h3>
                                @if($child->acronym)
                                    <p class="text-clsu-yellow text-sm font-medium">{{ $child->acronym }}</p>
                                @endif
                            </div>
                            <div class="p-6">
                                @if($child->overview)
                                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $child->overview }}</p>
                                @endif
                                <span class="text-clsu-green text-sm font-medium group-hover:underline">
                                    Learn More →
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Services/Features Section -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-green-cobra mb-6">Services & Functions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($office->code === 'HRMO')
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Recruitment & Appointment</h3>
                        <p class="text-gray-600 text-sm">Manage the recruitment and appointment process for all university personnel, ensuring qualified candidates are selected for various positions.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Terms & Conditions of Employment</h3>
                        <p class="text-gray-600 text-sm">Establish and manage employment terms, conditions, contracts, and agreements for all university personnel.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Performance Evaluation</h3>
                        <p class="text-gray-600 text-sm">Conduct regular performance evaluations and assessments to ensure employee growth and organizational effectiveness.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Personnel Relations</h3>
                        <p class="text-gray-600 text-sm">Foster positive workplace relationships, handle employee concerns, and maintain harmonious working environment.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Welfare Services</h3>
                        <p class="text-gray-600 text-sm">Provide comprehensive welfare services and support programs for all employees and their families.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2v5m0 0v7a2 2 0 11-4 0v-7m4 0h-4m4 0h4m-8-5h.01M12 3h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Employee Benefits & Privileges</h3>
                        <p class="text-gray-600 text-sm">Administer employee benefits, privileges, and entitlements including health insurance, retirement plans, and other perks.</p>
                    </div>
                </div>
            @elseif($office->code === 'PMO')
                <div class="bg-clsu-green/5 rounded-lg p-6 mb-6 border-l-4 border-clsu-green">
                    <h3 class="font-bold text-green-cobra mb-3">Our Mission</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        The Office was established to ensure that there will be a check and balance when it comes to the purchase and delivery of different commodities of the University such as the common supplies and equipment, services and infrastructure. It has the delegated authority to conduct the following alternative method of procurement such as shopping, negotiated procurement under emergency cases, small value procurement, lease of real property and venue, and direct retail purchase of petroleum, oil and lubricant, and airline tickets.
                    </p>
                </div>
                
                <h3 class="font-bold text-green-cobra mb-4 text-lg">Alternative Methods of Procurement</h3>
                
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Shopping</h3>
                        <p class="text-gray-600 text-sm">Conduct shopping method for procurement of goods and services</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Negotiated Procurement (Emergency Cases)</h3>
                        <p class="text-gray-600 text-sm">Handle negotiated procurement under emergency situations and urgent circumstances</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Small Value Procurement</h3>
                        <p class="text-gray-600 text-sm">Process small value purchases and transactions</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Lease of Real Property and Venue</h3>
                        <p class="text-gray-600 text-sm">Manage leasing of real property and venue for university events and activities</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Direct Retail Purchase</h3>
                        <p class="text-gray-600 text-sm">Direct retail purchase of petroleum, oil and lubricant (POL), and airline tickets</p>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-bold text-green-cobra mb-4 text-lg">Commodities Managed</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-2">Common Supplies</h4>
                            <p class="text-sm text-gray-600">Office supplies, materials, and consumables</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-2">Equipment</h4>
                            <p class="text-sm text-gray-600">University equipment and machinery</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-2">Services</h4>
                            <p class="text-sm text-gray-600">Professional and technical services</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg md:col-span-3">
                            <h4 class="font-semibold text-gray-900 mb-2">Infrastructure</h4>
                            <p class="text-sm text-gray-600">Construction, renovation, and infrastructure projects</p>
                        </div>
                    </div>
                </div>
            @elseif($office->code === 'PSO')
                <div class="bg-clsu-green/5 rounded-lg p-6 mb-6 border-l-4 border-clsu-green">
                    <h3 class="font-bold text-green-cobra mb-3">Our Mission</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        To ensure check and balance in the purchase and delivery of different commodities of the University 
                        including common supplies and equipment, services, and infrastructure.
                    </p>
                </div>
                
                <h3 class="font-bold text-green-cobra mb-4 text-lg">Alternative Methods of Procurement</h3>
                
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Shopping</h3>
                        <p class="text-gray-600 text-sm">Conduct shopping method for procurement of goods and services</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Negotiated Procurement (Emergency Cases)</h3>
                        <p class="text-gray-600 text-sm">Handle negotiated procurement under emergency situations and urgent circumstances</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Small Value Procurement</h3>
                        <p class="text-gray-600 text-sm">Process small value purchases and transactions</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Lease of Real Property and Venue</h3>
                        <p class="text-gray-600 text-sm">Manage leasing of real property and venue for university events and activities</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Direct Retail Purchase</h3>
                        <p class="text-gray-600 text-sm">Direct retail purchase of petroleum, oil and lubricant (POL), and airline tickets</p>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-bold text-green-cobra mb-4 text-lg">Commodities Managed</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-2">Common Supplies</h4>
                            <p class="text-sm text-gray-600">Office supplies, materials, and consumables</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-2">Equipment</h4>
                            <p class="text-sm text-gray-600">University equipment and machinery</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-2">Services</h4>
                            <p class="text-sm text-gray-600">Professional and technical services</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg md:col-span-3">
                            <h4 class="font-semibold text-gray-900 mb-2">Infrastructure</h4>
                            <p class="text-sm text-gray-600">Construction, renovation, and infrastructure projects</p>
                        </div>
                    </div>
                </div>
            @elseif($office->code === 'RMO')
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Document Management</h3>
                        <p class="text-gray-600 text-sm">Organize and maintain official documents</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Filing System</h3>
                        <p class="text-gray-600 text-sm">Maintain organized filing and retrieval systems</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-clsu-green rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Archival Services</h3>
                        <p class="text-gray-600 text-sm">Preserve historical and important records</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-gradient-to-r from-clsu-green to-green-cobra rounded-lg shadow-md p-8 text-white">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-2xl font-bold mb-4">Contact {{ $office->name }}</h2>
            <p class="text-lg mb-6 text-white/90">
                For inquiries or assistance, please contact us
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div>
                    <h3 class="font-semibold text-clsu-yellow mb-2">Location</h3>
                    <p class="text-white/90">Central Luzon State University<br>Science City of Muñoz, Nueva Ecija</p>
                </div>
                <div>
                    <h3 class="font-semibold text-clsu-yellow mb-2">Contact</h3>
                    <p class="text-white/90">
                        @if($office->code === 'ADSO')
                            Director: Dr. Cheryl G. Ramos<br>
                            Email: <a href="mailto:cgramos@clsu.edu.ph" class="text-clsu-yellow hover:text-white underline">cgramos@clsu.edu.ph</a><br>
                        @else
                            Email: <a href="mailto:{{ strtolower($office->code) }}@clsu.edu.ph" class="text-clsu-yellow hover:text-white underline">{{ strtolower($office->code) }}@clsu.edu.ph</a><br>
                        @endif
                        Phone: <a href="tel:+63444560107" class="text-clsu-yellow hover:text-white underline">(044) 456-0107</a>
                    </p>
                </div>
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
