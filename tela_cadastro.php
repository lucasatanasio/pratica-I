<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if (!empty($nome) && !empty($email) && !empty($telefone)) {
        // Preparar a consulta SQL usando placeholders posicionais
        $sql = "INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Associar os valores aos placeholders com bind_param
            $stmt->bind_param("sss", $nome, $email, $telefone);

            // Executar a consulta
            if ($stmt->execute()) {
                $mensagem = "Cliente cadastrado com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar cliente: " . $stmt->error;
            }

            // Fechar o statement
            $stmt->close();
        } else {
            $mensagem = "Erro ao preparar a consulta: " . $conn->error;
        }
    } else {
        $mensagem = "Preencha todos os campos!";
    }
}

// Fechar a conexão
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Clientes</h1>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>
        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" required>
        <button type="submit">Cadastrar</button>
    </form>
    <?php if (isset($mensagem)) echo "<p>$mensagem</p>"; ?>
</body>
</html>