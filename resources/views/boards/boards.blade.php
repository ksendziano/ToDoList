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
