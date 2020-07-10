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
        <div class="panel panel-default">
                    @foreach ($boards as $board)
                        <div>{{ $board->name }}</div>
                    @endforeach
        </div>
    @endif
@endsection
