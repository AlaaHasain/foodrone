<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class OfferController extends Controller
{
public function getOptions($id)
{
    $item = \App\Models\MenuItem::with('options.values')->findOrFail($id);

    return response()->json([
        'options' => $item->options->map(function ($option) {
            return [
                'name' => $option->name ?? 'Unnamed Option',
                'type' => $option->type,
                'values' => $option->values->map(function ($val) {
                    return [
                        'id' => $val->id,
                        'label' => $val->value ?? 'Unnamed Value', // ✅ التعديل هنا
                        'price' => is_numeric($val->additional_price) ? floatval($val->additional_price) : 0, // ✅ وهنا كمان
                    ];
                }),
            ];
        }),
    ]);
}

}
