<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.jpeg" alt="Logotipo" class="logo">
        <span>Doces da LULU</span>
        <h1>Painel Principal</h1>
    </header>

    <div class="container__principal">
        <nav>
            <ul>
                <li><a href="estoque.php">Entrada de Produtos</a></li>
                <li><a href="inventario.php">Inventário</a></li>
                <li><a href="relatorios.php">Relatórios</a></li>
                <li><a href="configuracoes.php">Configurações</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
	</div>
	
	<li><a href="lista_estoque.php">Lista de Estoque</a></li>

	
	
</body>
</html>