<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContractorActivities;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ContractorActivityController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'contractorActivityList' => ['manager'],
        'contractorActivitySave' => ['manager'],
        'contractorActivityDelete' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('contractor_activity.index');
    }

    public function contractorActivityList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => ContractorActivities::get(),
        ]);
    }

    public function contractorActivitySave(Request $request)
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

        if (empty($request->id)) {
            $contractor_activity = new ContractorActivities();
        } else {
            $contractor_activity = ContractorActivities::where([
                    'id' => $request->id
                ])
                ->first();
        }

        if (empty($contractor_activity)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $contractor_activity->name = $request->name;
        $contractor_activity->save();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function contractorActivityDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $contractor_activity = ContractorActivities::where([
                'id' => $request->id
            ])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
