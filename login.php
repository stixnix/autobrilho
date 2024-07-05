<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lavagem_auto";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            // Iniciar sessão e redirecionar para a página principal
            session_start();
            $_SESSION['email'] = $email;
            header("Location: index.html");
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Email não encontrado.";
    }
}

$conn->close();
?>
