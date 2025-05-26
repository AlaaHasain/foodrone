<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Testimonial::create($validated);

        return redirect()->back()->with('success', 'Testimonial submitted for review.');
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Testimonial approved successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->back()->with('success', 'Testimonial deleted successfully.');
    }
    public function pendingCount()
{
    $count = \App\Models\Testimonial::where('status', 'pending')->count();
    return response()->json(['count' => $count]);
}

}
