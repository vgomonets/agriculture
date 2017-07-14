<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\TaskPriority;
use App\Models\User;
use App\Models\Contractor;
use App\Models\Company;
use App\Models\TaskCloseCondition;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RelationTasksTaskCloseCondition;

use App\Http\Requests;

class TaskController extends Controller
{
    
    protected $access = [
        'index' => ['manager'],
        'taskList' => ['manager'],
        'saveTaskPersonal' => ['manager'],
        'saveTaskGroup' => ['manager'],
        'taskSave' => ['manager'],
        'taskDelete' => ['manager'],
        'taskCheckin' => ['manager'],
    ];
    
    public function index(Request $request)
    {
        return view('task.index', [
            'taskGroups' => TaskGroup::all(),
            'taskPriorities' => TaskPriority::all(),
            'taskCloseConditions' => TaskCloseCondition::all(),
            'users' => User::all(),
            'contractors' => Contractor::all(),
            'statuses' => TaskStatus::all(),
        ]);
    }

    public function taskList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $where = [];
        if (!empty($request->group_id)) {
            $where['group_id'] = $request->group_id;
        }
        if (!empty($request->contractor_id)) {
            $where['contractor_id'] = $request->contractor_id;
        }
        $task = Task::where($where);
        
        // Task by roles
        $user = Auth::user();
        
        if (empty($request->task_status_id)) {
            $task->whereIn('task_status_id', [1, 2]);
        } else {
            $task->where('task_status_id', $request->task_status_id);
        }
        
        if($user->hasRole('admin') || $user->hasRole('head')) {
            // Все задачи
        } else {
            // Если задача назначена на пользователя или он создал задачу
            $task->where(function($query) use($user) {
                $query->where('creator_id', $user->id);
                $query->orWhere('executor_id', $user->id);
            });
        }

        if (!empty($request->date)) {
            $date = strtotime($request->date);
            $task->where(DB::raw("DATE_FORMAT(taking_date, '%Y-%m')"), '<=', DB::raw("'" . date('Y-m', $date) . "'"));
            $task->where(DB::raw("DATE_FORMAT(execution_date, '%Y-%m')"), '>=', DB::raw("'" . date('Y-m', $date) . "'"));
        }
        $tasks = $task->with(['status', 'closeConditions', 'executor', /*'contractor'*/])->get();

        return response()->json([
            'data' => $tasks,
        ]);
    }

    /**
     * Персональная задача
     * @param  Request $request
     */
    private function saveTaskPersonal(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'personal.title' => 'required',
        ]);
        
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data = array_merge($request->personal, [
            'id' => $request->id,
            'contractor_id' => $request->contractor_id,
        ]);
        if(!empty($request->personal['executor_id'])) {
            $data['executor_id'] = $request->personal['executor_id'];
        } else {
            unset($data['executor_id']);
        }
        if($request->contractor_type == 'contractor') {
            $data['contractor_type'] = 'App\Models\Contractor';
        } elseif ($request->contractor_type == 'company') {
            $data['contractor_type'] = 'App\Models\Company';
        }
        if(!empty($request->personal['execution_date'])) {
            $data['execution_date'] = date('Y-m-d H:i:s', strtotime($request->personal['execution_date']));
        } else {
            unset($data['execution_date']);
        }
        if(!empty($request->personal['taking_date'])) {
            $data['taking_date'] = date('Y-m-d H:i:s', strtotime($request->personal['taking_date']));
        } else {
            unset($data['taking_date']);
        }
        $task = Task::saveTask($data);
        
        RelationTasksTaskCloseCondition::where('task_id', $task->id)
            ->delete();
        
        foreach((array) $request->task_close_conditions as $condition) {
            if(!empty($condition)) {
                $date = date('Y-m-d H:i:s');
                RelationTasksTaskCloseCondition::insert([
                    'task_id' => $task->id, 
                    'task_close_condition_id' => $condition,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Задача из шаблона
     * @param  Request $request
     */
    private function saveTaskGroup(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'group.group_id' => ['required', 'integer', 'min:1'],
        ]);
        
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        }
        
        $data = [
            'group_id' => $request->group['group_id'],
            'contractor_id' => $request->contractor_id,
        ];
        if(!empty($request->group['executor_id'])) {
            $data['executor_id'] = $request->group['executor_id'];
        }
        
        if($request->contractor_type == 'contractor') {
            $data['contractor_type'] = Contractor::class;
        } elseif ($request->contractor_type == 'company') {
            $data['contractor_type'] = Company::class;
        }
        
        if(!empty($request->group['execution_date'])) {
            $data['execution_date'] = date('Y-m-d H:i:s', strtotime($request->group['execution_date']));
        } else {
            unset($data['execution_date']);
        }
        if(!empty($request->group['taking_date'])) {
            $data['taking_date'] = date('Y-m-d H:i:s', strtotime($request->group['taking_date']));
        } else {
            unset($data['taking_date']);
        }
        
        $task = Task::saveTaskGroup($data);
        foreach((array) $request->task_close_conditions as $condition) {
            if(!empty($condition)) {
                $date = date('Y-m-d H:i:s');
                RelationTasksTaskCloseCondition::insert([
                    'task_id' => $task->id, 
                    'task_close_condition_id' => $condition,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function taskSave(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        if ($request->type == 'personal') {
            return $this->saveTaskPersonal($request);
        } elseif ($request->type == 'group') {
            return $this->saveTaskGroup($request);
        }

        return response()->json(
            [
                'success' => true,
            ]
        );
    }
    
    public function taskDelete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $task = Task::where(
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
    
    public function taskCheckin(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        $task = Task::where('id', '=', $request->id)
            ->first();
        $task->latitude = $request->latitude;
        $task->longitude = $request->longitude;
        $task->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
