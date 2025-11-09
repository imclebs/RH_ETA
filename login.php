<?php
session_start();
include('../config/db_connect.php');
$matricula = $_POST['matricula'] ?? '';
$senha = $_POST['senha'] ?? '';
$sql = "SELECT * FROM usuarios WHERE matricula = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricula);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (hash('sha256', $senha) === $user['senha']) {
        $_SESSION['matricula'] = $user['matricula'];
        $_SESSION['nivel'] = $user['nivel'];
        header('Location: ../pages/dashboard.php');
        exit();
    } else {
        echo "<script>alert('Senha incorreta!');window.location='../pages/login.php';</script>";
    }
} else {
    echo "<script>alert('Usuário não encontrado!');window.location='../pages/login.php';</script>";
}
?>