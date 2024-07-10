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

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $repetir_senha = $_POST['repetir_senha'];

    // Verificar se as senhas coincidem
    if ($senha !== $repetir_senha) {
        $message = "As senhas não coincidem.";
    } else {
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

        // Verificar se o email já existe
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $message = "Email já cadastrado. Por favor, use outro email.";
        } else {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha_hashed')";

            if ($conn->query($sql) === TRUE) {
                $message = "Cadastro realizado com sucesso!";
            } else {
                $message = "Erro: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Lavagem Automotiva</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Cadastro</h2>
            <?php if ($message): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="cadastro.php" method="post">
                <div class="input-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu email" required>
                </div>
                <div class="input-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>
                <div class="input-group">
                    <label for="repetir_senha">Repetir Senha:</label>
                    <input type="password" id="repetir_senha" name="repetir_senha" placeholder="Repita sua senha" required>
                </div>
                <button type="submit">Cadastrar</button>
            </form>
            <p>Já tem uma conta? <a href="login.html">Entre</a></p>
        </div>
    </div>
</body>
</html>
