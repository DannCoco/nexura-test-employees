<?php

declare(strict_types=1);
use Phinx\Migration\AbstractMigration;

final class CreateAreas extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('areas', ['engine' => 'InnoDB', 'id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
              ->addColumn('nombre', 'string', ['limit' => 255])
              ->create();
        
              $this->execute("INSERT INTO areas (nombre) VALUES ('Administración'), ('Ventas'), ('Producción'), ('Recursos Humanos'), ('IT')");
    }
}