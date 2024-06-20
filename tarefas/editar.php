<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Login/login.php");
    exit();
}

include '../Login/db.php';

if (!isset($_GET['id'])) {
    echo "ID da tarefa não fornecido.";
    exit();
}

$tarefa_id = $_GET['id'];
$user_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("SELECT * FROM listas WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $tarefa_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Tarefa não encontrada.";
    exit();
}

$tarefa = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tema = $_POST['tema'];
    $descricao = $_POST['descricao'];
    $data_conclusao = $_POST['data_conclusao'];

    $stmt = $conn->prepare("UPDATE listas SET tema = ?, descricao = ?, data_conclusao = ? WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("sssii", $tema, $descricao, $data_conclusao, $tarefa_id, $user_id);

    if ($stmt->execute()) {
        header("Location: verTarefa.php");
        exit();
    } else {
        echo "Erro ao atualizar a tarefa.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="home.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Editar Tarefa</h1>

    <form method="post" action="editar.php?id=<?php echo $tarefa_id; ?>">
        <div class="mb-3">
            <label for="tema" class="form-label">Tema:</label>
            <select id="tema" name="tema" class="form-select" required>
                <option value="Estudo" <?php echo $tarefa['tema'] == 'Estudo' ? 'selected' : ''; ?>>Estudo</option>
                <option value="Trabalho" <?php echo $tarefa['tema'] == 'Trabalho' ? 'selected' : ''; ?>>Trabalho</option>
                <option value="Vida Social" <?php echo $tarefa['tema'] == 'Vida Social' ? 'selected' : ''; ?>>Vida Social</option>
                <option value="Familiar" <?php echo $tarefa['tema'] == 'Familiar' ? 'selected' : ''; ?>>Familiar</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <input type="text" id="descricao" name="descricao" class="form-control" value="<?php echo htmlspecialchars($tarefa['descricao']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="data_conclusao" class="form-label">Data de Conclusão:</label>
            <input type="date" id="data_conclusao" name="data_conclusao" class="form-control" value="<?php echo htmlspecialchars($tarefa['data_conclusao']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Tarefa</button>
    </form>
</div>

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
