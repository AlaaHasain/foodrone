<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::latest()->paginate(10);
        return view('admin.reservations.index', compact('reservations'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Reservation deleted successfully.');
    }

    public function accept(Reservation $reservation)
    {
        $reservation->update(['status' => 'accepted']);
    
        // إذا كان في future: ممكن ترجع تضيف email للزبون، حاليا نشيل الإرسال
        // إذا بدك رسالة داخل النظام ممكن تعمل notification داخل الداشبورد مثلاً أو log
        
        return redirect()->route('admin.reservations.index')->with('success', 'Reservation accepted successfully.');
    }
    

    public function store(Request $request)
    {
        // التحقق من المدخلات بما فيها التاريخ والوقت
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'number_of_people' => 'required|integer|min:1',
            // أي حقول أخرى مطلوبة
        ]);

        // التحقق من أن التاريخ في المستقبل
        $reservationDateTime = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $now = Carbon::now();

        if ($reservationDateTime->lessThanOrEqualTo($now)) {
            return back()
                ->withInput()
                ->withErrors(['date' => 'The reservation date and time must be in the future.']);
        }

        // التحقق من أن الوقت بين 12 ظهراً و 11 مساءً
        $hour = (int) Carbon::parse($validated['time'])->format('H');
        if ($hour < 12 || $hour >= 23) {
            return back()
                ->withInput()
                ->withErrors(['time' => 'Reservations are only available between 12:00 PM and 11:00 PM.']);
        }

        // إنشاء الحجز بعد نجاح جميع الفحوصات
        $reservation = Reservation::create([
            'customer_name' => $validated['customer_name'],
            'contact_number' => $validated['contact_number'],
            'reservation_date' => $validated['date'],
            'reservation_time' => $validated['time'],
            'number_of_people' => $validated['number_of_people'],
            'status' => 'pending',
            // أي حقول أخرى مطلوبة
        ]);

        return redirect()->route('reservations.confirmation', $reservation)
            ->with('success', 'Your reservation has been submitted successfully. We will confirm shortly.');
    }

    // طريقة بديلة للتحقق من الوقت (يمكن استخدامها في الفرونت إند)
    public function checkAvailability(Request $request)
    {
        $date = $request->input('date');
        $time = $request->input('time');

        // التحقق من أن التاريخ والوقت في المستقبل
        $reservationDateTime = Carbon::parse($date . ' ' . $time);
        $now = Carbon::now();

        if ($reservationDateTime->lessThanOrEqualTo($now)) {
            return response()->json([
                'available' => false,
                'message' => 'The reservation date and time must be in the future.'
            ]);
        }

        // التحقق من أن الوقت ضمن ساعات العمل (12 ظهراً - 11 مساءً)
        $hour = (int) $reservationDateTime->format('H');
        if ($hour < 12 || $hour >= 23) {
            return response()->json([
                'available' => false,
                'message' => 'Reservations are only available between 12:00 PM and 11:00 PM.'
            ]);
        }

        // هنا يمكن إضافة منطق إضافي للتحقق من توفر الطاولات أو أي شروط أخرى

        return response()->json([
            'available' => true,
            'message' => 'This time slot is available for reservation.'
        ]);
    }
}
