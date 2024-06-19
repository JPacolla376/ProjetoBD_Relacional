<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tarefas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = 1;

$stmt = $conn->prepare("CALL listagem(?)");
$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Descrição: " . $row["descricao"]. " - Tema: " . $row["tema"]. "<br>";
    }
} else {
    echo "0 resultados";
}

$stmt->close();
$conn->close();
?>
