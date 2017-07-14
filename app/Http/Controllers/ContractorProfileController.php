<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contractor;
use App\Models\Company;
use App\Models\Region;
use App\Models\ContractorActivities;
use App\Models\ContractorGroup;
use App\Models\ContractorCompany;
use App\Models\ContractorContacts;
use App\Models\Task;
use App\Models\Order;
use App\Models\Role;
use App\Models\Gender;
use App\Models\Hobbie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Models\AgrorotationUnit;
use App\Models\Chemical;
use App\Models\User;
use App\Models\AgrorotationDate;
use Illuminate\Support\Facades\DB;

class ContractorProfileController extends Controller
{
    
    protected $access = [
        'index' => ['manager'],
        'companyContactSave' => ['manager'],
        'contractorContactSave' => ['manager'],
        'companyRequisiteSave' => ['manager'],
        'history' => ['manager'],
    ];

    public function index(Request $request)
    {
        if ($request->type == 'user') {
            $user = Contractor::with(['contact', 'companies'])
                ->where([
                    'id' => $request->userId,
                ])
                ->first();

            if (!empty($user)) {
                $lastTask = Task::whereIn('task_status_id', [1, 2])
                    ->where('contractor_type', Contractor::class)
                    ->where('contractor_id', $request->userId)
                    ->orderBy('id', 'DESC')
                    ->first();
                        
                if(empty($lastTask)) {
                    $lastTask = Task::whereIn('task_status_id', [1, 2])
                        ->where('contractor_type', Company::class)
                        ->where('contractor_id', $user->companies->first()->id)
                        ->orderBy('id', 'DESC')
                        ->first();
                }
                
                return view('contractor_profile.user', [
                    'user' => $user,
                    'id' => $request->userId,
                    'companies' => Company::all(),
                    'contractorGroups' => ContractorGroup::all(),
                    'contractorActivities' => ContractorActivities::all(),
                    'regions' => Region::all(),
                    'genders' => Gender::all(),
                    'hobbies' => Hobbie::all(),
                    'lastTask' => $lastTask,
                ]);
            }
        } elseif ($request->type == 'company') {
            $user = Company::with(['contact', 'contractors'])
                ->where([
                    'id' => $request->userId,
                ])
                ->first();

//            if (!empty($user)) {
//                $current_date = DB:: table ('agrorotation_dates') -> select (DB::raw('MAX(date) as date')) -> where ('date', '<', DB:: raw ('DATE(NOW())')) -> get();
//                $current_date = date ('d.m.Y', (strtotime($current_date[0]->date)));


                return view('contractor_profile.company', [
                    'user' => $user,
                    'id' => $request->userId,
                    'companies' => Company::all(),
                    'contractorGroups' => ContractorGroup::all(),
                    'contractorActivities' => ContractorActivities::all(),
                    'regions' => Region::all(),
                    'units' => AgrorotationUnit::all(),
                    'agrorotation_dates' => AgrorotationDate::all(),
//                    'current_date' => $current_date,
                    'chemicals' => Chemical::all(),
                    'sellers' => User::all(),
                    'lastTask' => Task::where([
                            'contractor_type' => Company::class,
                            'contractor_id' => $request->userId,
                        ])
                        ->whereIn('task_status_id', [1, 2])
                        ->orderBy('id', 'DESC')
                        ->first(),
                ]);
            }
//        }

        return  response()->json([
            'success' => false,
        ]);
    }

    public function companyContactSave(Request $request)
    {
        if (!$request->ajax()) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            // 'name' => 'required',
            // 'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $company = Company::with('contact')
            ->where(['id' => $request->id])
            ->first();
        if (empty($company)) {
            return  response()->json([
                'success' => false,
            ]);
        }
        $company->unguard();

        $data = Input::only([
            'is_buyer',
            'is_supplier',
            'is_not_residend',
            'contractor_group_id',
            'name',
            'full_name',
            'inn',
            'code_egrpou',
            'number_vat',
            'contractor_activity_id'
        ]);
        $data['is_buyer'] = (!empty($data['is_buyer'])) ? 1 : 0;
        $data['is_supplier'] = (!empty($data['is_supplier'])) ? 1 : 0;
        $data['is_not_residend'] = (!empty($data['is_not_residend'])) ? 1 : 0;
//        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $res = $company->update($data);

        $company->contact->unguard();
        $dataContact = $request->contact;
        $dataContact['confirmed'] = $dataContact['confirmed'] = (!empty($dataContact['confirmed'])) ? 1 : 0;
        if (!$company->contact->exists) {
            $company->contact->create((array) $dataContact);
        } else {
            $company->contact->update((array) $dataContact);
        }
    }
    
    public function contractorContactSave(Request $request)
    {
        if (!$request->ajax()) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            // 'name' => 'required',
            // 'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $company = Contractor::with('contact')
            ->where(['id' => $request->id])
            ->first();
        if (empty($company)) {
            return  response()->json([
                'success' => false,
            ]);
        }
        $company->unguard();

        $data = Input::except([
            '_token',
            'contact'
        ]);
        $data['is_buyer'] = (!empty($data['is_buyer'])) ? 1 : 0;
        $data['is_supplier'] = (!empty($data['is_supplier'])) ? 1 : 0;
        $data['is_not_residend'] = (!empty($data['is_not_residend'])) ? 1 : 0;
        $data['birthday'] = date('Y-m-d', strtotime($data['birthday']));
        $res = $company->update($data);

        $company->contact->unguard();
        $dataContact = $request->contact;
        $dataContact['confirmed'] = $dataContact['confirmed'] = (!empty($dataContact['confirmed'])) ? 1 : 0;
        if (!$company->contact->exists) {
            $company->contact->create((array) $dataContact);
        } else {
            $company->contact->update((array) $dataContact);
        }

        return  response()->json([
            'success' => true,
        ]);
    }

    public function companyRequisiteSave(Request $request)
    {
        if (!$request->ajax()) {
            return  response()->json([
                'success' => false,
                'errors' => [
                    'Response not by ajax',
                ],
            ]);
        }

        $validator = Validator::make(Input::all(), [
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $company = Company::with('contact')
            ->where(['id' => $request->id])
            ->first();
        if (empty($company)) {
            return  response()->json([
                'success' => false,
                'errors' => [
                    'id' => 'Company not found',
                ],
            ]);
        }
        $company->unguard();

        $data = Input::except([
            '_token',
            'contact',
            'date',
        ]);
        $res = $company->update($data);

        if(empty($company->contact)) {
            $company->contact = new ContractorContacts();
        }
        
        $company->contact->unguard();   
        if (!$company->contact->exists) {
            $company->contact->create((array) $request->contact);
        } else {
            $company->contact->update((array) $request->contact);
        }

        return  response()->json([
            'success' => true,
        ]);
    }

    public function history(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $type = '';
        if($request->type == 'user') {
            $type = 'App\Models\Contractor';
        }
        elseif ($request->type == 'company') {
            $type = 'App\Models\Company';
        }

        $tasks = Task::where(['contractor_id' => $request->id, 'contractor_type' => $type])->get()->toArray();
        foreach ($tasks as $key => $item) {
            $tasks[$key]['type'] = 'task';
        }
        $orders = Order::where(['contractor_id' => $request->id, 'contractor_type' => $type])->get()->toArray();
        foreach ($orders as $key => $item) {
            $orders[$key]['type'] = 'order';
        }

        $res = array_merge($tasks, $orders);
        return  response()->json([
            'success' => true,
            'data' => $res,
        ]);
    }
}
