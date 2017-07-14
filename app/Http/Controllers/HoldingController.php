<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Holding;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class HoldingController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'holdingList' => ['manager'],
        'holdingCreate' => ['manager'],
        'holdingUpdate' => ['manager'],
        'holdingDelete' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('holding.index');
    }

    public function holdingList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => Holding::get(),
        ]);
    }

    public function holdingCreate(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $holding = new Holding();
        $holding->ext_id = $request->ext_id;
        $holding->name = $request->name;
        $holding->save();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function holdingUpdate(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $holding = Holding::where([
                'id' => $request->id
            ])
            ->first();

        if (empty($holding)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $holding->ext_id = $request->ext_id;
        $holding->name = $request->name;
        $holding->save();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function holdingDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $holding = Holding::where([
                'id' => $request->id
            ])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
