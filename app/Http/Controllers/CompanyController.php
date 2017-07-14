<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Company;
use App\Models\ContractorActivities;
use App\Models\ContractorContacts;
use App\Models\Task;
use App\Models\User;
use App\Models\RelationUserCompany;

class CompanyController extends Controller
{

    protected $access = [
        'index' => ['manager'],
        'companyList' => ['manager'],
        'companyAll' => ['manager'],
        'companySave' => ['manager'],
        'companyDelete' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('company.index', [
            'activities' => ContractorActivities::all(),
        ]);
    }

    public function companyList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $companies = Company::getByManager (Auth::user()->id, 
            $request->groupId)
//            ->where('name', 'like', "%{$request->q}%")
            ->paginate(Config::get('app.limit'));
        
        return response()->json($companies);
    }
    
    public function companyAll(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        if(empty($request->q)) {
            $companies = Company::all();
        } else {
            $companies = Company::where('name', 'like', "%{$request->q}%")
                ->get();
        }
        return response()->json([
            'data' => $companies,
        ]);
    }
    
    public function companySave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        $validator = Validator::make(Input::all(), [
            'name' => 'required',
            'contact.phone' => 'required',
            'contact.email' => 'email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        if (empty($request->id)) {
            $company = new Company();
        } else {
            $company = Company::where([
                    'id' => $request->id
                ])
                ->first();
        }
        $company->unguard();
        $company->fill(Input::except(['_token', 'type', 'contact', 'task_id']));
        $company->save();
        
        $userRelation = RelationUserCompany::where([
                'user_id' => Auth::user()->id,
                'company_id' => $company->id,
            ])
            ->first();
        if(empty($userRelation)) {
            $userRelation = new RelationUserCompany();
        }
        
        $userRelation->user_id = Auth::user()->id;
        $userRelation->company_id = $company->id;
        $userRelation->save();
        
        $contracorContact = ContractorContacts::where([
               'contact_id' => $company->id,
               'contact_type' => Company::class,
           ])
           ->first();

        if (empty($contracorContact)) {
            $contracorContact = new ContractorContacts();   
        }
        
        $contracorContact->unguard();
        $contracorContact->fill(array_merge($request->contact, [
            'contact_id' => $company->id, 
            'contact_type' => Company::class,
        ]));
        $contracorContact->save();
        
        if(!empty($request->task_id)) {
            $task = Task::where(['id' => $request->task_id])
                ->first();
            $task->contractor_id = $company->id;
            $task->contractor_type = Company::class;
            $task->save();
            
            return  response()->json([
                'success' => true,
                'redirect' => "/task/view/{$task->id}",
            ]);
            
        }
        return response()->json([
            'success' => true,
            'data' => $company,
        ]);
        
    }

    public function companyDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $company = Company::where([
                'id' => $request->id
            ])
            ->delete();

        return  response()->json([
            'success' => true,
        ]);
    }
}
