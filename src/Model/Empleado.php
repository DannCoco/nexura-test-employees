<?php

namespace App\Model;
use App\ORM\BaseModel;
use PDO;

class Empleado extends BaseModel
{
    protected string $table = 'empleados';

    public function listWithAreaAndRoles(): array
    {
        $sql = 'SELECT e.*, a.nombre AS area_nombre FROM empleados e JOIN areas a ON e.area_id = a.id ORDER BY e.id DESC';

        $stmt = $this->pdo->prepare($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as &$row) {
            $stmt = $this->pdo->prepare('SELECT r.id, r.nombre FROM roles r JOIN empleado_rol er ON r.id = er.rol_id WHERE er.empleado_id = ?');
            $stmt->execute([$row['id']]);
            $row['roles'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $rows;
    }

    public function getRoles(int $empleadoId): array
    {
        $stmt = $this->pdo->prepare('SELECT r.* FROM roles r JOIN empleado_rol er ON r.id = er.rol_id WHERE er.empleado_id = ?');
        $stmt->execute([$empleadoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function syncRoles(int $empleadoId, array $roleIds): bool
    {
        $this->pdo->prepare('DELETE FROM empleado_rol WHERE empleado_id = ?')->execute([$empleadoId]);
        
        if (empty($roleIds)) {
            return true;
        }

        $values = [];
        foreach ($roleIds as $roleId) {
            $values[] = "($empleadoId, $roleId)";
        }

        return $this->attachPivot('empleado_rol', ['empleado_id', 'rol_id'], $values);
    }
}