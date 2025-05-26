<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Http\Request;

class OptionValueController extends Controller
{
    // عرض كل القيم المرتبطة بخيار معين
    public function index($optionId)
    {
        $option = Option::with('values')->findOrFail($optionId);
        return view('admin.option-values.index', compact('option'));
    }

    // عرض الفورم لإضافة قيمة جديدة
    public function create($optionId)
    {
        $option = Option::findOrFail($optionId);
        return view('admin.option-values.create', compact('option'));
    }

    // حفظ القيمة الجديدة
public function store(Request $request, $optionId)
{
    $request->validate([
        'value' => 'required|string|max:255',
        'additional_price' => 'nullable|numeric|min:0',
        'description' => 'nullable|string|max:500',
    ]);

    OptionValue::create([
        'option_id' => $optionId,
        'value' => $request->value,
        'additional_price' => $request->additional_price ?? 0,
        'description' => $request->description, // ✅ أضف هذا السطر
    ]);

    return redirect()->route('admin.option-values.index', $optionId)
                     ->with('success', 'Value added successfully.');
}


    // تعديل قيمة موجودة
    public function edit($optionId, OptionValue $optionValue)
    {
        $option = Option::findOrFail($optionId);
        return view('admin.option-values.edit', compact('option', 'optionValue'));
    }

    // تحديث القيمة
public function update(Request $request, $optionId, OptionValue $optionValue)
{
    $request->validate([
        'value' => 'required|string|max:255',
        'additional_price' => 'nullable|numeric|min:0',
        'description' => 'nullable|string|max:500',
    ]);

    $optionValue->update([
        'value' => $request->value,
        'additional_price' => $request->additional_price ?? 0,
        'description' => $request->description, // ✅ أضف هذا السطر
    ]);

    return redirect()->route('admin.option-values.index', $optionId)
                     ->with('success', 'Value updated successfully.');
}


    // حذف قيمة
    public function destroy($optionId, OptionValue $optionValue)
    {
        $optionValue->delete();
        return back()->with('success', 'Value deleted successfully.');
    }
}
