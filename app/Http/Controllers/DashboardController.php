<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\SecurityEvent;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard.index', [
            'employeeCount' => User::count(),
            'presentToday' => Attendance::whereDate('work_date', today())->whereNotNull('clock_in_at')->count(),
            'openLeaves' => LeaveRequest::where('status', 'pending')->count(),
            'recentSecurityEvents' => SecurityEvent::latest()->take(5)->get(),
        ]);
    }
}
