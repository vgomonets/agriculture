<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ContractorFamilyController extends Controller
{

    protected $access = [
        'familyList' => ['manager'],
        'familySave' => ['manager'],
        'familyDelete' => ['manager'],
    ];

    public function familyList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => Family::with(['gender', 'type'])
                ->where([
                    'contractor_id' => $request->id
                ])
                ->get(),
        ]);
    }

    public function familySave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'contractor_id' => 'required',
            'name' => 'required',
            'birthday' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        if (empty($request->id)) {
            $family = new Family();
        } else {
            $family = Family::where([
                    'id' => $request->id
                ])
                ->first();
        }
        $data = Input::except(['_token', 'id']);
        $data['birthday'] = date('Y-m-d', strtotime($data['birthday']));
        
        $family->unguard();
        $family->fill($data);
        $family->save();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function familyDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        Family::where(['id' => $request->id])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
