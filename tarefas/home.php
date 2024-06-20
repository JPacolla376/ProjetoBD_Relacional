<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Login/login.php");
    exit();
}
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OrganizaMente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="home.css">
</head>

<body class="body">
    <div class="container-home">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap" />
                </svg>
                <a href="../Login/login.php"> <span class="fs-4">OrganizaMente </span> </a>
            </a>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="Login/login.php" class="nav-link"></a></li>
            </ul>
            <button type="button" class="btn btnAdc" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Começar
            </button>
        </header>
    </div>
    <div class="b-example-divider"></div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Adicionar Tarefa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tarefaForm">
                        <div class="mb-3">
                            <label for="selecaoCategoriaModal" class="form-label">Selecione:</label>
                            <select class="form-select" id="selecaoCategoriaModal" name="tema">
                                <option value="">Selecione:</option>
                                <option value="Estudo">Estudo</option>
                                <option value="Trabalho">Trabalho</option>
                                <option value="Vida Social">Vida Social</option>
                                <option value="Família">Família</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoTarefaModal" class="form-label">Descrição da Tarefa:</label>
                            <input type="text" class="form-control" id="descricaoTarefaModal" name="descricao"
                                placeholder="Digite a descrição da tarefa">
                        </div>
                        <div class="mb-3">
                            <label for="dataConclusaoModal" class="form-label">Data de Conclusão:</label>
                            <input type="date" class="form-control" id="dataConclusaoModal" name="data_conclusao">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btnAdc" onclick="salvarTarefa()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container mt-5">
    <h2>Criar Nova Tarefa</h2>
    <form id="formCriarTarefa">
        <div class="mb-3">
            <label for="selecaoTema" class="form-label">Tema:</label>
            <select class="form-select" id="selecaoTema" name="tema">
                <option value="Estudo">Estudo</option>
                <option value="Trabalho">Trabalho</option>
                <option value="Vida Social">Vida Social</option>
                <option value="Familiar">Familiar</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="descricaoTarefa" class="form-label">Descrição da Tarefa:</label>
            <input type="text" class="form-control" id="descricaoTarefa" name="descricao"
                placeholder="Digite a descrição da tarefa">
        </div>
        <div class="mb-3">
            <label for="dataConclusao" class="form-label">Data de Conclusão:</label>
            <input type="date" class="form-control" id="dataConclusao" name="data_conclusao">
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-primary" onclick="criarTarefa()">Criar Tarefa</button>
            <a href="verTarefa.php" class="btn btn-secondary">Visualizar Tarefas</a>
        </div>
    </form>
</div>

    
    <script>
        function salvarTarefa() {
            var categoria = document.getElementById('selecaoCategoriaModal').value;
            var descricao = document.getElementById('descricaoTarefaModal').value;
            var dataConclusao = document.getElementById('dataConclusaoModal').value;

            if (categoria.trim() !== '' && descricao.trim() !== '') {
                var formData = new FormData();
                formData.append('tema', categoria);
                formData.append('descricao', descricao);
                formData.append('data_conclusao', dataConclusao);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'criar.php', true); 
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);
                        var modal = bootstrap.Modal.getInstance(document.getElementById('staticBackdrop'));
                        modal.hide();
                    } else {
                        alert('Erro ao criar tarefa. Por favor, tente novamente.');
                    }
                };
                xhr.send(formData);

                document.getElementById('selecaoCategoriaModal').value = '';
                document.getElementById('descricaoTarefaModal').value = '';
                document.getElementById('dataConclusaoModal').value = '';
            } else {
                alert('Por favor, selecione uma categoria e digite a descrição da tarefa.');
            }
        }

        function criarTarefa() {
            var tema = document.getElementById('selecaoTema').value;
            var descricao = document.getElementById('descricaoTarefa').value;
            var dataConclusao = document.getElementById('dataConclusao').value;

            var formData = new FormData();
            formData.append('tema', tema);
            formData.append('descricao', descricao);
            formData.append('data_conclusao', dataConclusao);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'criar.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                } else {
                    alert('Erro ao criar tarefa. Por favor, tente novamente.');
                }
            };
            xhr.send(formData);
        }



function exibirTarefas(tarefas) {
    var listaTarefas = document.getElementById('listaTarefas');
    listaTarefas.innerHTML = '';

    tarefas.forEach(function (tarefa) {
        var itemLista = document.createElement('li');
        itemLista.textContent = tarefa.descricao;
        
       
        var btnEditar = document.createElement('button');
        btnEditar.textContent = 'Editar';
        btnEditar.onclick = function () {
            editarTarefa(tarefa.id);
        };
        
        
        var btnExcluir = document.createElement('button');
        btnExcluir.textContent = 'Excluir';
        btnExcluir.onclick = function () {
            excluirTarefa(tarefa.id);
        };

       
        itemLista.appendChild(btnEditar);
        itemLista.appendChild(btnExcluir);

        
        listaTarefas.appendChild(itemLista);
    });
}
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>