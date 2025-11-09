<?php
session_start();
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}
include('../config/db_connect.php');
$matricula = $_POST['matricula'];
$senha = $_POST['senha'];
$nivel = $_POST['nivel'];
$hash = hash('sha256', $senha);
$sql = "INSERT INTO usuarios (matricula, senha, nivel) VALUES (?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $matricula, $hash, $nivel);
if ($stmt->execute()) {
    header('Location: ../pages/users.php?msg=created');
} else {
    echo 'Erro: ' . $conn->error;
}
?>