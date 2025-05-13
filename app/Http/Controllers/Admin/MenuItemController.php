<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
{
    $menuItems = MenuItem::latest()->paginate(10);
    return view('admin.menu-items.index', compact('menuItems'));
}


public function create()
{
    $categories = \App\Models\Category::all();
    return view('admin.menu-items.create', compact('categories'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'is_featured' => 'required|boolean',
            'is_offer' => 'required|boolean',
            'old_price' => 'nullable|numeric',
            'offer_price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_popular'] = $request->has('is_popular');

        MenuItem::create($validated);

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item added successfully.');
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = \App\Models\Category::all();
        return view('admin.menu-items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'is_featured' => 'required|boolean',
            'is_offer' => 'required|boolean',
            'old_price' => 'nullable|numeric',
            'offer_price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_popular'] = $request->has('is_popular');

        $menuItem->update($validated);

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $menuItem)
    {
        // حذف الصورة لو موجودة (اختياري)
        if ($menuItem->image) {
            \Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item deleted successfully.');
    }
}
