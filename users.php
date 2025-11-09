<?php
session_start();
if (!isset($_SESSION['matricula'])) { header('Location: login.php'); exit(); }
include('../config/db_connect.php');
$isAdmin = isset($_SESSION['nivel']) && $_SESSION['nivel'] === 'admin';

// fetch users
$res = $conn->query("SELECT id, matricula, nivel, criado_em FROM usuarios ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Usuários - RH ETA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{--eta-navy:#25499B;--eta-moss:#556049;--eta-light:#B4C6DC;--eta-bg:#E6E9F1;}
body{background:var(--eta-bg)} .btn-eta{background:var(--eta-navy);color:white;border:none}
.card{border-radius:12px}
</style>
</head>
<body>
<nav class='d-flex justify-content-between align-items-center' style='background:var(--eta-navy);color:white;padding:12px'>
  <div style='margin-left:20px;'><strong>ETA Engenharia - RH</strong></div>
  <div style='margin-right:20px;'>Usuário: <?php echo $_SESSION['matricula']; ?> — <em><?php echo $_SESSION['nivel']; ?></em> <a href='../actions/logout.php' class='btn btn-light btn-sm ms-3'>Sair</a></div>
</nav>
<div class='container mt-4'>
  <div class='d-flex justify-content-between align-items-center mb-3'>
    <h4>Gerenciar Usuários</h4>
    <?php if ($isAdmin): ?>
      <button class='btn btn-eta' data-bs-toggle='modal' data-bs-target='#createModal'>+ Novo Usuário</button>
    <?php endif; ?>
  </div>

  <div class='card p-3 mb-3'>
    <table class='table table-sm'>
      <thead class='table-secondary'><tr><th>Matrícula</th><th>Nível</th><th>Criado em</th><th>Ações</th></tr></thead>
      <tbody>
        <?php while($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['matricula']); ?></td>
            <td><?php echo $row['nivel']; ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($row['criado_em'])); ?></td>
            <td>
              <?php if ($isAdmin): ?>
                <button class='btn btn-sm btn-outline-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-id='<?php echo $row['id']; ?>' data-mat='<?php echo htmlspecialchars($row['matricula']); ?>' data-nivel='<?php echo $row['nivel']; ?>'>Editar</button>
                <button class='btn btn-sm btn-outline-warning' data-bs-toggle='modal' data-bs-target='#pwdModal' data-id='<?php echo $row['id']; ?>'>Alterar Senha</button>
                <?php if ($row['matricula'] !== 'DEV'): ?>
                  <a href='../actions/delete_user.php?id=<?php echo $row['id']; ?>' class='btn btn-sm btn-outline-danger' onclick='return confirm("Deseja excluir este usuário?")'>Excluir</a>
                <?php endif; ?>
              <?php else: ?>
                <?php if ($row['matricula'] === $_SESSION['matricula']): ?>
                  <button class='btn btn-sm btn-outline-warning' data-bs-toggle='modal' data-bs-target='#pwdModal' data-id='<?php echo $row['id']; ?>'>Alterar Senha</button>
                <?php endif; ?>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modals -->
<!-- Create Modal -->
<div class='modal fade' id='createModal' tabindex='-1'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <form action='../actions/create_user.php' method='POST'>
        <div class='modal-header'><h5 class='modal-title'>Novo Usuário</h5><button type='button' class='btn-close' data-bs-dismiss='modal'></button></div>
        <div class='modal-body'>
          <div class='mb-2'><label>Matrícula</label><input name='matricula' class='form-control' required></div>
          <div class='mb-2'><label>Senha</label><input name='senha' type='password' class='form-control' required></div>
          <div class='mb-2'><label>Nível</label><select name='nivel' class='form-select'><option value='usuario'>Usuario</option><option value='admin'>Admin</option></select></div>
        </div>
        <div class='modal-footer'><button class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button><button class='btn btn-eta' type='submit'>Criar</button></div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class='modal fade' id='editModal' tabindex='-1'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <form action='../actions/edit_user.php' method='POST'>
        <div class='modal-header'><h5 class='modal-title'>Editar Usuário</h5><button type='button' class='btn-close' data-bs-dismiss='modal'></button></div>
        <div class='modal-body'>
          <input type='hidden' name='id' id='edit-id'>
          <div class='mb-2'><label>Matrícula</label><input name='matricula' id='edit-mat' class='form-control' required></div>
          <div class='mb-2'><label>Nível</label><select name='nivel' id='edit-nivel' class='form-select'><option value='usuario'>Usuario</option><option value='admin'>Admin</option></select></div>
        </div>
        <div class='modal-footer'><button class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button><button class='btn btn-eta' type='submit'>Salvar</button></div>
      </form>
    </div>
  </div>
</div>

<!-- Password Modal -->
<div class='modal fade' id='pwdModal' tabindex='-1'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <form action='../actions/change_password.php' method='POST'>
        <div class='modal-header'><h5 class='modal-title'>Alterar Senha</h5><button type='button' class='btn-close' data-bs-dismiss='modal'></button></div>
        <div class='modal-body'>
          <input type='hidden' name='id' id='pwd-id'>
          <div class='mb-2'><label>Nova Senha</label><input name='senha' type='password' class='form-control' required></div>
        </div>
        <div class='modal-footer'><button class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button><button class='btn btn-eta' type='submit'>Salvar</button></div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
var editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  document.getElementById('edit-id').value = button.getAttribute('data-id');
  document.getElementById('edit-mat').value = button.getAttribute('data-mat');
  document.getElementById('edit-nivel').value = button.getAttribute('data-nivel');
});
var pwdModal = document.getElementById('pwdModal');
pwdModal.addEventListener('show.bs.modal', function(event){
  var button = event.relatedTarget;
  document.getElementById('pwd-id').value = button.getAttribute('data-id');
});
</script>
</body>
</html>