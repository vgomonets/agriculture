<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TaskTemplate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_templates';

    public function group()
    {
        return $this->hasOne('App\Models\TaskGroup', 'id', 'group_id');
    }

    public function role()
    {
        return $this->hasOne('App\Models\Role', 'id', 'executor_role');
    }

    public static function getNextTemplateForTask($task_id)
    {
        $task = Task::where(['id' => $task_id])
            ->first();
        if (empty($task)) {
            return false;
        }

        $currentTaskTemplate = static::where(['id' => $task->template_id])
            ->first();

        if (empty($currentTaskTemplate)) {
            return false;
        }
        
        // get all closed tasks
        $closedTemplates = Task::where(['group_id' => $currentTaskTemplate->group_id])
            ->whereIn('task_status_id', [4, 5]) // отменен, завершен
            ->where('chain', $task->chain) // одна цепочка задач
            ->get();
        $closedTemplates = array_pluck($closedTemplates, 'template_id');
        
        $nextTasktemplate = static::where(['group_id' => $currentTaskTemplate->group_id])
            ->whereNotIn('id', $closedTemplates) // не закрыт
            ->where('id', '!=', $task->template_id) // не текущий
            ->orderBy('order', 'ASC')
            ->orderBy('id', 'ASC')
            ->first();
        
        if (empty($nextTasktemplate)) {
            return false;
        }

        return $nextTasktemplate;
    }
}
