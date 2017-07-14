<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractorHobbie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ContractorHobbieController extends Controller
{

    protected $access = [
        'hobbieList' => ['manager'],
        'hobbieSave' => ['manager'],
        'hobbieDelete' => ['manager'],
    ];

    public function hobbieList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => ContractorHobbie::with(['hobbie'])
                ->where([
                    'contractor_id' => $request->id
                ])
                ->get(),
        ]);
    }

    public function hobbieSave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'contractor_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        if (empty($request->id)) {
            $hobbie = new ContractorHobbie();
        } else {
            $hobbie = ContractorHobbie::where([
                    'id' => $request->id
                ])
                ->first();
        }
        $hobbie->unguard();
        $hobbie->fill(Input::except(['_token', 'id']));
        $hobbie->save();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function hobbieDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        ContractorHobbie::where(['id' => $request->id])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
