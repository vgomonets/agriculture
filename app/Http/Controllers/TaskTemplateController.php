<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessAction;
use Illuminate\Support\Facades\Config;
use App\Models\TaskTemplate;
use App\Models\Role;
use App\Models\TaskGroup;
use App\Models\TaskCloseCondition;
use App\Models\TaskStage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class TaskTemplateController extends Controller
{
    
    protected $access = [
        'index' => ['manager'],
        'taskTemplateList' => ['manager'],
        'taskTemplateSave' => ['manager'],
        'taskTemplateDelete' => ['manager'],
        'taskTemplateGetNext' => ['manager'],
        'taskTemplateOrder' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('task_template.index', [
            'taskGroups' => TaskGroup::all(),
            'taskCloseConditions' => TaskCloseCondition::all(),
            'roles' => Role::all(),
            'group_id' => $request->group_id,
            'stages' => TaskStage::all(),
            'businessActions' => BusinessAction::all(),
        ]);
    }

    public function taskTemplateList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        if (!empty($request->group_id)) {
            $taskTemplates = TaskTemplate::with(['group', 'role'])
                ->where(['group_id' => $request->group_id])
                ->orderBy('order', 'ASC');
        } else {
            $taskTemplates = TaskTemplate::with(['group', 'role'])
                ->orderBy('order', 'ASC');
        }

        return response()->json($taskTemplates->paginate(Config::get('app.limit')));
    }

    public function taskTemplateSave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data = Input::except([
            '_token',
            'limit_type',
        ]);
        
        if(!empty($request->contractor_required)) {
            $data['contractor_required'] = 1;
        } else {
            $data['contractor_required'] = 0;
        }

        if ($request->limit_type == 'd') {
            $data['hour_limit'] = 24 * $data['hour_limit'];
        }

        if (empty($request->id)) {
            $task_template = new TaskTemplate();
            $task_template->unguard();
            $task_template->create($data);
        } else {
            $task_template = TaskTemplate::where(['id' => $request->id])
                ->first();
            $task_template->unguard();
            $res = $task_template->update($data);
        }

        return response()->json(
            [
                'success' => true,
            ]
        );
    }

    public function taskTemplateDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $task_template = TaskTemplate::where(
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

    public function taskTemplateGetNext(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return response()->json(
            [
                'success' => true,
                'data' => TaskTemplate::getNextTemplateForTask($request->task_id),
            ]
        );
    }
    
    public function taskTemplateOrder(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        foreach($request->order as $order) {
            TaskTemplate::where(['id' => $order['id']])
                ->update(['order' => $order['order']]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
