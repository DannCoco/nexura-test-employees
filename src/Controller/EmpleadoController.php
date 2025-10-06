<?php

namespace App\Controller;
use App\Model\Empleado;
use App\Model\Area;
use App\Model\Rol;
use App\Helpers\Validator;
use App\View;

class EmpleadoController
{
    private Empleado $model;

    public function __construct()
    {
        $this->model = new Empleado();
    }

    public function index(): void
    {
        $list = $this->model->listWithAreaAndRoles();
        View::render('list', ['list' => $list]);
    }

    public function create(): void
    {
        $areaModel = new Area();
        $areas = $areaModel->all();

        $rolModel = new Rol();
        $roles = $rolModel->all();

        View::render('form', ['areas' => $areas, 'roles' => $roles]);
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (!Validator::validateNombre($data['nombre'] ?? '')) {
            $errors['nombre'] = 'Nombre inválido. Solo letras y espacios';
        }

        if (!Validator::validateEmail($data['email'] ?? '')) {
            $errors['email'] = 'Email inválido.';
        }

        if (!in_array($data['sexo'] ?? '', ['M', 'F'])) {
            $errors['sexo'] = 'Sexo inválido. Debe ser M o F.';
        }

        if (!isset($data['area_id']) || !is_numeric($data['area_id']) || $data['area_id'] <= 0) {
            $errors['area_id'] = 'Área requerida.';
        }

        if (!isset($data['boletin'])) {
            $data['boletin'] = 0;
        }

        if (empty($data['descripcion'] ?? '')) {
            $errors['descripcion'] = 'Descripción requerida.';
        }

        return $errors;
    }

    public function store(): void
    {
        try {
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'email' => $_POST['email'] ?? '',
                'sexo' => $_POST['sexo'] ?? '',
                'area_id' => $_POST['area_id'] ?? '',
                'boletin' => isset($_POST['boletin']) ? 1 : 0,
                'descripcion' => $_POST['descripcion'] ?? '',
                'roles' => $_POST['roles'] ?? []
            ];
            $roles = $_POST['roles'] ?? [];
            $errors = $this->validate($data);

            if (!empty($errors)) {
                $areaModel = new Area();
                $areas = $areaModel->all();

                $rolModel = new Rol();
                $allRoles = $rolModel->all();
                $old = $data;
                $old['roles'] = $roles;

                View::render('form', [
                    'areas' => $areas,
                    'roles' => $allRoles,
                    'old' => $old,
                    'errors' => $errors
                ]);

                return;
            }

            $this->model->insert($data);
            $id = $this->model->lastInsertId();
            $this->model->syncRoles($id, $roles);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['flash'] = 'Empleado creado exitosamente.';
            header('Location: /?path=empleados');

        } catch (\Exception $e) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Error: ' . $e->getMessage()];
            header('Location: /?path=empleados');
        }
    }

    public function edit(int $id): void
    {
        if (!$id) {
            header('Location: /?path=empleados');
            exit;
        }

        $empleado = $this->model->find($id);
        $areaModel = new Area();
        $areas = $areaModel->all();
        $rolModel = new Rol();
        $roles = $rolModel->all();

        $selectedRoles = $this->model->getRoles($id);
        $old = $empleado;
        $old['roles'] = array_map(fn($r) => $r['id'], $selectedRoles);
        View::render('form', [
            'areas' => $areas,
            'roles' => $roles,
            'old' => $old
        ]);
    }

    public function update(): void
    {
        try {
            $id = $_POST['id'] ?? null;
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'email' => $_POST['email'] ?? '',
                'sexo' => $_POST['sexo'] ?? '',
                'area_id' => $_POST['area_id'] ?? '',
                'boletin' => isset($_POST['boletin']) ? 1 : 0,
                'descripcion' => $_POST['descripcion'] ?? '',
            ];
            $roles = $_POST['roles'] ?? [];
            $errors = $this->validate($data);
            if (!empty($errors)) {
                $areaModel = new Area();
                $areas = $areaModel->all();
                $rolesModel = new Rol();
                $roles = $rolesModel->all();
                $old = $data;
                $old['id'] = $id;
                $old['roles'] = $roles;

                View::render('form', [
                    'areas' => $areas,
                    'roles' => $roles,
                    'old' => $old,
                    'errors' => $errors
                ]);

                return;
            }

            $this->model->update($id, $data);
            $this->model->syncRoles($id, $roles);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['flash'] = 'Empleado actualizado exitosamente.';
            header('Location: /?path=empleados');

        } catch (\Exception $e) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();    
            }
            $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Error: ' . $e->getMessage()];
            header('Location: /?path=empleados');
        }
    }

    public function delete(): void
    {
        try {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $this->model->delete($id);
                $this->model->prepare("DELETE FROM empleado_rol WHERE empleado_id = ?")->execute([$id]);
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['flash'] = 'Empleado eliminado exitosamente.';
            }
            header('Location: /?path=empleados');
        } catch (\Exception $e) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Error: ' . $e->getMessage()];
            header('Location: /?path=empleados');
        }
    }
}