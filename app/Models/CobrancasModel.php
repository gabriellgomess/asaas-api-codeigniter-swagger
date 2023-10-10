<?php

// Path: app/Models/CobrancasModel.php

namespace App\Models;

use CodeIgniter\Model;
use Exception;



class CobrancasModel extends Model
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
            return [
                'body' => json_decode($response, true),
                'httpCode' => $httpCode
            ];
        }

        return [
            'body' => json_decode($response, true),
            'httpCode' => $httpCode
        ];
    }

    public function buscarCobrancas($apiKey)
    {
        return $this->executeCurl(env('app.AsaasURL') . 'payments', 'GET', null, $apiKey);
    }

    public function buscarCobranca($id, $apiKey)
    {
        return $this->executeCurl(env('app.AsaasURL') . 'payments/' . $id, 'GET', null, $apiKey);
    }

    public function criarCobranca($data, $apiKey)
    {
        return $this->executeCurl(env('app.AsaasURL') . 'payments', 'POST', $data, $apiKey);
    }

    public function atualizarCobranca($id, $data, $apiKey)
    {
        return $this->executeCurl(env('app.AsaasURL') . 'payments/' . $id, 'PUT', $data, $apiKey);
    }

    public function cancelarCobranca($id, $apiKey)
    {
        return $this->executeCurl(env('app.AsaasURL') . 'payments/' . $id, 'DELETE', null, $apiKey);
    }
}
