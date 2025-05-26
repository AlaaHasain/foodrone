<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Option;

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
    'is_featured' => 'nullable|in:0,1',
    'is_offer' => 'nullable|in:0,1',
    'old_price' => 'nullable|numeric',
    'offer_price' => 'nullable|numeric',
    'category_id' => 'required|exists:categories,id',
    'options' => 'nullable|array',
    'options.*' => 'exists:options,id',
]);

$validated['is_featured'] = (int) $request->input('is_featured', 0);
$validated['is_offer'] = (int) $request->input('is_offer', 0);
$validated['is_popular'] = $request->has('is_popular');

if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('menu_images', 'public');
    $validated['image'] = $imagePath;
}

$menuItem = MenuItem::create($validated);

if ($request->filled('options')) {
    $menuItem->options()->attach($request->options);
}


    return redirect()->route('admin.menu-items.index')->with('success', 'Menu item added successfully.');
}


public function edit($id)
{
    $menuItem = MenuItem::with('options')->findOrFail($id);
    $categories = Category::all();
    $options = Option::all(); // ✅ جلب كل الخيارات المتاحة

    return view('admin.menu-items.edit', compact('menuItem', 'categories', 'options'));
}

public function update(Request $request, MenuItem $menuItem)
{
    $validated = $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'price' => 'required|numeric',
    'category' => 'nullable|string|max:255',
    'image' => 'nullable|image',
    'is_featured' => 'nullable|in:0,1',
    'is_offer' => 'nullable|in:0,1',
    'old_price' => 'nullable|numeric',
    'offer_price' => 'nullable|numeric',
    'category_id' => 'required|exists:categories,id',
    'options' => 'nullable|array',
    'options.*' => 'exists:options,id',
]);

$validated['is_featured'] = (int) $request->input('is_featured', 0);
$validated['is_offer'] = (int) $request->input('is_offer', 0);
$validated['is_popular'] = $request->has('is_popular');


    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('menu_images', 'public');
        $validated['image'] = $imagePath;
    }

    $validated['is_popular'] = $request->has('is_popular');

    // 1️⃣ تحديث بيانات الصنف
    $menuItem->update($validated);

    // 2️⃣ تحديث الخيارات المرتبطة
    $menuItem->options()->sync($request->options ?? []);

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
