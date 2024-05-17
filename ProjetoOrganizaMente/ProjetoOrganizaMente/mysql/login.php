<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, senha FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['usuario_id'] = $row['id'];
            header("Location: dashboard.php");
        } else {
            echo "Senha incorreta";
        }
    } else {
        echo "Nenhum usuário encontrado com esse email";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login de Usuário</title>
</head>
<body>
    <form method="post" action="login.php">
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
    