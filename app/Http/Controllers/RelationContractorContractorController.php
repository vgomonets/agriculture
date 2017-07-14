<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;
use App\Models\Company;
use App\Models\RelationContractorContractor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class RelationContractorContractorController extends Controller
{
    
    protected $access = [
        'relation' => ['manager'],
        'relationList' => ['manager'],
        'relationCreate' => ['manager'],
        'relationDelete' => ['manager'],
    ];
    
    public function relation(Request $request)
    {
        
        return view('contractor.user_relation', [
            'id' => $request->id,
            'contractors' => Contractor::all(),
            //'companies' => Company::all(),
        ]);
    }

    public function relationList(Request $request)
    {
        if (!$request->ajax()) {
            return  response()->json([
                'success' => false,
            ]);
        }
        
        $relationContractorContractor = RelationContractorContractor
            ::with(['contractorParent', 'contractor.contact'])
            ->where([
                'parent_contractor_id' => $request->id,
            ])
            ->get();

        if (empty($relationContractorContractor)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => $relationContractorContractor,
        ]);
    }

    public function relationCreate(Request $request)
    {
        if (!$request->ajax()) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'contractor_id' => 'required|integer|min:0',
            'parent_contractor_id' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $relationContractorContractor = RelationContractorContractor::where([
                'contractor_id' => $request->contractor_id,
                'parent_contractor_id' => $request->parent_contractor_id,
            ])
            ->first();
        
        if (empty($relationContractorContractor)) {
            $relationContractorContractor = new RelationContractorContractor();
            $relationContractorContractor->contractor_id = $request->contractor_id;
            $relationContractorContractor->parent_contractor_id = $request->parent_contractor_id;
            $relationContractorContractor->disided = $request->disided;
            $relationContractorContractor->save();
        }

        return  response()->json([
            'success' => true,
        ]);
    }


    public function relationDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        RelationContractorContractor::where([
            'contractor_id' => $request->contractor_id,
            'parent_contractor_id' => $request->parent_contractor_id,
        ])
        ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
