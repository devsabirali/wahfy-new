<?php

namespace App\Http\Controllers;

use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::withCount('blogs')->latest()->paginate(10);
        return view('admin.blog-tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.blog-tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_tags',
            'description' => 'nullable|string',
            'status' => 'boolean'
        ]);

        BlogTag::create($request->all());

        return redirect()->route('admin.blog-tags.index')
            ->with('success', 'Tag created successfully');
    }

    public function edit(BlogTag $blogTag)
    {
        return view('admin.blog-tags.edit', compact('blogTag'));
    }

    public function update(Request $request, BlogTag $blogTag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_tags,name,' . $blogTag->id,
            'description' => 'nullable|string',
            'status' => 'boolean'
        ]);

        $blogTag->update($request->all());

        return redirect()->route('admin.blog-tags.index')
            ->with('success', 'Tag updated successfully');
    }

    public function destroy(BlogTag $blogTag)
    {
        $blogTag->delete();

        return redirect()->route('admin.blog-tags.index')
            ->with('success', 'Tag deleted successfully');
    }
}
