<?php
include 'conexao.php';

$filtro_status = $_GET['status'] ?? '';
$filtro_criticidade = $_GET['criticidade'] ?? '';

$sql = "SELECT c.id_chamado, cl.nome AS cliente, c.descricao, c.criticidade, c.status, co.nome AS colaborador 
        FROM chamados c
        LEFT JOIN clientes cl ON c.id_cliente = cl.id_cliente
        LEFT JOIN colaboradores co ON c.id_colaborador = co.id_colaborador";

if ($filtro_status || $filtro_criticidade) {
    $sql .= " WHERE ";
    if ($filtro_status) {
        $sql .= "c.status = ? ";
    }
    if ($filtro_criticidade) {
        $sql .= ($filtro_status ? "AND " : "") . "c.criticidade = ?";
    }
}

$stmt = $conn->prepare($sql);

// Associar os filtros se existirem
if ($filtro_status && $filtro_criticidade) {
    $stmt->bind_param("ss", $filtro_status, $filtro_criticidade);
} elseif ($filtro_status) {
    $stmt->bind_param("s", $filtro_status);
} elseif ($filtro_criticidade) {
    $stmt->bind_param("s", $filtro_criticidade);
}

// Executar a consulta
$stmt->execute();

// Associar os resultados às variáveis
$stmt->bind_result($id_chamado, $cliente, $descricao, $criticidade, $status, $colaborador);

// Criar um array para armazenar os resultados
$chamados = [];
while ($stmt->fetch()) {
    $chamados[] = [
        'id_chamado' => $id_chamado,
        'cliente' => $cliente,
        'descricao' => $descricao,
        'criticidade' => $criticidade,
        'status' => $status,
        'colaborador' => $colaborador,
    ];
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Gerenciamento de Chamados</title>
</head>
<body>
    <h1>Gerenciamento de Chamados</h1>
    <form method="GET">
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">Todos</option>
            <option value="aberto">Aberto</option>
            <option value="em andamento">Em andamento</option>
            <option value="resolvido">Resolvido</option>
        </select>
        <label for="criticidade">Criticidade:</label>
        <select name="criticidade" id="criticidade">
            <option value="">Todas</option>
            <option value="baixa">Baixa</option>
            <option value="média">Média</option>
            <option value="alta">Alta</option>
        </select>
        <button type="submit">Filtrar</button>
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Descrição</th>
            <th>Criticidade</th>
            <th>Status</th>
            <th>Colaborador</th>
        </tr>
        <?php foreach ($chamados as $chamado): ?>
            <tr>
                <td><?= $chamado['id_chamado'] ?></td>
                <td><?= $chamado['cliente'] ?></td>
                <td><?= $chamado['descricao'] ?></td>
                <td><?= $chamado['criticidade'] ?></td>
                <td><?= $chamado['status'] ?></td>
                <td><?= $chamado['colaborador'] ?? 'Não atribuído' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
