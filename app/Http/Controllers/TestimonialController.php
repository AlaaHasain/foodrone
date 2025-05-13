<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Testimonial::create([
            'customer_name' => $validated['customer_name'],
            'message' => $validated['message'],
            'is_approved' => false, // عشان يراجعها الادمن
        ]);

        return back()->with('success', 'Thank you! Your testimonial is submitted for review.');
    }
}
