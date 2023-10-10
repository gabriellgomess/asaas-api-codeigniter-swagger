<?php
// Path: app/Controllers/Clientes.php

namespace App\Controllers;

use Exception;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ClientesModel;

class Clientes extends ResourceController
{
    protected $modelName = 'App\Models\ClientesModel';
    protected $format    = 'json';

    public function index()
    {
        try {
            $headers = getallheaders();
            $apiKey = $headers['access_token'];
            $clientes = $this->model->buscarClientes($apiKey);

            if (empty($clientes)) {
                return $this->failNotFound('Nenhum cliente encontrado');
            }

            return $this->respond($clientes);
        } catch (Exception $e) {
            // Log do erro
            log_message('error', $e->getMessage());

            // Você pode personalizar a mensagem de erro conforme necessário
            return $this->failServerError('Ocorreu um erro interno');
        }
    }

    public function create()
    {
        try {
            $headers = getallheaders();
            $apiKey = $headers['access_token'];
            $data = $this->request->getJSON();
            $cliente = $this->model->criarCliente($data, $apiKey);

            if ($cliente['httpCode'] != 200) {
                $error = isset($cliente['body']['errors'])
                    ? $cliente['body']['errors'][0]['description']
                    : 'Erro desconhecido';

                return $this->respond([
                    'status' => $cliente['httpCode'],
                    'error' => $error
                ], $cliente['httpCode']);
            }

            return $this->respondCreated($cliente['body']);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError($e->getMessage());
        }
    }


    public function show($id = null)
    {
        try {
            $headers = getallheaders();
            $apiKey = $headers['access_token'];
            $cliente = $this->model->buscarCliente($id, $apiKey);

            if ($cliente['httpCode'] != 200) {
                $error = isset($cliente['body']['errors'])
                    ? $cliente['body']['errors'][0]['description']
                    : 'Erro desconhecido';

                return $this->respond([
                    'status' => $cliente['httpCode'],
                    'error' => $error
                ], $cliente['httpCode']);
            }

            return $this->respond($cliente['body']);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError($e->getMessage());
        }
    }


    public function update($id = null)
    {
        try {
            $headers = getallheaders();
            $apiKey = $headers['access_token'];
            $data = $this->request->getJSON();
            $response = $this->model->atualizarCliente($id, $data, $apiKey);

            if ($response['httpCode'] != 200) {
                $error = isset($response['body']['errors'])
                    ? $response['body']['errors'][0]['description']
                    : 'Erro desconhecido';

                return $this->respond([
                    'status' => $response['httpCode'],
                    'error' => $error
                ], $response['httpCode']);
            }

            return $this->respond($response['body']);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError($e->getMessage());
        }
    }


    public function delete($id = null)
    {
        try {
            $headers = getallheaders();
            $apiKey = $headers['access_token'];
            $response = $this->model->deletarCliente($id, $apiKey);

            if ($response['httpCode'] != 200) {
                $error = isset($response['body']['errors'])
                    ? $response['body']['errors'][0]['description']
                    : 'Erro desconhecido';

                return $this->respond([
                    'status' => $response['httpCode'],
                    'error' => $error
                ], $response['httpCode']);
            }

            return $this->respondDeleted($response['body']);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError($e->getMessage());
        }
    }
}
