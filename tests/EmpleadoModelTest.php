<?php
namespace Tests;
use PHPUnit\Framework\TestCase;
use App\Model\Empleado;
use App\Model\Area;

class EmpleadoModelTest extends TestCase
{
    public function testCreateAndList() {
        $area = new Area();
        $areas = $area->all();
        $areaId = $areas[0]['id'] ?? null;
        $this->assertNotNull($areaId, 'Se requiere al menos un área en seed');

        $model = new Empleado();
        $data = [
            'nombre' => 'Test Usuario',
            'email' => 'test@example.com',
            'sexo' => 'M',
            'area_id' => $areaId,
            'boletin' => 1,
            'descripcion' => 'Descripcion test'
        ];
        $res = $model->insert($data);
        $this->assertTrue($res);
        $list = $model->listWithAreaAndRoles();
        $this->assertIsArray($list);
    }
}
