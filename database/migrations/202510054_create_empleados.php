<?php

declare(strict_types=1);
use Phinx\Migration\AbstractMigration;

final class CreateEmpleados extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('empleados', ['engine' => 'InnoDB']);
        $table->addColumn('nombre', 'string', ['limit' => 100])
              ->addColumn('email', 'string', ['limit' => 150])
              ->addColumn('sexo', 'char', ['limit' => 1])
              ->addColumn('area_id', 'integer', ['signed' => false])
              ->addColumn('boletin', 'integer', ['default' => 0])
              ->addColumn('descripcion', 'text')
              ->addColumn('salario', 'decimal', ['precision' => 10, 'scale' => 2])
              ->addTimestamps()
              ->addForeignKey('area_id', 'areas', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
              ->create();
    }
}