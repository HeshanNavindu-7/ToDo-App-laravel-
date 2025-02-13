<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
    $(document).ready(function(){
        // ✅ Add Task
        $('#task-form').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: '/tasks',
                method: 'POST',
                data: {
                    name: $('#task-name').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#task-list').append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center task-item" data-id="${response.id}">
                            <div>
                                <button class="btn btn-sm toggle-task btn-outline-success">Complete</button>
                                <span class="ms-2 task-name">${response.name}</span>
                            </div>
                            <button class="btn btn-sm btn-danger delete-task">Delete</button>
                        </li>
                    `);
                    $('#task-name').val('');
                },
                error: function(xhr) {
                    alert("Failed to add task. Error: " + xhr.responseText);
                }
            });
        });

        // ✅ Toggle Task Completion
        $(document).on('click', '.toggle-task', function () {
            let taskItem = $(this).closest('.task-item');
            let taskId = taskItem.data('id');
            let button = $(this);
            $.ajax({
                url: `/tasks/${taskId}`,
                method: 'PATCH',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.completed) {
                        button.removeClass('btn-outline-success').addClass('btn-success').text('Undo');
                        taskItem.find('.task-name').addClass('text-decoration-line-through');
                    } else {
                        button.removeClass('btn-success').addClass('btn-outline-success').text('Complete');
                        taskItem.find('.task-name').removeClass('text-decoration-line-through');
                    }
                },
                error: function() {
                    alert("Failed to update task. Please try again.");
                }
            });
        });

        // ✅ Delete Task
        $(document).on('click', '.delete-task', function () {
            let taskItem = $(this).closest('.task-item');
            let taskId = taskItem.data('id');
            $.ajax({
                url: `/tasks/${taskId}`,
                method: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function () {
                    taskItem.fadeOut(300, function () { $(this).remove(); });
                },
                error: function() {
                    alert("Failed to delete task. Please try again.");
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
                            <button class="btn btn-sm toggle-task {{ $task->completed ? 'btn-success' : 'btn-outline-success' }}">
                                {{ $task->completed ? 'Undo' : 'Complete' }}
                            </button>
                            <span class="ms-2 task-name {{ $task->completed ? 'text-decoration-line-through' : '' }}">{{ $task->name }}</span>
                        </div>
                        <button class="btn btn-sm btn-danger delete-task">Delete</button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>
