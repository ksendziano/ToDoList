@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <!-- Отображение ошибок проверки ввода -->
    @include('common.errors')

    <!-- Форма новой доски -->
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
        <form action="{{ route('boards.download')}}" method="GET">
            {{ csrf_field() }}
            <button type="submit" id="download-boards " class="btn btn-default" >
                <i></i>Скачать доски
            </button>
        </form>
    </div>
@endsection
