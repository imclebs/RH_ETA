<?php
$host = "localhost"; // alterar se necessário
$user = "USUARIO_DO_BANCO"; // ← ALTERE AQUI
$pass = "SENHA_DO_BANCO"; // ← ALTERE AQUI
$db   = "engeta06_sistema_rh"; // ← ALTERE SE IMPORTAR COM NOME DIFERENTE

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>