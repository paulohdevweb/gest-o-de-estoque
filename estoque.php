<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: index.php');
    exit;
}

require 'banco.php'; // Conexão com o banco de dados

$mensagem = "";

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $vencimento = $_POST['vencimento'];

    // Verifica se o produto já existe no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE nome = ?");
    $stmt->execute([$nome]);
    $produto = $stmt->fetch();

    if ($produto) {
        // Se o produto já existe, atualiza a quantidade
        $novaQuantidade = $produto['quantidade'] + $quantidade;
        $stmt = $pdo->prepare("UPDATE produtos SET quantidade = ?, vencimento = ? WHERE id = ?");
        $stmt->execute([$novaQuantidade, $vencimento, $produto['id']]);
        $mensagem = "Quantidade atualizada com sucesso!";
    } else {
        // Se o produto não existe, insere um novo
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, quantidade, vencimento) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $quantidade, $vencimento]);
        $mensagem = "Produto cadastrado com sucesso!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Inventário de Produtos</h1>
    </header>

    <nav>
        <ul>
            <li><a href="principal.php">Voltar à Tela Principal</a></li>
        </ul>
    </nav>
    <section class="tab">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nome do Produto</th>
                <th>Quantidade</th>
                <th>Data de Vencimento</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= $produto['id'] ?></td>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td><?= $produto['quantidade'] ?></td>
                    <td><?= date('d/m/Y', strtotime($produto['vencimento'])) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                            <input type="text" name="nome" placeholder="Novo nome" required>
                            <input type="number" name="quantidade" placeholder="Nova quantidade" required>
                            <input type="date" name="vencimento" required>
                            <button type="submit" name="editar">Editar</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                            <button type="submit" name="remover" onclick="return confirm('Tem certeza que deseja remover este produto?');">Remover</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</body>
</html>