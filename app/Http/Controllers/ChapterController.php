<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Http\Controllers\Controller;
use App\Models\ChapterImage;
use App\Models\Comic;
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
    public function create(Request $request)
    {
        $comicId = $request->query('comic_id');
        $comic = Comic::findOrFail($comicId);
        return view('chapters.create', compact('comic'));
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
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $validated['uploaded_by'] = Auth::id();
        $validated['views'] = 0; // Lượt xem mặc định

        // Tạo chương mới
        $chapter = Chapter::create($validated);

        // Lưu ảnh (nếu có)
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('chapter_images', 'public');
            $format = $image->extension();

            ChapterImage::create([
                'chapter_id' => $chapter->id,
                'image_url' => $path,
                'page_number' => $index + 1,
                'format' => $format,
            ]);
        }

        return redirect()->route('comics.show',  $validated['comic_id'])->with('success', 'Chapter created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Chapter $chapter)
    {
        return view('chapters.show', compact('chapter'));
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
