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
    $data = $_POST['data'];
    session_start();
    $email = $_SESSION['email'];

    // Inserir agendamento no banco de dados
    $sql = "INSERT INTO agendamentos (data, email) VALUES ('$data', '$email')";

    if ($conn->query($sql) === TRUE) {
        // Enviar email de confirmação
        $to = $email;
        $subject = "Confirmação de Agendamento";
        $message = "Seu agendamento para a data $data foi confirmado.";
        $headers = "From: noreply@lavagemautomotiva.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "Agendamento realizado com sucesso! Um email de confirmação foi enviado.";
        } else {
            echo "Erro ao enviar email de confirmação.";
        }
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
