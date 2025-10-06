<?php

require_once __DIR__ . '/../src/bootstrap.php';
use App\Controller\EmpleadoController;

$path = $_GET['path'] ?? 'empleados';
$method = $_SERVER['REQUEST_METHOD'];

$controller = new EmpleadoController();

if ($path === 'empleados' && $method === 'GET') {
    $controller->index();
} elseif ($path === 'empleados/create' && $method === 'GET') {
    $controller->create();
} elseif ($path === 'empleados/store' && $method === 'POST') {
    $controller->store();
} elseif ($path === 'empleados/edit' && $method === 'GET') {
    $controller->edit($_GET['id'] ?? null);
} elseif ($path === 'empleados/update' && $method === 'POST') {
    $controller->update();
} elseif ($path === 'empleados/delete' && $method === 'POST') {
    $controller->delete();
} else {
    http_response_code(404);
    echo "Página no encontrada";
}