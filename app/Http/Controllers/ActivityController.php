<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Contractor;
use App\Models\Company;
use App\Models\Order;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Models\TaskGroup;
use App\Models\TaskPriority;
use App\Models\TaskCloseCondition;
use App\Models\User;
use App\Models\TaskStatus;

class ActivityController extends Controller
{
    protected $access = [
        'index' => ['manager']
    ];

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        return view('activity.index', [
            'expiredTasks' => Task::exptiredTasksCountByUserId($user_id),
            'todayTasks' => Task::todayTasksCountByUserId($user_id),
            'clients' => Contractor::countByUserId($user_id) 
                + Company::countByUserId($user_id),
            'inProcessTasks' => Task::inProcessTasksCountByUserId($user_id),
            
            'taskGroups' => TaskGroup::all(),
            'taskPriorities' => TaskPriority::all(),
            'taskCloseConditions' => TaskCloseCondition::all(),
            'users' => User::all(),
            'contractors' => Contractor::all(),
            'statuses' => TaskStatus::all(),
        ]);
    }
}
