<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterInfo;
use Illuminate\Http\Request;

class FooterInfoController extends Controller
{
    public function index()
    {
        $footer = FooterInfo::first();
        
        // إذا لم يكن هناك سجل، نقوم بإنشاء واحد افتراضي
        if (!$footer) {
            $footer = new FooterInfo();
        }
        
        return view('admin.footer-info.index', compact('footer'));
    }

    public function update(Request $request, $id)
    {
        // البحث عن السجل، وإنشاؤه إذا لم يكن موجوداً
        $footerInfo = FooterInfo::find($id);
        
        if (!$footerInfo) {
            $footerInfo = new FooterInfo();
        }
        
        $validated = $request->validate([
            'about' => 'nullable|string',
            'working_hours' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'whatsapp' => 'nullable|url',
            'copyright' => 'nullable|string',
        ]);

        // في حالة السجل الجديد
        if (!$footerInfo->exists) {
            $footerInfo = FooterInfo::create($validated);
        } else {
            $footerInfo->update($validated);
        }

        return redirect()->route('admin.footer-info.index')->with('success', 'Sucssfully updated footer information.');
    }
}