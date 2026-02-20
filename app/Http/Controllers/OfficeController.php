<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Display a specific office page.
     */
    public function show($code)
    {
        // Normalize code to uppercase
        $code = strtoupper($code);
        
        $office = Office::where('code', $code)->with('parent', 'children')->first();
        
        if (!$office) {
            abort(404, 'Office not found');
        }
        
        // Load related data
        $services = \App\Models\Service::where('office_id', $office->id)->where('is_active', true)->orderBy('order')->get();
        $programs = \App\Models\Program::where('office_id', $office->id)->where('is_active', true)->orderBy('order')->get();
        
        // Check if specific office view exists, otherwise use generic
        $viewName = 'office.' . strtolower($code);
        if (view()->exists($viewName)) {
            return view($viewName, compact('office', 'services', 'programs'));
        }
        
        return view('office.show', compact('office', 'services', 'programs'));
    }
}
