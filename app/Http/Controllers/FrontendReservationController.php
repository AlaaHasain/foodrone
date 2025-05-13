<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontendReservationController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'customer_name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'people' => 'required|integer|min=1|max:20',
        'date' => 'required|date',
        'time' => 'required',
        'note' => 'nullable|string',
    ]);

    Reservation::create([
        'customer_name' => $request->customer_name,
        'contact_number' => $request->contact_number,
        'people' => $request->people,
        'date' => $request->date,
        'time' => $request->time,
        'note' => $request->note,
        'status' => 'pending',
    ]);

    return redirect()->route('reservation')->with('success', 'Your reservation has been successfully submitted. For inquiries, please contact 0796990562.');

}

}
