<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\News;
use App\Models\Service;
use App\Models\Program;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the ADSO homepage.
     */
    public function index()
    {
        $adso = Office::where('code', 'ADSO')->with('children')->first();
        
        if (!$adso) {
            abort(404, 'ADSO Office not found');
        }
        
        $latestNews = News::published()->latest()->take(6)->get();
        $featuredServices = Service::active()->orderBy('order')->take(6)->get();
        $activePrograms = Program::active()->ongoing()->orderBy('order')->take(6)->get();
        $sliders = Slider::active()->ordered()->get();
        
        return view('adso.index', compact('adso', 'latestNews', 'featuredServices', 'activePrograms', 'sliders'));
    }
}

