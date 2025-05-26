<?php
namespace App\Http\Controllers\Admin;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::withCount('values')->latest()->paginate(10);
        return view('admin.options.index', compact('options'));
    }

    public function create()
    {
        return view('admin.options.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:checkbox,radio' // ✅ نتحقق من النوع
    ]);

    Option::create($request->only('name', 'type')); // ✅ نحفظ الاسم والنوع
    return redirect()->route('admin.options.index')->with('success', 'Option created.');
}


    public function edit(Option $option)
    {
        return view('admin.options.edit', compact('option'));
    }

    public function update(Request $request, Option $option)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:checkbox,radio' // ✅ نتحقق من النوع
    ]);

    $option->update($request->only('name', 'type')); // ✅ نحدث الاسم والنوع
    return redirect()->route('admin.options.index')->with('success', 'Option updated.');
}


    public function destroy(Option $option)
    {
        $option->delete();
        return back()->with('success', 'Option deleted.');
    }
}
