<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessAction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class BusinessActionsController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'actionsList' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('business.actions.index');
    }

    public function actionsList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => BusinessAction::all(),
        ]);
    }
}
