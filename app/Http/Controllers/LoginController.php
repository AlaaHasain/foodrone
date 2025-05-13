<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function showPhoneForm()
    {
        return view('orders.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name'  => 'required|string|min:3|max:50|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|string|min:9|max:15|regex:/^[0-9+\-]+$/',
        ]);
    
        $email = $request->email;
        $otp = rand(100000, 999999);
    
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => bcrypt('guest123456'),
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(5),
            ]
        );
    
        session(['otp_email' => $email]);
    
        try {
            Mail::raw("Your OTP code is: {$otp}", function ($message) use ($email) {
                $message->to($email)->subject('Your OTP Code');
            });
        } catch (\Exception $e) {
            \Log::error('Error sending OTP email: ' . $e->getMessage());
        }
    
        return redirect()->route('verify.form')->with('success', 'تم إرسال رمز التحقق إلى بريدك الإلكتروني!');
    }
    

    public function showVerifyForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('login')->with('error', 'جلسة غير صالحة. الرجاء المحاولة مرة أخرى.');
        }
        
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);
        
        $email = session('otp_email');
        
        if (!$email) {
            return redirect()->route('login')->with('error', 'جلسة غير صالحة. الرجاء المحاولة مرة أخرى.');
        }

        $user = User::where('email', $email)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>=', now())
            ->first();

        if (!$user) {
            return back()->with('error', '❌ رمز التحقق غير صالح أو منتهي الصلاحية.');
        }
        
        // تحديث بيانات المستخدم وتسجيل الدخول
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);
        
        Auth::login($user);
        
        session(['customer_email' => $email]);
        session()->flash('welcome', 'مرحباً ' . $user->name . '!');

        return redirect(url('/my-orders'));
    }
}