<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contractor;
use App\Models\ContractorContacts;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use App\Models\Task;
use App\Models\RelationContractorCompany;
use App\Models\RelationUserContractor;

class ContractorController extends Controller
{
    
    protected $access = [
        'index' => ['manager'],
        'contractorList' => ['manager'],
        'contractorAll' => ['manager'],
        'contractorSave' => ['manager'],
        'contractorDelete' => ['manager'],
    ];

    public function index(Request $request)
    {
        return view('contractor.index');
    }

    public function contractorList (Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $res = [];

        $contractors = Contractor::getByManager (Auth::user()->id, 
            $request->groupId)
            ->with(['relationCompanies'])
//            ->where('name', 'like', "%{$request->q}%")
            ->paginate(Config::get('app.limit'));
        
        return response()->json($contractors);
    }

    public function contractorAll(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        if(empty($request->q)) {
            $contractors = Contractor::all();
        } else {
            $contractors = Contractor::where('name', 'like', "%{$request->q}%")
                ->get();
        }
        return response()->json([
            'data' => $contractors,
        ]);
    }

    public function contractorSave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        $user = Auth::user();

        $validator = Validator::make(Input::all(), [
            'name' => 'required',
            'relation_companies.*.company_id' => 'required',
            'relation_companies.*.disided' => 'required',
            'contact.phone' => 'required',
            'contact.email' => 'email',
//            'company_typeahead'
        ]);
        $validator->setAttributeNames([
            'relation_companies.0.company_id' => 'Компания',
        ]); 

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        if (empty($request->id)) {
            $contractor = new Contractor();
        } else {
            $contractor = Contractor::where([
                    'id' => $request->id
                ])
                ->first();
        }
        $contractor->unguard();
        $contractor->fill(Input::except(['_token', 'type', 'contact', 'task_id', 'relation_companies', 'undefined', 'company']));
        $contractor->save();
        
        $userRelation = RelationUserContractor::where([
            'user_id' => Auth::user()->id,
            'contractor_id' => $contractor->id,
        ])->first();
        if(empty($userRelation)) {
            $userRelation = new RelationUserContractor();
        }
        $userRelation->user_id = Auth::user()->id;
        $userRelation->contractor_id = $contractor->id;
        $userRelation->save();
        
        if (empty($request->id)) {
            // Attach contractor to company
            foreach($request->relation_companies as $company) {
                RelationContractorCompany::where([
                        'contractor_id' => $contractor->id,
                        'company_id' => $company['company_id'],
                    ])
                    ->delete();
                
                RelationContractorCompany::insert([
                        'contractor_id' => $contractor->id,
                        'company_id' => $company['company_id'],
                        'disided' => $company['disided'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
        }
        
        $contracorContact = ContractorContacts::where([
               'contact_id' => $contractor->id,
               'contact_type' => Contractor::class,
           ])
           ->first();
        
        if (empty($contracorContact)) {
            $contracorContact = new ContractorContacts();   
        }
        
        $contracorContact->unguard();
        $contracorContact->fill(array_merge($request->contact, [
            'contact_id' => $contractor->id, 
            'contact_type' => Contractor::class,
        ]));
        $contracorContact->save();
        
        //add contractor to task
        if(!empty($request->task_id)) {
            $task = Task::where(['id' => $request->task_id])
                ->first();
            $task->contractor_id = $contractor->id;
            $task->contractor_type = Contractor::class;
            $task->save();
            
            return  response()->json([
                'success' => true,
                'redirect' => "/task/view/{$task->id}",
            ]);
        }

        return  response()->json([
            'success' => true,
        ]);
    }

    public function contractorDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        Contractor::where([
            'id' => $request->id
        ])
        ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
