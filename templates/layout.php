<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Prueba técnica - Empleados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <header class="mb-4">
    <h1>Prueba técnica - Empleados</h1>
    <nav><a href="/?path=empleados" class="btn btn-sm btn-outline-primary">Listar</a> <a href="/?path=empleados/create" class="btn btn-sm btn-primary">Crear</a></nav>
  </header>
  <?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
  <?php if(!empty($_SESSION['flash'])): ?>
    <?php
      $flash = $_SESSION['flash'];
      if (is_array($flash)) {
        $flashType = $flash['type'] ?? 'info';
        $flashMsg = $flash['msg'] ?? '';
      } else {
        $flashType = 'success';
        $flashMsg = (string)$flash;
      }
    ?>
    <div class="mt-3 alert alert-<?php echo htmlspecialchars($flashType); ?>">
      <?php echo htmlspecialchars($flashMsg); ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
  <?php endif; ?>
  <main>
    <?php echo $content ?? ''; ?>

  </main>
<?php include __DIR__ . '/footer.php'; ?>