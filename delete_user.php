<?php
session_start();
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}
include('../config/db_connect.php');
$id = intval($_GET['id']);
if ($id > 0) {
    $conn->query("DELETE FROM usuarios WHERE id=$id");
}
header('Location: ../pages/users.php');
?>