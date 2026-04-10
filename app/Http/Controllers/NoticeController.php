<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\View\View;

class NoticeController extends Controller
{
    public function index(): View
    {
        return view('notices.index', [
            'notices' => Notice::latest('published_at')->get(),
        ]);
    }
}
