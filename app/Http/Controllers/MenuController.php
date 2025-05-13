<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Category;

class MenuController extends Controller
{
    // عرض صفحة القائمة
    public function index()
    {
        $menuItems = MenuItem::with('category')->get(); // ⬅️ هنا المهم
        $categories = \App\Models\Category::all(); // عشان تعرض التصنيفات
    
        return view('menu', compact('menuItems', 'categories'));
    }

    // عرض تفاصيل منتج محدد
    public function show($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        
        if (request()->expectsJson()) {
            return response()->json([
                'item' => $menuItem
            ]);
        }
        
        return view('menu', compact('menuItem'));
    }
}