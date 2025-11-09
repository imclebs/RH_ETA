<?php
session_start();
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}
include('../config/db_connect.php');
$id = intval($_POST['id']);
$matricula = $_POST['matricula'];
$nivel = $_POST['nivel'];
if ($id > 0) {
    $sql = "UPDATE usuarios SET matricula=?, nivel=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $matricula, $nivel, $id);
    $stmt->execute();
}
header('Location: ../pages/users.php?msg=edited');
?>