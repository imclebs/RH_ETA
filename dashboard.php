<?php
session_start();
if (!isset($_SESSION['matricula'])) { header('Location: login.php'); exit(); }
include('../config/db_connect.php');

// Counts
$cnt_total = $conn->query("SELECT COUNT(*) AS c FROM colaboradores")->fetch_assoc()['c'];
$cnt_ativos = $conn->query("SELECT COUNT(*) AS c FROM colaboradores WHERE status='Ativo'")->fetch_assoc()['c'];
$cnt_deslig = $conn->query("SELECT COUNT(*) AS c FROM colaboradores WHERE status='Desligado'")->fetch_assoc()['c'];
$cnt_docs = $conn->query("SELECT COUNT(*) AS c FROM documentos")->fetch_assoc()['c'];

// Recent uploads (last 5)
$recent = $conn->query("SELECT d.nome_arquivo, d.data_upload, c.nome FROM documentos d JOIN colaboradores c ON d.colaborador_id=c.id ORDER BY d.data_upload DESC LIMIT 5");

?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Dashboard - RH ETA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root{--eta-navy:#25499B;--eta-moss:#556049;--eta-light:#B4C6DC;--eta-bg:#E6E9F1;}
body{background:var(--eta-bg);font-family:Arial,Helvetica,sans-serif}
nav{background:var(--eta-navy);color:white;padding:12px}
.card{border-radius:12px}
.btn-eta{background:var(--eta-navy);color:white;border:none}
</style>
</head>
<body>
<nav class='d-flex justify-content-between align-items-center'>
  <div style='margin-left:20px;'><strong>ETA Engenharia - RH</strong></div>
  <div style='margin-right:20px;'>Usuário: <?php echo $_SESSION['matricula']; ?> — <em><?php echo $_SESSION['nivel']; ?></em> <a href='../actions/logout.php' class='btn btn-light btn-sm ms-3'>Sair</a></div>
</nav>
<div class='container mt-4'>
  <div class='row g-3'>
    <div class='col-md-4'>
      <div class='card p-3'>
        <h5>Total de Colaboradores</h5>
        <h2><?php echo $cnt_total; ?></h2>
        <p>Ativos: <?php echo $cnt_ativos; ?> — Desligados: <?php echo $cnt_deslig; ?></p>
      </div>
    </div>
    <div class='col-md-4'>
      <div class='card p-3'>
        <h5>Total de Documentos</h5>
        <h2><?php echo $cnt_docs; ?></h2>
        <canvas id='docsChart' height='150'></canvas>
      </div>
    </div>
    <div class='col-md-4'>
      <div class='card p-3'>
        <h5>Distribuição</h5>
        <canvas id='statusChart' height='150'></canvas>
      </div>
    </div>
  </div>

  <div class='row mt-4'>
    <div class='col-md-6'>
      <div class='card p-3'>
        <h5>Últimos uploads</h5>
        <ul class='list-group'><?php while($r=$recent->fetch_assoc()){ echo "<li class='list-group-item'>".htmlspecialchars($r['nome'])." — <small>".date('d/m/Y H:i',strtotime($r['data_upload']))."</small></li>"; } ?></ul>
      </div>
    </div>
    <div class='col-md-6'>
      <div class='card p-3'>
        <h5>Ações rápidas</h5>
        <a href='colaboradores.php' class='btn btn-eta mb-2'>Gerenciar Colaboradores</a>
        <a href='users.php' class='btn btn-eta mb-2'>Gerenciar Usuários</a>
      </div>
    </div>
  </div>
</div>

<script>
// Data from PHP
const cntAtivos = <?php echo intval($cnt_ativos); ?>;
const cntDeslig = <?php echo intval($cnt_deslig); ?>;
const cntDocs = <?php echo intval($cnt_docs); ?>;

// Status pie chart
const ctxStatus = document.getElementById('statusChart').getContext('2d');
new Chart(ctxStatus, {
  type: 'pie',
  data: {
    labels: ['Ativo', 'Desligado'],
    datasets: [{
      data: [cntAtivos, cntDeslig],
      backgroundColor: ['#25499B', '#556049'],
      hoverOffset: 6
    }]
  },
  options: {
    plugins: { legend: { position: 'bottom' } }
  }
});

// Docs simple bar (shows total only as single bar for visual)
const ctxDocs = document.getElementById('docsChart').getContext('2d');
new Chart(ctxDocs, {
  type: 'bar',
  data: {
    labels: ['Documentos'],
    datasets: [{
      label: 'Total de documentos',
      data: [cntDocs],
      backgroundColor: ['#B4C6DC']
    }]
  },
  options: {
    scales: { y: { beginAtZero: true, precision:0 } },
    plugins: { legend: { display: false } }
  }
});
</script>
</body>
</html>