<form id="taskForm" style="display:none;" >
    <input type="hidden" name="type" class="form-control" />
    <input type="hidden" name="contractor_id" />
    <input type="hidden" name="contractor_type" />
    <div class="js-task-personal" style="display:none;">
        <div class="form-group">
            <div class="form-group">
                <label class="control-label">Клиент</label>
                <input type="text" class="form-control js-typeahead" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">Исполнитель</label>
            <input type="hidden" name="personal[executor_id]" />
            <input type="text" class="form-control js-typeahead-users-personal" />
        </div>
        <div class="form-group">
            <label class="control-label">Название задачи</label>
            <input type="text" name="personal[title]" class="form-control" />
        </div>
        <div class="form-group">
            <label class="control-label">Описание задачи</label>
            <textarea name="personal[description]" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label class="control-label">Приоритет</label>
            <select name="personal[priority]" class="form-control">
                @foreach($taskPriorities as $key => $priority)
                    <option value="{{$key}}">{{$priority->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Дата начала выполнения</label>
            <input name="personal[taking_date]" class="form-control date" />
        </div>
        <div class="form-group">
            <label class="control-label">Срок выполнения</label>
            <input name="personal[execution_date]" class="form-control date" />
        </div>
    </div>
    <div class="js-task-group" style="display:none;">
        <div class="form-group">
            <label class="control-label">Группа</label>
            <select name="group[group_id]" class="form-control">
                <option value="0" data-contractor-required="0">Выберите шаблон</option>
                @foreach($taskGroups as $group)
                    <option value="{{$group->id}}" data-contractor-required="{{$group->contractor_required}}" >{{$group->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Исполнитель</label>
            <input type="hidden" name="group[executor_id]" />
            <input type="text" class="form-control js-typeahead-users-group" />
        </div>
        <div class="form-group js-task-group-contractor_id hide">
            <label class="control-label">Клиент</label>
            <input type="text" class="form-control js-typeahead" />
        </div>
    </div>
    <input type="hidden" name="id" />
    {!! csrf_field() !!}
</form>