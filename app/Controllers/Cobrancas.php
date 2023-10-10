<?php
// Path: app/Controllers/Cobrancas.php

namespace App\Controllers;

use Exception;
use CodeIgniter\RESTful\ResourceController;
use App\Models\CobrancasModel;

class Cobrancas extends ResourceController
{
    protected $modelName = 'App\Models\CobrancasModel';
    protected $format    = 'json';

    public function index()
    {
        try {
            $headers = getallheaders();
            $apiKey = $headers['access_token'];
            $cobrancas = $this->model->buscarCobrancas($apiKey);

            if (empty($cobrancas)) {
                return $this->failNotFound('Nenhuma cobrança encontrada');
            }

            return $this->respond($cobrancas);
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
            $cobranca = $this->model->criarCobranca($data, $apiKey);

            if ($cobranca['httpCode'] != 200) {
                $error = isset($cobranca['body']['errors'])
                    ? $cobranca['body']['errors'][0]['description']
                    : 'Erro desconhecido';

                return $this->respond([
                    'status' => $cobranca['httpCode'],
                    'error' => $error
                ], $cobranca['httpCode']);
            }

            return $this->respondCreated($cobranca);
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
            $cobranca = $this->model->buscarCobranca($id, $apiKey);

            if ($cobranca['httpCode'] != 200) {
                $error = isset($cobranca['body']['errors'])
                    ? $cobranca['body']['errors'][0]['description']
                    : 'Erro desconhecido';

                return $this->respond([
                    'status' => $cobranca['httpCode'],
                    'error' => $error
                ], $cobranca['httpCode']);
            }

            return $this->respond($cobranca['body']);
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
            $cobranca = $this->model->atualizarCobranca($id, $data, $apiKey);

            if ($cobranca['httpCode'] != 200) {
                $error = isset($cobranca['body']['errors'])
                    ? $cobranca['body']['errors'][0]['description']
                    : 'Erro desconhecido';

                return $this->respond([
                    'status' => $cobranca['httpCode'],
                    'error' => $error
                ], $cobranca['httpCode']);
            }

            return $this->respond($cobranca['body']);
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
            $cobranca = $this->model->deletarCobranca($id, $apiKey);

            if ($cobranca['httpCode'] != 200) {
                $error = isset($cobranca['body']['errors'])
                    ? $cobranca['body']['errors'][0]['description']
                    : 'Erro desconhecido';

                return $this->respond([
                    'status' => $cobranca['httpCode'],
                    'error' => $error
                ], $cobranca['httpCode']);
            }

            return $this->respondDeleted($cobranca['body']);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError($e->getMessage());
        }
    }
}
