<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        return view('attendance.index', [
            'records' => Attendance::with('user')->latest('work_date')->take(20)->get(),
        ]);
    }

    public function clockIn(): RedirectResponse
    {
        Attendance::updateOrCreate(
            ['user_id' => auth()->id(), 'work_date' => today()],
            ['clock_in_at' => now(), 'status' => 'present']
        );

        return back()->with('status', 'Clock-in recorded.');
    }

    public function clockOut(): RedirectResponse
    {
        Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->update(['clock_out_at' => now()]);

        return back()->with('status', 'Clock-out recorded.');
    }
}
