<?php
session_start();
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    header('Location: ../pages/login.php');
    exit();
}
include('../config/db_connect.php');
$colaborador_id = $_POST['colaborador_id'];
$nome_colab = $_POST['nome_colab'];
$matricula = $_POST['matricula'];
$dir = '../uploads/Documentos/'.$matricula.'_'.$nome_colab.'/';
if (!is_dir($dir)) mkdir($dir, 0777, true);
if (isset($_FILES['documento'])) {
    $arquivo = basename($_FILES['documento']['name']);
    $tmp = $_FILES['documento']['tmp_name'];
    $caminho = $dir . $arquivo;
    if (move_uploaded_file($tmp, $caminho)) {
        $sql = "INSERT INTO documentos (colaborador_id, nome_arquivo, caminho, data_upload) VALUES (?,?,?,NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $colaborador_id, $arquivo, $caminho);
        $stmt->execute();
        header('Location: ../pages/perfil_colaborador.php?id='.$colaborador_id);
    } else {
        echo 'Erro no upload.';
    }
}
?>