<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\TaskGroup;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

class TaskGroupController extends Controller
{
    
    protected $access = [
        'index' => ['manager'],
        'taskGroupList' => ['manager'],
        'taskGroupSave' => ['manager'],
        'taskGroupDelete' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('task_group.index');
    }

    public function taskGroupList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return response()->json(
            [
                'data' => TaskGroup::get(),
            ]
        );
    }

    public function taskGroupSave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(
            Input::all(),
            [
                'name' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray(),
                ]
            );
        }

        if (empty($request->id)) {
            $task_group = new TaskGroup();
            $task_group->unguard();
            $task_group->create(Input::only('name'));
        } else {
            $task_group = TaskGroup::where(['id' => $request->id])
                ->first();
            $task_group->unguard();
            $task_group->update(Input::only('name'));
        }

        return response()->json(
            [
                'success' => true,
            ]
        );
    }

    public function taskGroupDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $task_group = TaskGroup::where(
            [
                'id' => $request->id,
            ]
        )->delete();

        return response()->json(
            [
                'success' => true,
            ]
        );
    }
}
