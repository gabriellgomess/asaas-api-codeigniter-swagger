<?php
// Path: app/Controllers/Asaas.php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AsaasModel;

class Asaas extends ResourceController
{
    protected $modelName = 'App\Models\AsaasModel';
    protected $format    = 'json';

    public function index()
    {
        $clientes = $this->model->buscarClientes();

        if (!$clientes) {
            return $this->failNotFound('Nenhum cliente encontrado');
        }

        return $this->respond($clientes);
    }

    

    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->failValidationError('Nenhum dado fornecido');
        }

        $cliente = $this->model->criarCliente($data);

        if (!$cliente) {
            return $this->failServerError('Falha ao criar cliente');
        }

        return $this->respondCreated($cliente, 'Cliente criado com sucesso');
    }

}
