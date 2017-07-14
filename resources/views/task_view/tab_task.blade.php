<?php
use Illuminate\Support\Facades\Auth;
?>
<form id="taskViewForm" >
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">Название задачи</label>
                <input type="text" name="title" disabled class="form-control" value="{{$task->title}}" />
            </div>
            <div class="form-group">
                <label class="control-label">Описание задачи</label>
                <textarea name="description" disabled class="form-control" >{{$task->description}}</textarea>
            </div>
            <div class="form-group">
                <label class="control-label">Приоритет</label>
                <select class="form-control" name="priority" disabled>
                    @foreach($taskPriorities as $key => $priority)
                        <option value="{{$key}}" {{($key == $task->priority) ? 'selected' : ''}} >{{$priority->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Статус</label>
                <select class="form-control" name="task_status_id" disabled>
                    @foreach($taskStatuses as $status)
                        <option value="{{$status->id}}" {{($status->id == $task->task_status_id) ? 'selected' : ''}} >{{$status->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Комментарий</label>
                <textarea name="comment" disabled class="form-control" >{{$task->comment}}</textarea>
            </div>
            <input type="hidden" name="id" value="{{$task->id}}" />
        </div>
        <div class="col-sm-6">
            <div class="form-group hide">
                <label class="control-label">Группа</label>
                <select class="form-control" name="group_id" disabled>
                    @foreach($taskGroups as $group)
                        <option value="{{$group->id}}" {{($group->id == $task->group_id) ? 'selected' : ''}} >{{$group->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group hide">
                <label class="control-label">Роль исполнителя</label>
                <select class="form-control" name="executor_role_id" disabled>
                    @foreach($roles as $role)
                        <option value="{{$role->id}}" {{($role->id == $task->executor_role_id) ? 'selected' : ''}} >{{$role->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Исполнитель</label>
                <select class="form-control" name="executor_id" disabled>
                    @foreach($users as $user)
                        <option value="{{$user->id}}" {{($user->id == $task->executor_id) ? 'selected' : ''}} >{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            @if(empty($taskTemplate->contractor_required) || !empty($task->contractor_id))
                <div class="form-group">
                    @if($task->contractor_type == 'App\Models\Company')
                        <label class="control-label">Клиент</label>
                        <select class="form-control" name="contractor_id" disabled>
                            <option value="" ></option>
                            @foreach($companies as $company)
                                <option value="{{$company->id}}" {{($company->id == $task->contractor_id) ? 'selected' : ''}} >{{$company->name}}</option>
                            @endforeach
                        </select>
                    @elseif($task->contractor_type == 'App\Models\Contractor')
                        <label class="control-label">Клиент</label>
                        <select class="form-control" name="contractor_id" disabled>
                            <option value="" ></option>
                            @foreach($contractors as $contractor)
                                <option value="{{$contractor->id}}" {{($contractor->id == $task->contractor_id) ? 'selected' : ''}} >{{$contractor->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Дата начала</label>
                <input type="text" name="taking_date" disabled class="form-control datetime" value="{{($task->taking_date != '0000-00-00 00:00:00') ? date('d.m.Y H:i', strtotime($task->taking_date)) : ''}}" />
            </div>
            <div class="form-group">
                <label class="control-label">Дата выполнения</label>
                <input type="text" name="execution_date" disabled class="form-control datetime" value="{{($task->execution_date != '0000-00-00 00:00:00') ? date('d.m.Y H:i', strtotime($task->execution_date)) : ''}}" />
            </div>
        </div>
    </div>
    {!! csrf_field() !!}
    
    @if (Auth::user()->id == $task->creator_id) {{-- если пользователь является создателем задачи --}}
        @if ($task->task_status_id == 1 || Auth::user()->id == $task->executor_id) {{-- если задача со статусом "Новый" или пользователь является исполнителем --}}
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-save">Сохранить</a>
        @endif
        @if (!in_array($task->task_status_id, [4, 5]))
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-finish">Завершить</a>
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-cancel-task">Отменить задачу</a>
        @endif
    @else
        @if ($task->task_status_id == 1) {{-- Новый --}}
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-set-status" data-status="2" >В работе</a>
        @elseif ($task->task_status_id == 2) {{-- В работе --}}
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-set-status" data-status="6" >Задача выполнена</a>
        @endif
    @endif
    
    @if (!empty($task->contractor_id) && !empty($task->contractor))
        <a href="/contractor/profile/{{$task->contractor->getType()}}/{{$task->contractor_id}}" class="btn btn-rounded btn-inline btn-primary">Перейти в карточку клиента</a>
    @elseif (!empty($taskTemplate->contractor_required))
        <a href="/client#task={{$task->id}}" class="btn btn-rounded btn-inline btn-primary">Добавить клиента</a>
    @endif
    
    {{-- Если не было checkin и checkin требуется для завершения задачи --}}
    {{-- @if (in_array(2, array_pluck($task->closeConditions, 'id')) && empty($task->latitude) && empty($task->longitude))
        <a href="#" class="btn btn-rounded btn-inline btn-primary js-checkin">Отметиться на месте</a>
    @endif --}}
</form>

<form id="cancelTaskForm" class="hide" >
    <div class="form-group">
        <label class="control-label">Комментарий</label>
        <textarea name="comment" class="form-control">{{$task->comment}}</textarea>
    </div>

    {!! csrf_field() !!}
    <input type="hidden" name="id" value="{{$task->id}}" />
</form>

<form id="finishTaskForm" class="hide" >
    <div class="form-group">
        <label class="control-label">После завершения</label>
        <select class="form-control" name="after_finish">
            @if(!empty($nextTaskTemplate))
                <option value="next" >Создать следующую задачу по этому же клиенту</option>
            @else
                <option value="finish" >Открыть запланированные задачи</option>
            @endif
            <option value="restart" >Перенести задачу на другой день</option>
            <option value="break" >Прервать выполнение бизнесс процесса</option>
        </select>
    </div>
    <div class="form-group js-task-new_finish_date" style="display: none;" >
        <label class="control-label">Дата выполнения</label>
        <input type="text" name="new_finish_date" class="form-control date" />
    </div>
    <div class="form-group js-task-new_taking_date" style="display: none;" >
        <label class="control-label">Дата переноса</label>
        <input type="text" name="new_taking_date" class="form-control date" />
    </div>
    <div class="form-group">
        <label class="control-label">Условие закрытия</label>
        <select class="form-control js-close-condition-change" name="task_close_condition_id">
            @foreach($taskCloseConditions as $condition)
                <option value="{{$condition->id}}" {{($condition->id == $task->task_close_condition_id) ? 'selected' : ''}} >{{$condition->type}}</option>
            @endforeach
        </select>
    </div>
    <div>
        <a href="#" class="btn btn-rounded btn-inline btn-primary js-checkin">Отметиться на месте</a>
    </div>
    <div class="form-group">
        <label class="control-label">Комментарий</label>
        <textarea name="comment" class="form-control" >{{$task->comment}}</textarea>
    </div>
    {!! csrf_field() !!}
    <input type="hidden" name="id" value="{{$task->id}}" />
</form>
