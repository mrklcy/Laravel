<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Office;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->orderBy('order')->with('office')->get();
        $offices = Office::active()->with('children')->get();
        return view('services.index', compact('services', 'offices'));
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)->active()->firstOrFail();
        $relatedServices = Service::active()->where('office_id', $service->office_id)
            ->where('id', '!=', $service->id)->take(4)->get();
        return view('services.show', compact('service', 'relatedServices'));
    }
}
