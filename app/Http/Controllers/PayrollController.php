<?php

namespace App\Http\Controllers;

use App\Models\PayrollSummary;
use Illuminate\View\View;

class PayrollController extends Controller
{
    public function index(): View
    {
        return view('payroll.index', [
            'entries' => PayrollSummary::where('user_id', auth()->id())->latest('month')->get(),
        ]);
    }
}
