<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

include '../Login/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $tarefa_id = $_POST['id'];
    $user_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("DELETE FROM listas WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $tarefa_id, $user_id);

    if ($stmt->execute()) {
        header("Location: verTarefa.php");
        exit();
    } else {
        echo "Erro ao excluir tarefa.";
    }

    $stmt->close();
    $conn->close();
}
?>
