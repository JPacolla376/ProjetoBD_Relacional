const todoForm = document.getElementById('todo-form');
const todoInput = document.getElementById('todo-input');
const todoList = document.getElementById('todo-list');

todoForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const todoText = todoInput.value.trim();
    if (todoText !== '') {
        addTodoItem(todoText);
        todoInput.value = '';
    }
});

function addTodoItem(todoText) {
    const li = document.createElement('li');
    li.textContent = todoText;
    li.addEventListener('click', function () {
        editTodoItem(li);
    });
    li.addEventListener('contextmenu', function (event) {
        event.preventDefault();
        deleteTodoItem(li);
    });
    todoList.appendChild(li);
}

function editTodoItem(li) {
    const newText = prompt('Editar tarefa:', li.textContent);
    if (newText !== null) {
        li.textContent = newText;
    }
}

function deleteTodoItem(li) {
    li.remove();
}