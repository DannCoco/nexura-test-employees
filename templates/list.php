<?php
// defensive defaults
$list = $list ?? [];
?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Empleados</h5>
    <table class="table">
      <thead>
        <tr><th>Nombre</th><th>Area</th><th>Email</th><th>Sexo</th><th>Boletín</th><th>Roles</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach($list as $row): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
            <td><?php echo htmlspecialchars($row['area_nombre']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['sexo']); ?></td>
            <td><?php echo $row['boletin'] ? 'Sí' : 'No'; ?></td>
            <?php $rowRoles = is_array($row['roles'] ?? null) ? $row['roles'] : []; ?>
            <td><?php echo htmlspecialchars(implode(', ', array_map(fn($r)=>$r['nombre'], $rowRoles))); ?></td>
            <td>
              <a class="btn btn-sm btn-secondary" href="/?path=empleados/edit&id=<?php echo $row['id']; ?>">Editar</a>
              <form method="post" action="/?path=empleados/delete" style="display:inline" onsubmit="return confirm('¿Eliminar empleado?');">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button class="btn btn-sm btn-danger">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
 
