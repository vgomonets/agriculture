<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CalendarController extends Controller
{

    protected $access = [
        'index' => ['manager']
    ];
    
    public function index(Request $request)
    {
        return view('calendar.index', [
            'taskStatuses' => TaskStatus::all(),
        ]);
    }
}
