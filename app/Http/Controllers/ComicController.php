<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $comics = Comic::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('comics.index', compact('comics', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();
        return view('comics.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'status' => 'in:ongoing,completed',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'language' => 'in:vi,en',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        $validated['created_by'] = Auth::id();

        $comic = Comic::create($validated);

        if (isset($validated['genres'])) {
            $comic->genres()->sync($validated['genres']);
        }

        return redirect()->route('comics.index')->with('success', 'Comic created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comic $comic)
    {
        return view('comics.show', compact('comic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comic $comic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comic $comic)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'status' => 'in:ongoing,completed',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'language' => 'in:vi,en',
            'is_approved' => 'boolean'
        ]);

        // Xử lý ảnh nếu có upload mới
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        $comic->update($validated);

        return redirect()->route('comics.index')->with('success', 'Comic updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comic $comic)
    {
        try {
            $comic->delete();
            return redirect()->route('comics.index')->with('success', 'Comic deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('comics.index')->with('error', 'Failed to delete comic. It may have associated records.');
        }
    }
}
