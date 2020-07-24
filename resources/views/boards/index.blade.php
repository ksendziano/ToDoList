@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <!-- Отображение ошибок проверки ввода -->
    @include('common.errors')

    <!-- Форма новой доски -->
        <form action="{{route('boards.store')}}" method="POST" class="form-horizontal">
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
        <form action="{{ route('boards.download')}}" method="GET">
            {{ csrf_field() }}
            <button type="submit" id="download-boards " class="btn btn-default" >
                <i></i>Скачать доски
            </button>
        </form>
    @if (count($boards) > 0)

        <table class="table table-striped task-table">
            <thead>
            <th>Доски</th>
            <th>&nbsp;</th>
            </thead>
        <tbody>
            @foreach ($boards as $board)
                <tr>
                    <td><form action="{{ route('boards.show', ['board_id' => $board->id])}}" method="GET">
                            {{ csrf_field() }}
                            <button type="submit" id="download-boards " class="btn btn-default" >
                                <i></i>{{$board->name}}
                            </button>
                        </form></td>
                    <td>Владелец {{$board->user_id}} </td>
                </tr>
            @endforeach

        </tbody>
        </table>
    @endif
    </div>
@endsection
