<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Office;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::active()->orderBy('order')->with('office')->get();
        $offices = Office::active()->with('children')->get();
        return view('programs.index', compact('programs', 'offices'));
    }

    public function show($slug)
    {
        $program = Program::where('slug', $slug)->active()->firstOrFail();
        $relatedPrograms = Program::active()->where('office_id', $program->office_id)
            ->where('id', '!=', $program->id)->take(4)->get();
        return view('programs.show', compact('program', 'relatedPrograms'));
    }
}
