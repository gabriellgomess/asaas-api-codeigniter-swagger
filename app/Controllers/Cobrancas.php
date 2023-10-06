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

            if (empty($cobranca)) {
                return $this->failServerError('Não foi possível criar a cobranca');
            }

            return $this->respondCreated($cobranca);
        } catch (Exception $e) {
            // Log do erro
            log_message('error', $e->getMessage());

            // Você pode personalizar a mensagem de erro conforme necessário
            return $this->failServerError('Ocorreu um erro interno');
        }
    }

    public function show($id = null)
    {
        try {
            $headers = getallheaders();
            $apiKey = $headers['access_token'];
            $cobranca = $this->model->buscarCobranca($id, $apiKey);

            if (empty($cobranca)) {
                return $this->failNotFound('cobrança não encontrada');
            }

            return $this->respond($cobranca);
        } catch (Exception $e) {
            // Log do erro
            log_message('error', $e->getMessage());

            // Você pode personalizar a mensagem de erro conforme necessário
            return $this->failServerError('Ocorreu um erro interno');
        }
    }

    public function update($id = null)
    {
        try {
            $headers = getallheaders();
            $apiKey = $headers['access_token'];
            $data = $this->request->getJSON();
            $cobranca = $this->model->atualizarCobranca($id, $data, $apiKey);

            // Verifica se o código HTTP é 200 e se o corpo da resposta contém detalhes de sucesso
            if (
                $cobranca['httpCode'] == 200 && // Aqui você pode adicionar condições para verificar a resposta
                !empty($cobranca['body'])
            ) {    // Verifique se o corpo da resposta contém os detalhes necessários
                return $this->respond($cobranca['body']);
            }

            return $this->failServerError('Não foi possível atualizar a cobranca');
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError('Ocorreu um erro interno');
        }
    }

    public function delete($id = null)
    {
        try {
            $headers = getallheaders();
            $apiKey = $headers['access_token'];
            $cobranca = $this->model->deletarCobranca($id, $apiKey);

            // Verifica se o código HTTP é 200 e se o corpo da resposta contém detalhes de sucesso
            if (
                $cobranca['httpCode'] == 200 && // Aqui você pode adicionar condições para verificar a resposta
                !empty($cobranca['body'])
            ) {    // Verifique se o corpo da resposta contém os detalhes necessários
                return $this->respondDeleted($cobranca['body']);
            }

            return $this->failServerError('Não foi possível deletar a cobranca');
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError('Ocorreu um erro interno');
        }
    }
}
