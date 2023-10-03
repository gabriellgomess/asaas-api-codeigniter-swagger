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

            if (empty($cliente)) {
                return $this->failServerError('Não foi possível criar o cliente');
            }

            return $this->respondCreated($cliente);
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
            $cliente = $this->model->buscarCliente($id, $apiKey);

            if (empty($cliente)) {
                return $this->failNotFound('Cliente não encontrado');
            }

            return $this->respond($cliente);
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
            $response = $this->model->atualizarCliente($id, $data, $apiKey);

            // Verifica se o código HTTP é 200 e se o corpo da resposta contém detalhes de sucesso
            if (
                $response['httpCode'] == 200 && // Aqui você pode adicionar condições para verificar a resposta
                !empty($response['body'])
            ) {    // Verifique se o corpo da resposta contém os detalhes necessários
                return $this->respond($response['body']);
            }

            return $this->failServerError('Não foi possível atualizar o cliente');
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
            $response = $this->model->deletarCliente($id, $apiKey);

            // Verifica se o código HTTP é 200 e se o corpo da resposta contém detalhes de sucesso
            if (
                $response['httpCode'] == 200 && // Aqui você pode adicionar condições para verificar a resposta
                !empty($response['body'])
            ) {    // Verifique se o corpo da resposta contém os detalhes necessários
                return $this->respondDeleted($response['body']);
            }

            return $this->failServerError('Não foi possível deletar o cliente');
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError('Ocorreu um erro interno');
        }
    }
}
