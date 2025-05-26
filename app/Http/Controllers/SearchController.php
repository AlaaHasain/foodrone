<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem; // أو أي موديل تريد البحث فيه
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class SearchController extends Controller
{

public function ajaxSearch(Request $request)
{
    $query = $request->input('q');

    $menuItems = MenuItem::where('name', 'LIKE', "%$query%")
                    ->select('id', 'name')
                    ->get();

    return response()->json([
        'menuItems' => $menuItems, // ✅ نفس الاسم اللي بتستخدمه في JS
    ]);

}

}
