<?php

namespace App\Models;

use App\Models\TaskTemplate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    public function group()
    {
        return $this->hasOne('App\Models\TaskGroup', 'id', 'group_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\TaskStatus', 'id', 'task_status_id');
    }
    
    public function businessAction()
    {
        return $this->hasOne('App\Models\BusinessAction', 'id', 'business_action_id');
    }
    
    public function executor()
    {
        return $this->hasOne('App\Models\User', 'id', 'executor_id');
    }
    
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'creator_id');
    }
    
    public function contractor()
    {
        return $this->morphTo();
    }
    
    public function files()
    {
        return $this->morphOne('App\Models\Files', 'relation');
    }
    
    public function checkBusinessAction()
    {
        if(empty($this->businessAction)) {
            return true;
        }
        $this->businessAction->task = $this;
        return $this->businessAction->check();
    }
    
    public function getBusinessActionErrors()
    {
        return $this->businessAction->errors();
    }

    public function closeConditions()
    {
        return $this->belongsToMany('App\Models\TaskCloseCondition', 'relation_tasks_task_close_conditions');
    }

    public static function saveTask($data)
    {
        if(!empty($data['taking_date'])) {
            $data['taking_date'] = date('Y-m-d H:i:s', strtotime($data['taking_date']));
        } else {
            unset($data['taking_date']);
        }
        if(!empty($data['execution_date'])) {
            $data['execution_date'] = date('Y-m-d H:i:s', strtotime($data['execution_date']));
        } else {
            unset($data['execution_date']);
        }
        
        $data = array_merge([
            'task_status_id' => 1, // новый
            'executor_id' => Auth::user()->id,
            'taking_date' => date('Y-m-d 09:00:00'),
            'execution_date' => date('Y-m-d 10:00:00'),
        ], $data);

        if(!empty($data['id'])) {
            $task = Task::where(['id' => $data['id']])
                ->first();
        } else {
            $task = new Task();
        }
        $task->unguard();
        $task->fill($data);
        $task->save();
        return $task;
    }

    public static function saveTaskGroup($data, $same = false)
    {
        // Get first
        $template = TaskTemplate::where(['group_id' => $data['group_id']])
            ->orderBy('order', 'ASC')
            ->first();

        return static::addGroupTaskByTemplateId($data, $template->id);
    }

    /**
     * Add group task
     * @param Array $data
     * @param boolean $same create next task or new
     */
    public static function addGroupTaskByTemplateId($data, $template_id)
    {
        array_merge($data, [
            'creator_id' => Auth::user()->id,
        ]);

        $template = TaskTemplate::where(['id' => $template_id])
            ->first();

        // добавить к дате завершения 1 или более часов от даты начала
        $execution_date = sprintf('%02d', 9 + (int) (empty($template->hour_limit) ? 1 : $template->hour_limit));
        
        $default = array_except($template->toArray(), [
            'id', 
            'contractor_required',
            'hour_limit',
            'day_limit',
            'order',
        ]);
        
        $default = array_merge($default, [
            'task_status_id' => 1, // новый
            'executor_id' => Auth::user()->id,
            'execution_date' => date("Y-m-d {$execution_date}:00:00"),
            'taking_date' => date('Y-m-d 09:00:00'),
            'close_date' => '',
            'creator_id' => Auth::user()->id,
            'chain' => time(),
            'template_id' => $template->id
        ]);
            
        $data = array_merge($default, $data);

        $task = new Task();
        $task->unguard();
        $task->fill($data);
        $task->save();
        return $task;
    }

    public static function countByManagerIdAndType($managerId, $taskCloseConditionId)
    {
//        $count = DB::table('tasks as t')
//            ->join('relation_tasks_task_close_conditions rttcc', 'rttcc.task_id', '=', 't.id')
//            ->select(DB::raw('COUNT(t.id) as cnt'))
//            ->where([
//                'rttcc.task_close_condition_id' => $taskCloseConditionId,
//                't.creator_id' => $managerId,
//            ])
//            ->first();
        if (empty($count)) {
            return false;
        }
        return $count->cnt;
    }
    
    public static function exptiredTasksCountByUserId($user_id)
    {
        $date = date('Y-m-d');
        
        return Task::where("execution_date", "<", $date)
            ->whereIn('task_status_id', [1, 2])
            ->where(function($query) use($user_id) {
                $query->where('executor_id', $user_id);
                $query->orWhere('creator_id', $user_id);
            })
            ->count();
    }
    
    public static function todayTasksCountByUserId($user_id)
    {
        $date = date('Y-m-d');
        
        return static::exptiredTasksCountByUserId($user_id) 
            + Task::whereRaw("DATE_FORMAT(execution_date, '%Y-%m-%d') = '{$date}'")
            ->whereIn('task_status_id', [1, 2])
            ->where(function($query) use($user_id) {
                $query->where('executor_id', $user_id);
                $query->orWhere('creator_id', $user_id);
            })
            ->count();
    }
    
    public static function inProcessTasksCountByUserId($user_id)
    {
        return Task::where("task_status_id", "!=", 5)
                ->whereIn('task_status_id', [1, 2])
                ->where(function($query) use($user_id) {
                    $query->where('executor_id', $user_id);
                    $query->orWhere('creator_id', $user_id);
                })
                ->count();
    }
}
