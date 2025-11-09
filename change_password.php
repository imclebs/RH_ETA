<?php
session_start();
include('../config/db_connect.php');
if (!isset($_SESSION['matricula'])) {
    header('Location: ../pages/login.php');
    exit();
}
$target_id = intval($_POST['id']);
$newpwd = $_POST['senha'];
if ($newpwd === '') {
    header('Location: ../pages/users.php?msg=empty');
    exit();
}
$hash = hash('sha256', $newpwd);
if ($_SESSION['nivel'] === 'admin') {
    $sql = "UPDATE usuarios SET senha=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hash, $target_id);
    $stmt->execute();
    header('Location: ../pages/users.php?msg=pwdok');
} else {
    $sql = "SELECT id FROM usuarios WHERE matricula = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_SESSION['matricula']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    if ($row && intval($row['id']) === $target_id) {
        $sql = "UPDATE usuarios SET senha=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hash, $target_id);
        $stmt->execute();
        header('Location: ../pages/users.php?msg=pwdok');
    } else {
        header('Location: ../pages/users.php?msg=forbidden');
    }
}
?>