<div class="panel panel-default">
    <div class="panel-heading">
        Текущая задача
    </div>

    <div class="panel-body">
        <table class="table table-striped task-table">
            <style>
                table
                {
                    width:30%;
                }
            </style>
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
