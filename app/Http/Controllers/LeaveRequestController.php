<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaveRequestController extends Controller
{
    public function index(): View
    {
        return view('leave.index', [
            'requests' => LeaveRequest::where('user_id', auth()->id())->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'max:500'],
        ]);

        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        LeaveRequest::create($data);

        return back()->with('status', 'Leave request submitted.');
    }
}
