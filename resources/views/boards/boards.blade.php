@foreach ($boards as $board)
    <div class="board" id="board_{{$board->id}}">
        <style>
            #board_{{$board->id}}{

                background-color:{{$board->color}};
            }
        </style>
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
                    <p>Запланированнные сроки</p>
                    <p><input type="date" name="scheduled_date"></p>
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
                @include('tasks.index')
            @endif
            <form action="{{ url('board/'.$board->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" id="delete-board-{{ $board->id }}" class="btn btn-danger">
                    <i class="fa fa-btn fa-trash"></i>Удалить доску
                </button>
            </form>
        </div>

    </div>
@endforeach
