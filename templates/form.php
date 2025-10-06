<?php
$isEdit = !empty($old['id']);
$nombre = $old['nombre'] ?? '';
$email = $old['email'] ?? '';
$sexo = $old['sexo'] ?? '';
$area_id = $old['area_id'] ?? '';
$boletin = $old['boletin'] ?? 0;
$descripcion = $old['descripcion'] ?? '';
$selectedRoles = $old['roles'] ?? [];
$errors = $errors ?? [];
// defensive defaults to avoid warnings when controller forgets to pass them
$roles = $roles ?? [];
?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><?php echo $isEdit ? 'Editar' : 'Crear'; ?> empleado</h5>
    <form id="empleadoForm" method="post" action="<?php echo $isEdit ? '/?path=empleados/update' : '/?path=empleados/store'; ?>">
      <?php if($isEdit): ?><input type="hidden" name="id" value="<?php echo htmlspecialchars($old['id']); ?>"><?php endif; ?>
      <div class="mb-3">
        <label class="form-label">Nombre*</label>
        <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre); ?>">
        <?php if(isset($errors['nombre'])): ?><div class="text-danger small"><?php echo $errors['nombre']; ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Email*</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
        <?php if(isset($errors['email'])): ?><div class="text-danger small"><?php echo $errors['email']; ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Sexo*</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="sexo" value="M" <?php if($sexo==='M') echo 'checked'; ?>>
          <label class="form-check-label">M</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="sexo" value="F" <?php if($sexo==='F') echo 'checked'; ?>>
          <label class="form-check-label">F</label>
        </div>
        <?php if(isset($errors['sexo'])): ?><div class="text-danger small"><?php echo $errors['sexo']; ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Area*</label>
        <select name="area_id" class="form-select">
          <option value="">-- seleccionar --</option>
          <?php foreach($areas as $a): ?>
            <option value="<?php echo $a['id']; ?>" <?php if($a['id']==$area_id) echo 'selected'; ?>><?php echo htmlspecialchars($a['nombre']); ?></option>
          <?php endforeach; ?>
        </select>
        <?php if(isset($errors['area_id'])): ?><div class="text-danger small"><?php echo $errors['area_id']; ?></div><?php endif; ?>
      </div>
      <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" name="boletin" value="1" <?php if($boletin) echo 'checked'; ?>>
        <label class="form-check-label">Recibir boletín</label>
      </div>
      <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="4"><?php echo htmlspecialchars($descripcion); ?></textarea>
        <?php if(isset($errors['descripcion'])): ?><div class="text-danger small"><?php echo $errors['descripcion']; ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Roles</label><br>
        <?php foreach($roles as $r): ?>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="roles[]" value="<?php echo $r['id']; ?>" <?php if(in_array($r['id'],$selectedRoles)) echo 'checked'; ?>>
            <label class="form-check-label"><?php echo htmlspecialchars($r['nombre']); ?></label>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="btn btn-primary"><?php echo $isEdit ? 'Actualizar' : 'Crear'; ?></button>
    </form>
  </div>
</div>

<script type="module">
  import { initEmpleadoForm } from '/js/form.js';
  initEmpleadoForm('empleadoForm');
</script>
