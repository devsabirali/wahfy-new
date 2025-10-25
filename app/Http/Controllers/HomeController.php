<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\{Status, Incident};
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag; 


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $banners = Banner::latest()->limit(5)->get();

        $incidents = \App\Models\Incident::with(['user', 'status', 'images'])
        // ->where('status_id', Status::where('name', 'Active')->first()->id)
        ->latest()
        ->where('verified_by','!=',null)
        ->take(8)
        ->get();

        // Get recent blogs with their relationships
        $recentBlogs = Blog::with(['author', 'categories'])
            ->where('status', true)
            ->latest()
            ->take(3)
            ->get();

        return view('site.index', compact('banners', 'recentBlogs','incidents'));
    }
}
