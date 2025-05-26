<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10); // ✅ بدل all بـ paginate
        return view('admin.categories.index', compact('categories'));
    }    

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'name_ar' => 'required|string|max:255'
    ]);

    Category::create([
        'name' => $request->name,
        'name_ar' => $request->name_ar
    ]);

    return redirect()->route('admin.categories.index')->with('success', 'Category added successfully.');
}


    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        'name_ar' => 'required|string|max:255'
    ]);

    $category->update([
        'name' => $request->name,
        'name_ar' => $request->name_ar
    ]);

    return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
}


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
