<?php

require_once __DIR__ . '/../../config/env.php';

class PayPalService {

    private $clienteId;
    private $secret;
    private $base;

    public function __construct() {
        $this->clienteId = $_ENV['PAYPAL_CLIENT_ID'];
        $this->secret = $_ENV['PAYPAL_SECRET'];
        $this->base = $_ENV['PAYPAL_BASE_URL'];
    }

    private function getAccessToken() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->base . "/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_USERPWD, $this->clienteId . ":" . $this->secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $data = json_decode($response, true);

        return $data['access_token'] ?? null;
    }

    public function createOrder($amount) {

        $token = $this->getAccessToken();

        if (!$token) {
            return ['error' => 'No se pudo obtener token PayPal'];
        }

        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "MXN",
                        "value" => $amount
                    ]
                ]
            ]
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->base . "/v2/checkout/orders");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "Authorization: Bearer " . $token
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return ['error' => curl_error($ch)];
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    public function captureOrder($orderID) {
        
        $token = $this->getAccessToken();

        if (!$token) {
            return ['error' => 'No se pudo obtener token PayPal'];
        }

        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $this->base . "/v2/checkout/orders/" . $orderID . "/capture");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "Authorization: Bearer " . $token
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return ['error' => curl_error($ch)];
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
