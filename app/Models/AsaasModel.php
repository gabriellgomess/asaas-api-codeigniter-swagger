<?php
// Path: app/Models/AsaasModel.php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class AsaasModel extends Model
{
    protected $asaasApiKey = '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAyMjY4MzM6OiRhYWNoX2NiNDhlZjhlLTFmNWQtNDU1Mi04M2QxLWZlOTcyODdlNGMyMA==';

    public function buscarClientes()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.asaas.com/api/v3/customers',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'access_token: '.$this->asaasApiKey
          ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new Exception('Erro ao obter clientes: ' . curl_error($curl));
        }

        curl_close($curl);

        return json_decode($response, true);
    }

    public function criarCliente($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.asaas.com/api/v3/customers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data), 
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'access_token: ' . $this->asaasApiKey
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new Exception('Erro ao criar cliente: ' . curl_error($curl));
        }

        curl_close($curl);

        return json_decode($response, true);
    }
}
