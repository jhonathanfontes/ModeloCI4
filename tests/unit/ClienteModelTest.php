<?php

namespace Tests\Unit;

use App\Modulos\Cadastro\Models\ClienteModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class ClienteModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $namespace = 'App';

    public function testClienteInsertValidation(): void
    {
        $model = new ClienteModel();

        $data = [
            'EMPRESA_ID' => 1,
            'NOME' => 'Cliente Teste',
            'TIPO_ID' => 1,
            'SITUACAO_ID' => 1,
        ];

        $result = $model->insert($data);
        if ($result === false) {
            var_dump($model->errors());
        }

        $this->assertNotFalse($result);
    }
}
