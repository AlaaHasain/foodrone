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
    $categories = Category::with('menuItems')->get();

    $featuredItems = MenuItem::where('is_featured', 1)->take(10)->get(); // حسب ما بدك العدد

    $menuItems = MenuItem::with('category', 'options')->get();

    return view('menu', compact('categories', 'menuItems', 'featuredItems'));
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