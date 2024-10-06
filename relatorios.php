<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: index.php');
    exit;
}

require 'banco.php'; // Conexão com o banco de dados

// Função para listar movimentações de produtos
function listarMovimentacoes($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM movimentacoes ORDER BY data DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para contar o nível de produtos
function contarProdutos($pdo) {
    $stmt = $pdo->prepare("SELECT nome, SUM(quantidade) as total FROM produtos GROUP BY nome");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$movimentacoes = listarMovimentacoes($pdo);
$produtos = contarProdutos($pdo);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Relatórios de Estoque</h1>
    </header>

    <nav>
        <ul>
            <li><a href="principal.php" class="button">Voltar à Tela Principal</a></li>
        </ul>
    </nav>

<section class="sessao1">
    <h2>Movimentações de Produtos</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Data</th>
        </tr>
        <?php foreach ($movimentacoes as $movimentacao): ?>
            <tr>
                <td><?= $movimentacao['id'] ?></td>
                <td><?= htmlspecialchars($movimentacao['produto']) ?></td>
                <td><?= $movimentacao['quantidade'] ?></td>
                <td><?= date('d/m/Y', strtotime($movimentacao['data'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<section class="sessao2">
    <h2>Nível de Produtos</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Produto</th>
            <th>Total em Estoque</th>
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= $produto['total'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
</body>
</html>
