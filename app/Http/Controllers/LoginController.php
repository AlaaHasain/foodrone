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
        // ✅ تحقق إذا كان quick login
        if ($request->has('quick_login')) {
            $request->validate([
                'email' => 'required|email',
            ]);

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'البريد الإلكتروني غير مسجل.');
            }

            $otp = rand(100000, 999999);
            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            session([
                'otp_email' => $request->email,
                'remember' => true,
                'otp_sent_at' => now(),
            ]);

            try {
                Mail::raw("Your OTP code is: {$otp}", function ($message) use ($request) {
                    $message->to($request->email)->subject('Your OTP Code');
                });
            } catch (\Exception $e) {
                \Log::error('Error sending OTP email: ' . $e->getMessage());
            }

            return redirect()->route('verify.form')->with('success', 'Verification code has been sent to your email.');
        }

        // ✅ تسجيل الدخول العادي
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

        session([
            'otp_email' => $email,
            'remember' => $request->has('remember'),
            'otp_sent_at' => now(),
        ]);

        try {
            Mail::raw("Your OTP code is: {$otp}", function ($message) use ($email) {
                $message->to($email)->subject('Your OTP Code');
            });
        } catch (\Exception $e) {
            \Log::error('Error sending OTP email: ' . $e->getMessage());
        }

        return redirect()->route('verify.form')->with('success', 'Verification code has been sent to your email!');
    }
    
public function resendOtp(Request $request)
{
    $email = session('otp_email');

    if (!$email) {
        return response()->json(['message' => 'Invalid session.'], 422);
    }

    $user = User::where('email', $email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    $otp = rand(100000, 999999);
    $user->update([
        'otp' => $otp,
        'otp_expires_at' => now()->addMinutes(5),
    ]);

    session(['otp_sent_at' => now()]);

    try {
        Mail::raw("Your OTP code is: {$otp}", function ($message) use ($email) {
            $message->to($email)->subject('Your OTP Code');
        });
    } catch (\Exception $e) {
        \Log::error('Error sending OTP email: ' . $e->getMessage());
        return response()->json(['message' => 'Failed to send OTP.'], 500);
    }

    return response()->json(['message' => 'New OTP sent to your email.']);
}


    public function showVerifyForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('login')->with('error', 'Invalid session. Please try again.');
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
            return redirect()->route('login')->with('error', 'Invalid session. Please try again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'User not found.')->withInput();
        }
        
        // Check if OTP matches (convert to string to ensure correct comparison)
        if ($user->otp != (string)$request->otp) {
            return back()->withErrors([
                'otp' => '❌ رمز التحقق غير صحيح، حاول مرة أخرى.'
            ])->withInput();
        }

        // Check if OTP is expired
        if ($user->otp_expires_at < now()) {
            return back()->withErrors([
                'otp' => '⌛ رمز التحقق منتهي الصلاحية، أعد الإرسال.'
            ])->withInput();
        }

        // ✅ تفريغ الـ OTP بعد الاستخدام
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        // ✅ تسجيل الدخول عبر Auth
        $remember = session('remember', false);
        session()->forget(['remember', 'otp_sent_at']);
        \Auth::login($user, $remember);

        // ✅ إضافة بيانات العميل للجلسة
        session([
            'customer_id'    => $user->id,
            'customer_email' => $email,
            'customer_name'  => $user->name,
            'customer_phone' => $user->phone,
        ]);

        // ✅ Flash message للترحيب
        session()->flash('welcome', 'Welcome ' . $user->name . '!');

        // ✅ نرسل remember_email إلى الجلسة لتُقرأ في الـ Blade وتُحفظ في localStorage
        if ($remember) {
            session([
                'remember_email' => $email,
                'customer_name'  => $user->name,
                'customer_phone' => $user->phone,
            ]);
        }

        // ✅ التوجيه للصفحة المطلوبة (أو الصفحة الرئيسية)
        $redirectTo = session('redirect_after_login', route('home'));
        session()->forget('redirect_after_login');

        return redirect($redirectTo);
    }
}