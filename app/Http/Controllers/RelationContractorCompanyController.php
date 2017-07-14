<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;
use App\Models\Company;
use App\Models\RelationContractorCompany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class RelationContractorCompanyController extends Controller
{
    
    protected $access = [
        'relation' => ['manager'],
        'relationList' => ['manager'],
        'relationCreate' => ['manager'],
        'relationDelete' => ['manager'],
    ];
    
    public function relation(Request $request)
    {
        return view('contractor.company_relation', [
            'id' => $request->id,
            'contractors' => Contractor::all(),
            'companies' => Company::all(),
        ]);
    }

    public function relationList(Request $request)
    {
        if (!$request->ajax()) {
            return  response()->json([
                'success' => false,
            ]);
        }
        
        $relationContractorCompany = RelationContractorCompany::with(['company', 'contractor.contact'])
            ->where([
                'company_id' => $request->id,
            ])
            ->get();

        if (empty($relationContractorCompany)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => $relationContractorCompany,
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
            'company_id' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $relationContractorCompany = RelationContractorCompany::where([
                'contractor_id' => $request->contractor_id,
                'company_id' => $request->company_id,
            ])
            ->first();
        
        if (empty($relationContractorCompany)) {
            $relationContractorCompany = new RelationContractorCompany();
            $relationContractorCompany->contractor_id = $request->contractor_id;
            $relationContractorCompany->company_id = $request->company_id;
            $relationContractorCompany->disided = $request->disided;
            $relationContractorCompany->save();
        }
    }

    public function relationDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        RelationContractorCompany::where([
            'contractor_id' => $request->contractor_id,
            'company_id' => $request->company_id,
        ])
        ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
