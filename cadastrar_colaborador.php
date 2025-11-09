<?php
session_start();
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}
include('../config/db_connect.php');
$nome = $_POST['nome'];
$funcao = $_POST['funcao'];
$cidade = $_POST['cidade'];
$polo = $_POST['polo'];
$status = $_POST['status'];
$ano = date('Y');
$sql = "INSERT INTO colaboradores (nome, funcao, cidade, polo, status, data_cadastro) VALUES (?,?,?,?,?,NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssss', $nome, $funcao, $cidade, $polo, $status);
if ($stmt->execute()) {
    $id = $conn->insert_id;
    $matricula = $ano . str_pad($id, 3, '0', STR_PAD_LEFT);
    $conn->query("UPDATE colaboradores SET matricula='$matricula' WHERE id=$id");
    mkdir('../uploads/Documentos/'.$matricula.'_'.$nome, 0777, true);
    header('Location: ../pages/colaboradores.php');
} else {
    echo 'Erro: '.$conn->error;
}
?>
