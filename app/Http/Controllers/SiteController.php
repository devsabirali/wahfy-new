<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\{Status, Incident};
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class SiteController extends Controller
{


    public function about()
    {
        return view('site.about');
    }

    public function blog(Request $request)
    {
        $query = Blog::with(['author', 'categories', 'tags'])
            ->latest();

        // Filter by category if provided
        if ($request->has('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('blog_categories.id', $request->category);
            });
        }

        // Filter by tag if provided
        if ($request->has('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('blog_tags.id', $request->tag);
            });
        }

        // Search functionality
        if ($request->has('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->paginate(9);

        $categories = BlogCategory::withCount('blogs')
            ->where('status', true)
            ->get();

        $recentPosts = Blog::with('author')
            ->latest()
            ->take(3)
            ->get();

        $tags = BlogTag::where('status', true)->get();

        return view('site.blog', compact('blogs', 'categories', 'recentPosts', 'tags'));
    }

    /**
     * Display the specified blog post.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\View\View
     */
    public function blog_detail(Blog $blog)
    {
        // Load relationships
        $blog->load(['author', 'categories', 'tags']);

        // Get categories with blog count
        $categories = BlogCategory::withCount('blogs')
            ->where('status', true)
            ->get();

        // Get recent posts excluding current blog
        $recentPosts = Blog::with('author')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        // Get all active tags
        $tags = BlogTag::where('status', true)->get();

        return view('site.blog-details', compact('blog', 'categories', 'recentPosts', 'tags'));
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function donation()
    {
        $incidents = \App\Models\Incident::with(['user', 'status', 'images'])
            // ->where('status_id', Status::where('name', 'Verified')->first()->id)
            ->where('verified_by','!=',null)
            ->latest()
            ->paginate(8);
        return view('site.donations',compact('incidents'));
    }

    public function donation_detail(Incident $incident)
    {
        return view('site.donation-details', compact('incident'));
    }

    public function event()
    {
        return view('site.events');
    }

    public function event_detail()
    {
        return view('site.event-details');
    }

    public function faq()
    {
        return view('site.faq');
    }

    public function pricing()
    {
        return view('site.pricing');
    }

    public function project()
    {
        return view('site.projects');
    }

    public function project_detail()
    {
        return view('site.project-details');
    }

    public function services()
    {
        return view('site.services');
    }

    public function service_detail()
    {
        return view('site.service-details');
    }

    public function teams()
    {
        return view('site.team');
    }

    public function team_detail()
    {
        return view('site.team-details');
    }

    /**
     * Handle all other (404) routes
     */
    public function not_found()
    {
        // You can pass along the attempted URL if you like:
        // $url = request()->path();
        return response()->view('site.404', [], 404);
    }

    public function search(Request $request)
    {
        return $this->blog($request);
    }
}
