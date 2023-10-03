<?php

// Path: app/Models/ClientesModel.php

namespace App\Models;

use CodeIgniter\Model;
use Exception;



class ClientesModel extends Model
{
    private function executeCurl($url, $method = 'GET', $data = null, $apiKey)
    {
        $curl = curl_init();

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'access_token: ' . $apiKey // Passando a chave da API no cabeçalho
            ]
        ];

        if ($method == 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        if ($method == 'PUT') {
            $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        if ($method == 'DELETE') {
            $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        }

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($httpCode != 200) {
            throw new Exception('HTTP error code: ' . $httpCode);
        }

        return [
            'body' => json_decode($response, true),
            'httpCode' => $httpCode
        ];
    }

    public function buscarClientes($apiKey) // Adicionando $apiKey como parâmetro
    {
        return $this->executeCurl('https://www.asaas.com/api/v3/customers', 'GET', null, $apiKey);
    }

    public function buscarCliente($id, $apiKey) // Adicionando $apiKey como parâmetro
    {
        return $this->executeCurl('https://www.asaas.com/api/v3/customers/' . $id, 'GET', null, $apiKey);
    }

    public function criarCliente($data, $apiKey) // Adicionando $apiKey como parâmetro
    {
        return $this->executeCurl('https://www.asaas.com/api/v3/customers', 'POST', $data, $apiKey);
    }

    public function atualizarCliente($id, $data, $apiKey) // Adicionando $apiKey como parâmetro
    {
        return $this->executeCurl('https://www.asaas.com/api/v3/customers/' . $id, 'PUT', $data, $apiKey);
    }

    public function deletarCliente($id, $apiKey) // Adicionando $apiKey como parâmetro
    {
        return $this->executeCurl('https://www.asaas.com/api/v3/customers/' . $id, 'DELETE', null, $apiKey);
    }
}
