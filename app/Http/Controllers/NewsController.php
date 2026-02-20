<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()->latest()->paginate(10);
        $events = Event::active()->ordered()->get();
        return view('news.index', compact('news', 'events'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->published()->firstOrFail();
        $news->increment('views');
        $recentNews = News::published()->latest()->where('id', '!=', $news->id)->take(5)->get();
        return view('news.show', compact('news', 'recentNews'));
    }
}
