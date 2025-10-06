<?php

declare(strict_types=1);
use Phinx\Migration\AbstractMigration;

final class CreateRoles extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('roles');
        $table->addColumn('nombre', 'string', ['limit' => 50])
              ->create();
              $this->execute("INSERT INTO roles (nombre) VALUES ('Administrador'), ('Analista'), ('Gerente'), ('Soporte');");
    }
}