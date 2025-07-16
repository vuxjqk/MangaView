<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'title' => 'required|string|max:255',
            'chapter_number' => 'required|integer|min:1',
            'is_premium' => 'boolean',
        ]);

        $validated['uploaded_by'] = Auth::id();
        $validated['views'] = 0; // Lượt xem mặc định

        Chapter::create($validated);

        return redirect()->route('chapters.index')->with('success', 'Chapter created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Chapter $chapter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chapter $chapter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        //
    }
}
