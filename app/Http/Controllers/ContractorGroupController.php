<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContractorGroup;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ContractorGroupController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'contractorGroupList' => ['manager'],
        'contractorGroupSave' => ['manager'],
        'contractorGroupDelete' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('contractor_group.index', [
            'groupId' => $request->groupId
        ]);
    }

    public function contractorGroupList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => ContractorGroup::get(),
        ]);
    }

    public function contractorGroupSave(Request $request)
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
            $contractor_group = new ContractorGroup();
        } else {
            $contractor_group = ContractorGroup::where([
                    'id' => $request->id
                ])
                ->first();
        }

        if (empty($contractor_group)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $contractor_group->ext_id = $request->ext_id;
        $contractor_group->name = $request->name;
        $contractor_group->save();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function contractorGroupDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $contractor_group = ContractorGroup::where([
                'id' => $request->id
            ])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
