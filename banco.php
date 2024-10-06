<?php
// Defina suas credenciais de banco de dados
$host = 'localhost'; // Geralmente 'localhost' para cPanel
$dbname = 'usuario_estoque'; // Substitua por seu nome completo do banco de dados
$user = 'usuario_admin'; // Substitua pelo nome de usuário criado
$pass = 'sua_senha'; // A senha do usuário criado

// Tentativa de conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
