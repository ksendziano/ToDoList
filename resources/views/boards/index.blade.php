@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <!-- Отображение ошибок проверки ввода -->
    @include('common.errors')

    <!-- Форма новой доски -->
        <form action="{{ url('board') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Имя доски -->
            <div class="form-group">
                <label for="board" class="col-sm-3 control-label">Доска</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="board-name" class="form-control">
                </div>
            </div>

            <!--Список выбора цвета -->
            <div class="form-group">
                <label for="board" >Выбор цвета</label>
                <div>
                    <input type="radio" name="color" id="board-color" value="#FF0000" class="form-control">Красный
                    <input type="radio" name="color" id="board-color" value="#0000FF" class="form-control">Синий
                    <input type="radio" name="color" id="board-color" value="#008000" class="form-control">Зеленый
                </div>

            </div>
            <!-- Кнопка добавления доски -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Добавить доску
                    </button>
                </div>
            </div>
        </form>
    </div>
    @if (count($boards) > 0)

                    @foreach ($boards as $board)
                        <div class="board" id="board_{{$board->id}}">
                        <style>
                            #board_{{$board->id}}{

                                background-color:{{$board->color}};
                            }
                        </style>
                        <div>{{ $board->name }}</div>
                                <div class="panel-body">
                            <!-- Отображение ошибок проверки ввода -->
                        @include('common.errors')

                        <!-- Форма новой задачи -->
                            <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                            {{ csrf_field() }}
                                <input type="hidden" value="{{$board->id}}" name="board_id" class="form-control">
                            <!-- Имя задачи -->
                                <div class="form-group">
                                    <label for="task" class="col-sm-3 control-label">Задача</label>

                                    <div class="col-sm-6">
                                        <input type="text" name="name" id="task-name" class="form-control">
                                    </div>
                                    <label for="task-description" class="col-sm-3 control-label">Описание задачи</label>
                                    <div>
                                        <textarea name="description" id="task-description" class="form-control"></textarea>
                                    </div>
                                    <div>
                                        <p><select name="status" size="1">
                                                <option disabled>Выберите статус задачи</option>
                                                <option value="a">a</option>
                                                <option value="b">b</option>
                                                <option value="c">c</option>
                                                <option value="d">d</option>
                                            </select></p>
                                    </div>
                                    <div>
                                        <p>Запланированнные сроки</p>
                                        <p><input type="date" name="scheduled_date"></p>
                                    </div>

                                </div>

                                <!-- Кнопка добавления задачи -->
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-plus"></i> Добавить задачу
                                        </button>
                                    </div>
                                </div>
                            </form>

                        @if (count($board->tasks) > 0)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Текущая задача
                                </div>

                                <div class="panel-body">
                                    <table class="table table-striped task-table">

                                        <!-- Заголовок таблицы -->
                                        <thead>
                                        <th>Task</th>
                                        <th>&nbsp;</th>
                                        </thead>

                                        <!-- Тело таблицы -->
                                        <tbody>
                                        @foreach ($board->tasks as $task)
                                            <tr>
                                                <!-- Имя задачи -->
                                                <td class="table-text">
                                                    <div>{{ $task->name }}</div>
                                                    <div>{{ $task->description }}</div>
                                                    <div>{{ $task->scheduled_date }}</div>
                                                    <div>{{ $task->status }}</div>
                                                </td>
                                            </tr>
                                             <tr>
                                                <!-- Кнопка Редактировать -->
                                                <td>
                                                <form action="{{ url('task/'.$task->id) }}" method="GET">
                                                {{ csrf_field() }}
                                                    <button type="submit" id="edit-task-{{ $task->id }}" class="btn btn-danger">
                                                        <i class="fa fa-btn fa-trash"></i>Редактировать
                                                    </button>
                                                </form>
                                                </td>
                                                <!-- Кнопка Удалить -->
                                                <td>
                                                    <form action="{{ url('task/'.$task->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}

                                                        <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                                                            <i class="fa fa-btn fa-trash"></i>Удалить задачу
                                                        </button>
                                                    </form>
                                                </td>
                                             </tr>
                                            <tr>
                                                <!-- Форма копировать в -->
                                                <form action="{{ url('task/'.$task->id.'/copy') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <td>
                                                        <p>
                                                            <select name="board_id" size="1">
                                                                <option>Выберите доску</option>
                                                                @foreach($boards as $board)
                                                                    <option value="{{$board->id}}">{{$board->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <button type="submit" id="copy-task-{{ $task->id }}" class="btn btn-danger">
                                                            <i class="fa fa-btn fa-trash"></i>Копировать задачу
                                                        </button>
                                                    </td>
                                                </form>
                                            </tr>
                                            <tr>
                                                <!-- Форма переместить в -->
                                                <form action="{{ url('task/'.$task->id.'/replace') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <td>
                                                        <p>
                                                            <select name="board_id" size="1">
                                                            <option>Выберите доску</option>
                                                            @foreach($boards as $board)
                                                                <option value="{{$board->id}}">{{$board->name}}</option>
                                                            @endforeach
                                                            </select>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <button type="submit" id="replace-task-{{ $task->id }}" class="btn btn-danger">
                                                            <i class="fa fa-btn fa-trash"></i>Переместить задачу
                                                        </button>
                                                    </td>
                                                </form>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        <form action="{{ url('board/'.$board->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="submit" id="delete-board-{{ $board->id }}" class="btn btn-danger">
                                <i class="fa fa-btn fa-trash"></i>Удалить доску
                            </button>
                        </form>
                        </div>
                    @endforeach
        </div>
    @endif
@endsection
