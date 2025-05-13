<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,heic,avif|max:4096',
            'type' => 'required|in:restaurant,food',
        ]);
        
        

        $path = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'image_path' => $path,
            // 'type' => $request->type,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Image uploaded successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        \Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Image deleted successfully.');
    }
}
