<div class="panel panel-default" id="tasks-table">
    <div class="panel-body" >
        <table class="table table-striped task-table" >
            <style>
                #tasks-table
                {
                    width:100%;
                }
            </style>
            <!-- Заголовок таблицы -->
            <thead>
            <th>Задачи</th>
            <th>&nbsp;</th>
            </thead>

            <!-- Тело таблицы -->
            <tbody>
            @foreach ($board->tasks as $task)
                <tr>
                    <!-- Имя задачи -->
                    <td>
                        <b>Имя задачи</b>
                    </td>
                    <td>
                        <div>{{ $task->name }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Описание задачи</b>
                    </td>
                    <td>
                        <div>{{ $task->description }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Планируемые сроки</b>
                    </td>
                    <td>
                        <div>{{ $task->scheduled_date }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Статус задачи</b>
                    </td>
                    <td>
                        <div>{{ $task->status }}</div>
                    </td>
                </tr>

                <tr>
                    <!-- Кнопка Редактировать -->
                    <td>
                        <form action="{{ url('user'.$task->user_id.'/task/'.$task->id) }}" method="GET">
                            {{ csrf_field() }}
                            <button type="submit" id="edit-task-{{ $task->id }}" class="btn btn-danger">
                                <i class="fa fa-btn fa-trash"></i>Редактировать
                            </button>
                        </form>
                    </td>
                    <!-- Кнопка Удалить -->
                    <td>
                        <form action="{{ url('user'.$task->user_id.'/task/'.$task->id) }}" method="POST">
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
                    <form action="{{ url('user'.$task->user_id.'/task/'.$task->id.'/copy') }}" method="POST">
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
                    <form action="{{ url('user'.$task->user_id.'/task/'.$task->id.'/replace') }}" method="POST">
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
                <tr>
                    <td>   </td>
                    <td>   </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
