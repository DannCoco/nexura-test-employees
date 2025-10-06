# Prueba Técnica PHP — CRUD de Empleados (PHP puro, ORM propio)

**Descripción breve**
Aplicación CRUD para la gestión de empleados desarrollada en PHP puro, con un ORM propio ligero, migraciones automatizadas con Phinx y pruebas unitarias con PHPUnit. El proyecto sigue principios de **Clean Code** y buenas prácticas (validaciones cliente/servidor, mensajes flash y separación MVC mínima).

**Características principales**
- PHP 8+ (sin framework)
- ORM propio basado en PDO (ActiveRecord-like)
- Migraciones con Phinx
- Tests con PHPUnit
- Interfaz ligera con Bootstrap 5
- Cobertura del diccionario de datos: `areas`, `roles`, `empleados`, `empleado_rol` (relación N:N)

---

## Requisitos
- PHP 8.1 o superior
- Composer 2.x
- MySQL 8 o compatible
- Navegador web moderno

## Instalación y ejecución (manual, sin Docker)

1. Descargar o clonar el repositorio y situarse en la carpeta raíz del proyecto:
   ```bash
   git clone <repo-url>  # o descomprimir el ZIP
   cd nexura-test-employees
   ```

2. Instalar dependencias PHP con Composer:
   ```bash
   composer install
   ```

3. Crear la base de datos (puede usar phpMyAdmin o línea de comandos):
   ```bash
   mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS nexura_test_employees CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```

4. Verificar y, si es necesario, ajustar las credenciales de conexión en `src/Config.php`:
   ```php
   class Config {
       const DB_HOST = '127.0.0.1';
       const DB_NAME = 'nexura_test_employees';
       const DB_USER = 'root';
       const DB_PASS = '';
       const DB_CHAR = 'utf8mb4';
   }
   ```

5. Ejecutar las migraciones (Phinx):
   ```bash
   vendor/bin/phinx migrate -e development
   ```

6. Levantar el servidor de desarrollo embebido de PHP:
   ```bash
   php -S localhost:8080 -t public
   ```

7. Abrir la aplicación en el navegador:
   ```text
   http://localhost:8080/?path=empleados
   ```

## Tests (opcional)
Ejecutar la suite de pruebas PHPUnit:
```bash
vendor/bin/phpunit
```

## Resetear base de datos (opcional)
Para revertir todas las migraciones y aplicarlas de nuevo:
```bash
vendor/bin/phinx rollback -e development -t 0
vendor/bin/phinx migrate -e development
```

## Notas para el evaluador
- El formulario de empleados incluye los cinco tipos requeridos: Text (nombre, email, documento si aplica), Textarea (descripción), Select (área), Radio (sexo), Checkbox (boletín y selección múltiple de roles).  
- Si prefiere ejecutar con Docker, el repositorio incluye versiones previas de `Dockerfile` y `docker-compose.yml` en el historial; contacte al autor si desea la configuración Docker nuevamente.
- Para cualquier duda sobre la estructura o para solicitar cambios (nombres de campos exactos o migraciones adicionales), puedo modificar el proyecto y volver a generar el paquete inmediatamente.
