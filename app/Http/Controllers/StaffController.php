<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class StaffController extends Controller
{

    protected $access = [
        'users' => ['manager'],
        'usersList' => ['manager'],
        'userSave' => ['manager'],
        'profile' => ['manager'],
        'userAll' => ['manager'],
    ];
    
    public function users(Request $request)
    {
        return view('staff.users', [
            'regions' => Region::all(),
            'roles' => Role::all()
        ]);
    }

    public function usersList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return  response()->json([
            'data' => User::with([
                'roles',
                'region'
            ])
            ->get(),
        ]);
    }

    public function userSave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'name' => 'required|max:255',
            'email' => "required|email|unique:users,email,{$request->id}|max:255",
            'region_id' => 'required',
            'role_id' => 'required',
            'phone' => 'required',
            'password' => 'required_without:id|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        if (empty($request->id)) {
            $user = new User();
        } else {
            $user = User::where([
                'id' => $request->id
            ])
                ->first();
        }

        if (empty($user)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->region_id = $request->region_id;
        $user->phone = $request->phone;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->roles()->associate(Role::find($request->role_id));

        return  response()->json([
            'success' => true,
        ]);
    }


    public function profile(Request $request)
    {
        $user = User::where([
                'id' => $request->userId,
            ])
            ->first();

        if (empty($user)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        return view('staff.profile', [
            'user' => $user,
        ]);
    }

    public function userAll(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        if(empty($request->q)) {
            $users = User::all();
        } else {
            $users = User::where('name', 'like', "%{$request->q}%")
                ->get();
        }

        return response()->json([
            'data' => $users,
        ]);
    }
}
