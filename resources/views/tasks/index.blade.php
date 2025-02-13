<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function(){
        // ✅ Add Task
        $('#task-form').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: '/tasks',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#task-list').append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center task-item" data-id="${response.id}">
                            <div>
                                <button class="btn btn-sm task-toggle btn-outline-success">Complete</button>
                                <span class="ms-2 task-name">${response.name}</span>
                            </div>
                            <button class="btn btn-sm btn-danger task-delete">Delete</button>
                        </li>
                    `);
                    $('#task-name').val('');
                }
            });
        });

        // ✅ Update Task (Mark as Complete/Undo)
        $(document).on('click', '.task-toggle', function () {
            let taskItem = $(this).closest('.task-item');
            let taskId = taskItem.data('id');
            let button = $(this);
            $.ajax({
                url: `/tasks/${taskId}`,
                method: 'PATCH',
                data: {_token: '{{ csrf_token() }}'},
                success: function (response) {
                    if (response.completed) {
                        button.removeClass('btn-outline-success').addClass('btn-success').text('Undo');
                        taskItem.find('.task-name').addClass('text-decoration-line-through');
                    } else {
                        button.removeClass('btn-success').addClass('btn-outline-success').text('Complete');
                        taskItem.find('.task-name').removeClass('text-decoration-line-through');
                    }
                }
            });
        });

        // ✅ Delete Task
        $(document).on('click', '.task-delete', function () {
            let taskItem = $(this).closest('.task-item');
            let taskId = taskItem.data('id');
            $.ajax({
                url: `/tasks/${taskId}`,
                method: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function () {
                    taskItem.fadeOut(300, function () { $(this).remove(); });
                }
            });
        });
    });
    </script>

   <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background: white;
            color: #212529;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }
        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card shadow p-4 text-center">
            <h1 class="mb-4">To-Do List</h1>
            <form id="task-form" class="d-flex mb-4">
                <input type="text" name="name" id="task-name" class="form-control me-2" placeholder="Enter task" required>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
            <ul id="task-list" class="list-group">
                @foreach($tasks as $task)
                    <li class="list-group-item d-flex justify-content-between align-items-center task-item" data-id="{{ $task->id }}">
                        <div>
                            <button class="btn btn-sm task-toggle {{ $task->completed ? 'btn-success' : 'btn-outline-success' }}">
                                {{ $task->completed ? 'Undo' : 'Complete' }}
                            </button>
                            <span class="ms-2 task-name {{ $task->completed ? 'text-decoration-line-through' : '' }}">{{ $task->name }}</span>
                        </div>
                        <button class="btn btn-sm btn-danger task-delete">Delete</button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>
