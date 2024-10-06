<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: index.php');
    exit;
}

require 'banco.php'; // Conexão com o banco de dados

// Seleciona todos os produtos do banco de dados
$stmt = $pdo->prepare("SELECT * FROM produtos ORDER BY vencimento ASC");
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dataAtual = date('Y-m-d'); // Data atual para verificar vencimento

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estoque</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .vencido {
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Lista de Estoque</h1>
    </header>

    <nav>
        <ul>
            <li><a href="principal.php">Voltar à Tela Principal</a></li>
        </ul>
    </nav>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Data de Vencimento</th>
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr class="<?= ($produto['vencimento'] < $dataAtual) ? 'vencido' : '' ?>">
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= $produto['quantidade'] ?></td>
                <td><?= date('d/m/Y', strtotime($produto['vencimento'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


