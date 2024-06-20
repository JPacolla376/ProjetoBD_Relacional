<?php
include '../Login/db.php'; 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['usuario_id'])) {
        $usuario_id = $_SESSION['usuario_id'];
        $tema = $_POST['tema'];
        $descricao = $_POST['descricao'];
        $data_conclusao = $_POST['data_conclusao'];

        
        if (!empty($tema) && !empty($descricao)) {
            $sql = "INSERT INTO listas (usuario_id, tema, descricao, data_conclusao) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $usuario_id, $tema, $descricao, $data_conclusao);

            if ($stmt->execute()) {
                echo "Tarefa criada com sucesso!";
            } else {
                echo "Erro ao criar tarefa: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Todos os campos são obrigatórios.";
        }
    } else {
        echo "Usuário não autenticado.";
    }
    $conn->close();
}
?>
