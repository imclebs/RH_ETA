<?php
include('../config/db_connect.php');
session_start();
if (!isset($_SESSION['matricula'])) { header('Location: login.php'); exit(); }
$isAdmin = isset($_SESSION['nivel']) && $_SESSION['nivel'] === 'admin';
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
<meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Colaboradores - ETA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>:root{--eta-navy:#25499B;--eta-moss:#556049;--eta-light:#B4C6DC;--eta-bg:#E6E9F1;} body{background:var(--eta-bg)} .btn-eta{background:var(--eta-navy);color:white;border:none}</style>
</head>
<body>
<nav class='d-flex justify-content-between align-items-center' style='background:var(--eta-navy);color:white;padding:12px'>
  <div style='margin-left:20px;'><strong>ETA Engenharia - RH</strong></div>
  <div style='margin-right:20px;'>Usuário: <?php echo $_SESSION['matricula']; ?> — <em><?php echo $_SESSION['nivel']; ?></em> <a href='../actions/logout.php' class='btn btn-light btn-sm ms-3'>Sair</a></div>
</nav>
<div class='container mt-4'>
  <div class='d-flex justify-content-between mb-3'><h4>Colaboradores</h4><?php if($isAdmin): ?><a href='adicionar_colaborador.php' class='btn btn-eta'>+ Novo</a><?php endif; ?></div>
  <div class='card p-3'><table class='table'><thead class='table-secondary'><tr><th>Matrícula</th><th>Nome</th><th>Função</th><th>Polo</th><th>Status</th><th>Ações</th></tr></thead><tbody>
<?php
$sql = "SELECT * FROM colaboradores ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows>0){
while($row=$result->fetch_assoc()){
  echo '<tr>';
  echo '<td>'.$row['matricula'].'</td>';
  echo '<td>'.$row['nome'].'</td>';
  echo '<td>'.$row['funcao'].'</td>';
  echo '<td>'.$row['polo'].'</td>';
  echo '<td><span class="badge bg-'.($row['status']=='Ativo'?'success':'secondary').'">'.$row['status'].'</span></td>';
  echo '<td><a class="btn btn-sm btn-outline-primary" href="perfil_colaborador.php?id='.$row['id'].'">Ver</a></td>';
  echo '</tr>';
}
} else { echo '<tr><td colspan="6" class="text-center text-muted">Nenhum colaborador.</td></tr>';}
?>
</tbody></table></div></div></body></html>