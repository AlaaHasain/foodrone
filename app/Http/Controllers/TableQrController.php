<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\MenuItem;
use App\Models\Category;
use App\Models\Order;


class TableQrController extends Controller
{
    public function showMenu($token)
    {
        $table = Table::where('qr_token', $token)->firstOrFail();
        $categories = Category::with('menuItems')->get();
    
        return view('frontend.menu', [
            'table' => $table,
            'categories' => $categories,
            'token' => $token, // ✅ أضف هذا السطر
        ]);
    }
    
}
