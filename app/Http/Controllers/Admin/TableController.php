<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Table;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::latest()->get();
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tables.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|unique:tables',
            'qr_token' => 'nullable|string',
        ]);
    
        Table::create([
            'table_number' => $request->table_number,
            'qr_token' => $request->qr_token ?? Str::random(32),
        ]);
    
        return redirect()->route('admin.tables.index')->with('success', 'Table added successfully.');
    }
    
    
    public function qr($id)
    {
        $table = Table::findOrFail($id);
    
        // هذا الرابط هو اللي بيوصل الزبون على المنيو ويحتوي على التوكن
        $url = url("/menu?token={$table->qr_token}");
    
        return \QrCode::format('png')->size(200)->generate($url, response()->stream()->header('Content-Type', 'image/png'));
    }
    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Table::destroy($id);
        return redirect()->route('admin.tables.index')->with('success', 'Table deleted successfully.');
    }
    
    
}
