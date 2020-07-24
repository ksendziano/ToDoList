@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <!-- Отображение ошибок проверки ввода -->
    @include('common.errors')

    <!-- Форма новой доски -->
        <form action="{{route('boards.update',['board'=>$board])}}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Имя доски -->
            <div class="form-group">
                <label for="board" class="col-sm-3 control-label">Доска</label>

                <div class="col-sm-6">
                    <input type="text" name="name" value="{{$board->name}}" id="board-name" class="form-control">
                </div>
            </div>

            <!--Список выбора цвета -->
            <div class="form-group">
                <label for="board" >Выбор цвета</label>
                <div>
                    <input type="radio" name="color" id="board-color" value="#FF0000" class="form-control" @if($board->color=='#FF0000')checked @endif >Красный
                    <input type="radio" name="color" id="board-color" value="#0000FF" class="form-control" @if($board->color=='#0000FF')checked @endif >Синий
                    <input type="radio" name="color" id="board-color" value="#008000" class="form-control" @if($board->color=='#008000')checked @endif >Зеленый
                </div>

            </div>
            <!-- Кнопка добавления доски -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Редактировать доску
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
