<?php

declare(strict_types=1);
use Phinx\Migration\AbstractMigration;

final class CreateEmpleadoRol extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('empleados_rol', ['id' => false, 'primary_key' => ['empleado_id', 'rol_id']]);
        $table->addColumn('empleado_id', 'integer')
              ->addColumn('rol_id', 'integer')
              ->create();
    }
}