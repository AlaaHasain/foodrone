<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Testimonial;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::all();
        $offers = MenuItem::where('is_offer', true)
            ->with(['options.values']) // ✅ جلب الخيارات مع القيم
            ->get();
        $categories = Category::all();
        $approvedTestimonials = Testimonial::where('is_approved', true)->latest()->take(10)->get();
        $featuredItems = MenuItem::where('is_featured', 1)->latest()->take(8)->get();

        return view('home', compact('menuItems', 'offers', 'approvedTestimonials' , 'categories' , 'featuredItems'));
    }
}
