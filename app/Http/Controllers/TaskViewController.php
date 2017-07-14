<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Task;
use App\Models\Role;
use App\Models\TaskGroup;
use App\Models\TaskPriority;
use App\Models\TaskTemplate;
use App\Models\TaskCloseCondition;
use App\Models\TaskStatus;
use App\Models\Contractor;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

class TaskViewController extends Controller
{

    protected $access = [
        'taskViewIndex' => ['manager'],
        'taskViewSave' => ['manager'],
        'taskViewCancel' => ['manager'],
        'taskViewFinish' => ['manager'],
        'taskViewStatus' => ['manager'],
    ];
    
    public function taskViewIndex(Request $request)
    {
        $task = Task::with('group')
            ->where(['id' => $request->id])
            ->first();
        
        return view('task_view.index', [
            'task' => $task,
            'taskGroups' => TaskGroup::all(),
            'taskPriorities' => TaskPriority::all(),
            'taskCloseConditions' => TaskCloseCondition::all(),
            'taskStatuses' => TaskStatus::all(),
            'nextTaskTemplate' => TaskTemplate::getNextTemplateForTask($request->id),
            'taskTemplate' => TaskTemplate::where(['id' => $task->template_id])->first(),
            'roles' => Role::all(),
            'contractors' => Contractor::all(),
            'companies' => Company::all(),
            'users' => User::all(),
        ]);
    }

    public function taskViewSave(Request $request)
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
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray(),
                ]
            );
        }
        
        Task::saveTask(Input::except('_token'));

        return response()->json([
            'success' => true,
        ]);
    }

    public function taskViewCancel(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validator = Validator::make(Input::all(), [
            'id' => 'required',
            'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray(),
                ]
            );
        }

        Task::saveTask(array_merge(Input::except('_token'), [
            'task_status_id' => 4,
        ]));

        return response()->json([
            'success' => true,
        ]);
    }


    public function taskViewFinish(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        $validator = Validator::make(Input::all(), [
                'id' => 'required',
                'new_taking_date' => 'required_if:after_finish,restart',
                'comment' => 'required_if:after_finish,break',
            ], [
                'required_if' => 'Поле :attribute обязательно для заполнения',
            ]);
        $validator->setAttributeNames([
            'new_taking_date' => 'Дата переноса',
            'after_finish' => 'После завершения',
            'comment' => 'Комментарий',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        }
        
        $task = Task::where(['id' => $request->id])->first();
        
        // если не 'restart', 'break'
        if(!in_array($request->after_finish, ['restart', 'break'])) {
            // Проверить выполнение бизнес процессов
            if(!$task->checkBusinessAction()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['after_finish' => $task->getBusinessActionErrors()],
                ]);
            }
            
            // Если требуется checkin
            if($request->task_close_condition_id == 2 && empty($task->latitude) && empty($task->longitude)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['after_finish' => ['Для завершения задачи требуется отметиться на месте']],
                ]);
            }
        }
        
        $currentTaskTemplate = TaskTemplate::where(['id' => $task->template_id])
            ->first();
        
        // дата завершения для текущей задачи
        if(!empty($request->new_finish_date)) {
            $execution_date = $request->new_finish_date;
        } else {
            $execution_date = $task->execution_date;
        }
        
        if ($request->after_finish == 'next') { // Cоздать следующую задачу
            $next = TaskTemplate::getNextTemplateForTask($task->id);
            $newTask = Task::addGroupTaskByTemplateId([
                'group_id' => $task->group_id,
                'contractor_id' => $task->contractor_id,
                'contractor_type' => $task->contractor_type,
                'chain' => $task->chain,
                'execution_date' => date('Y-m-d H:i:s', strtotime($execution_date) + 1 * 60 * 60),
                'taking_date' => date('Y-m-d H:i:s', strtotime($execution_date)),
            ], $next->id);

        } elseif ($request->after_finish == 'restart') { // Создать эту же задачу
            $newTask = Task::addGroupTaskByTemplateId([
                'group_id' => $task->group_id,
                'contractor_id' => $task->contractor_id,
                'contractor_type' => $task->contractor_type,
                'chain' => $task->chain,
                'execution_date' => date('Y-m-d H:i:s', strtotime($request->new_taking_date) + 1 * 60 * 60),
                'taking_date' => date('Y-m-d H:i:s', strtotime($request->new_taking_date)),
            ], $task->template_id);
        }
        
        // Завершить задачу
        Task::saveTask([
            'id' => $request->id,
            'task_status_id' => 5,
            'comment' => $request->comment,
            'execution_date' => date('Y-m-d H:i:s', strtotime($execution_date)),
            'taking_date' => date('Y-m-d H:i:s', strtotime($execution_date) - 1 * 60 * 60),
        ]);

        if(!empty($newTask)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'task_id' => $newTask->id,
                ]
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
    
    public function taskViewStatus(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        $validator = Validator::make(Input::all(), [
            'id' => 'required',
            'task_status_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        }
        
        $task = Task::where(['id' => $request->id])->first();
        $task->task_status_id = $request->task_status_id;
        $task->save();
        
        return response()->json([
            'success' => true,
        ]);
    }
}
