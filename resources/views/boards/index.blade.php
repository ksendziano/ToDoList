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
                    <input type="radio" name="color" id="board-color" value="Red" class="form-control">Красный
                    <input type="radio" name="color" id="board-color" value="Blue" class="form-control">Синий
                    <input type="radio" name="color" id="board-color" value="Green" class="form-control">Зеленый
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
<<<<<<< Updated upstream
        <div class="panel panel-default">
                    @foreach ($boards as $board)
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
                        </div>
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
                                                </td>

                                                <!-- Кнопка Удалить -->
                                                <td>
                                                    <form action="{{ url('task/'.$task->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}

                                                        <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                                                            <i class="fa fa-btn fa-trash"></i>Удалить
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
        </div>
=======

                    @include('boards.boards')
>>>>>>> Stashed changes
    @endif
@endsection
