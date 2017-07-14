<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Nomenclatura;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class NomenclaturaController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'nomenclaturaList' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }
        return view('nomenclatura.index');
    }

    public function nomenclaturaList(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => Nomenclatura::getAll(),
        ]);
    }
}
