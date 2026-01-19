@extends('Agent.common.app')
@section('main')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">More</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">To Do List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body">
                <h4 class="mb-0">To Do List</h4>
                <hr/>
                <div class="row gy-3">
                    <div class="col-md-10">
                        <input id="todo-input" type="text" class="form-control" value="">
                    </div>
                    <div class="col-md-2 text-end d-grid">
                        <button type="button" id="store_todo" onclick="CreateTodo();" class="btn btn-primary">Add todo</button>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="col-12">
                        <div id="todo-container">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var todos = [];

    // Load todos from server or initialize if not available
    function initializeTodos() {
        // Make AJAX request to load todos from the server
        $.ajax({
            url: '{{ route("get_todo") }}', // Replace with your actual endpoint for loading todos
            method: 'GET',
            success: function(response) {
                // Handle success response
                todos = response;
                RenderAllTodos();
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error loading todos:', error);
            }
        });
    }

    // Initialize todos on page load
    $(document).ready(function() {
        initializeTodos();
    });

    document.getElementById("todo-input").oninput = function(e) {
        currentTodo.text = e.target.value;
    };

    function DrawTodo(todo) {
    var newTodoHTML = `
        <div class="pb-3 todo-item" todo-id="${todo.id}">
            <div class="input-group">
                <div class="input-group-text">
                    <input type="checkbox" class="todo-checkbox" aria-label="Checkbox for following text input" ${todo.done ? 'checked' : ''}>
                </div>
                <input type="text" readonly class="form-control ${todo.done ? 'todo-done' : ''}" aria-label="Text input with checkbox" value="${todo.comment}">
                <button todo-id="${todo.id}" class="btn btn-outline-secondary bg-danger text-white" type="button" onclick="DeleteTodo(${todo.id});" id="button-addon2">X</button>
            </div>
        </div>
    `;
    var dummy = document.createElement("DIV");
    dummy.innerHTML = newTodoHTML;
    document.getElementById("todo-container").appendChild(dummy.children[0]);

}


    function RenderAllTodos() {
        var container = document.getElementById("todo-container");
        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }
        for (var i = 0; i < todos.length; i++) {
            DrawTodo(todos[i]);
        }
    }

    function DeleteTodo(id) {
        // If todos are managed locally, delete locally first and then send AJAX request
        todos = todos.filter(todo => todo.id !== id);
        RenderAllTodos();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        // Make AJAX request to delete todo from the server
        $.ajax({
            url: '{{ route("delete_todo") }}', // Replace with your actual endpoint for deleting todo item
            method: 'POST',
            data: {
                todoId: id,
                _token: csrfToken
            },
            success: function(response) {
                // Handle success response
                console.log('Todo deleted successfully:', response);
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error deleting todo:', error);
            }
        });
    }

</script>

<script>
$(document).ready(function(){
    $('#checkbox').change(function(){
        var isChecked = $(this).prop('checked');
        // Make an AJAX POST request
        $.ajax({
            url: '{{ route("delete_todo") }}',
            method: 'POST',
            data: {
                isChecked: isChecked
            },
            success: function(response){
                // Handle success
                console.log(response);
            },
            error: function(xhr, status, error){
                // Handle error
                console.error(error);
            }
        });
    });
});
</script>
<script>
    $(document).ready(function() {
        $('#store_todo').click(function() {
       
            // Get the value from the input field
            var todoInputValue = $('#todo-input').val().trim();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Check if the input is not empty
            if (todoInputValue !== '') {
                // AJAX request to add a new todo
                $.ajax({
                    url: '{{ route("store_todo") }}', // Replace with your actual endpoint
                    method: 'POST',
                    headers: {
                             'X-CSRF-Token': csrfToken // Include CSRF token in the request headers
                         },
                    data: {
                        todo: todoInputValue,
                        _token: csrfToken
                    },
                    success: function(response) {
                        if(response.status==true){
                            initializeTodos();
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error('Error adding todo:', error);
                        // Optionally, you can display an error message or perform any other action here
                    }
                });
            } else {
                // Handle empty input case
                console.error('Todo input is empty');
                // Optionally, you can display a message to the user indicating that the input is empty
            }
        });
    });
    </script>
@endsection