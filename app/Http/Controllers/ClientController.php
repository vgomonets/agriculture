<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractorGroup;
use App\Models\ContractorActivities;
use App\Models\Region;

class ClientController extends Controller
{
    
    protected $access = [
        'index' => ['manager'],
    ];

    public function index(Request $request)
    {
        return view('client.index', [
            'activities' => ContractorActivities::all(),
        ]);
    }
}
