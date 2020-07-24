@extends('layouts.app')

@section('content')
<div class="board" id="board_{{$board->id}}">
    <div class="panel panel-default" id="board_table">

        <style>
            #board_{{$board->id}}{

                background-color:{{$board->color}};
            }
            #board_table
            {
                width: 50%;
                margin-left: auto;
                margin-right: auto;
            }

        </style>
        <div class="panel-body">
            <table class="table table-striped task-table">
            <!-- Отображение ошибок проверки ввода -->
                <thead>
                <th>{{$board->name}}</th>
                <th>&nbsp;</th>
                </thead>
                <tbody>
                @include('common.errors')

        <!-- Форма новой задачи -->
            <form action="{{ url(route('boards.tasks.store',['board_id'=>$board_id])) }}" class="form-horizontal" method="POST">
                {{ csrf_field() }}
                <input type="hidden" value="{{$board->id}}" name="board_id" class="form-control">
                <!-- Имя задачи -->

                <div class="form-group">
                    <tr>
                        <td>
                            <label for="task" class="col-sm-3 control-label">Задача</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="task-name" class="form-control">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="task-description" class="col-sm-3 control-label">Описание задачи</label>

                            <div>
                                <textarea name="description" id="task-description" class="form-control"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <p><select name="status" size="1">
                                        <option >Выберите статус задачи</option>
                                        <option value="a">a</option>
                                        <option value="b">b</option>
                                        <option value="c">c</option>
                                        <option value="d">d</option>
                                    </select></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="task-date" class="col-sm-3 control-label">Сроки выполнения</label>
                        <p><input type="date" name="scheduled_date"></p>
                        </td>
                    </tr>
                </div>
                <tr>
                    <td>
                <!-- Кнопка добавления задачи -->
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-default" id="add_task_button">
                            <i class="fa fa-plus"></i> Добавить задачу
                        </button>
                        <style>
                            #add_task_button
                            {
                                margin-left: 0px;
                            }
                        </style>
                    </div>
                </div>
                    </td>
                </tr>
           </form>

                </tbody>
            </table>
            @if (count($board->tasks) > 0)
                @include('tasks.index')
            @endif
            <form action="{{ route('boards.edit', ['board' => $board])}}" method="POST">
                {{ csrf_field() }}
                <button type="submit" id="edit-board-{{ $board->id }}" class="btn btn-danger">
                    <i class="fa fa-btn fa-trash"></i>Редактировать доску
                </button>
            </form>
            <form action="{{ route('boards.destroy', ['board' => $board])}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" id="delete-board-{{ $board->id }}" class="btn btn-danger">
                    <i class="fa fa-btn fa-trash"></i>Удалить доску
                </button>
            </form>


        </div>

    </div>
    </div>
@endsection
