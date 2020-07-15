@extends('layouts.app')

@section('content')
    <form action="{{ url('task/'.$task->id.'/edit') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="task" class="col-sm-3 control-label">Задача</label>

            <div class="col-sm-6">
                <input type="text" name="name" id="task-name" value="{{$task->name}}" class="form-control">
            </div>
            <label for="task-description" class="col-sm-3 control-label">Описание задачи</label>
            <div>
                <textarea name="description" id="task-description"  class="form-control">{{$task->description}}</textarea>
            </div>
            <div>
                <p><select name="status" size="1">
                        <option disabled>Текущий статус {{$task->status}}</option>
                        <option value="a">a</option>
                        <option value="b">b</option>
                        <option value="c">c</option>
                        <option value="d">d</option>
                    </select></p>
            </div>
            <div>
                <p>Запланированнные сроки</p>
                <p><input type="date" value="{{$task->scheduled_date}}" name="scheduled_date"></p>
            </div>
            <div>
                <p>Реальные сроки</p>
                <p><input type="date"  name="real_date"></p>
            </div>

        </div>
        <button type="submit" id="edit-task-{{ $task->id }}" class="btn btn-danger">
            <i class="fa fa-btn fa-trash"></i>Редактировать задачу
        </button>
    </form>
@endsection
