@extends('layouts.app')

@section('content')
    <div class="panel panel-default" id="tasks-table">

            <style>
                #tasks-table
                {
                    width: 30%;
                    margin-left: auto;
                    margin-right: auto;
                }
            </style>
    <form action="{{ url(route('boards.tasks.update',['board_id'=>$board_id,'task_id'=>$task->id,])) }}" method="POST">
        {{ csrf_field() }}
        <table class="table table-striped task-table" id="edit-table">
        <div class="form-group">
            <thead>
            <th>Редактирование задачи</th>
            <th>&nbsp;</th>
            </thead>

            <tr>
                <td>
                <label for="task" class="col-sm-3 control-label">Задача</label>
                </td>
                <td>
                <div class="col-sm-6">
                    <input type="text" name="name" id="task-name" value="{{$task->name}}" class="form-control">
                </div>
                </td>
            </tr>
            <tr>
                <td>
                <label for="task-description" class="col-sm-3 control-label">Описание задачи</label>
                </td>
                <td>
                <div>
                    <textarea  name="description" id="task-description"  class="form-control">{{$task->description}}</textarea>
                    <style>

                    </style>
                </div>
                </td>
            </tr>
            <tr>
            <div>
                <td><label for="status" class="col-sm-3 control-label">Статус задачи</label></td>
                <td>
                <p><select name="status" size="1">
                        <option disabled>Текущий статус {{$task->status}}</option>
                        <option value="0">Сделана</option>
                        <option value="1">Не сделана</option>
                    </select></p>
                </td>
            </div>
            </tr>
            <tr>
            <div>
                <td><p><b>Запланированнные сроки</b></p></td>
                <td><p><input type="date" value="{{$task->scheduled_date}}" name="scheduled_date"></p></td>
            </div>
            </tr>
            <tr>


            </tr>
        </div>
        <tr>
        <td>
            <button type="submit" id="edit-task-{{ $task->id }}" class="btn btn-danger">
                <i class="fa fa-btn fa-trash"></i>Редактировать задачу
            </button>
        </td>
            <td></td>
        </tr>
        </table>

    </form>

    </div>
@endsection
