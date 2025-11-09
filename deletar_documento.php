<?php
session_start();
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}
include('../config/db_connect.php');
$id_doc = intval($_GET['id']);
$id_colab = intval($_GET['colab']);
$sql = "SELECT caminho FROM documentos WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_doc);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows>0) {
    $row = $res->fetch_assoc();
    if (file_exists($row['caminho'])) unlink($row['caminho']);
}
$conn->query("DELETE FROM documentos WHERE id=$id_doc");
header('Location: ../pages/perfil_colaborador.php?id='.$id_colab);
?>