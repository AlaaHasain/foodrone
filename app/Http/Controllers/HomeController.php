<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::all();
        $offers = MenuItem::where('is_offer', true)->get();
        $approvedTestimonials = Testimonial::where('is_approved', true)->latest()->take(10)->get();
        
        return view('home', compact('menuItems', 'offers', 'approvedTestimonials'));
    }
}
