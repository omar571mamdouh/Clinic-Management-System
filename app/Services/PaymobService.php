<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymobService
{
    private $apiKey;
    private $integrationId;
    private $iframeId;

    public function __construct()
    {
        $this->apiKey = env('PAYMOB_API_KEY');
        $this->integrationId = env('PAYMOB_INTEGRATION_ID');
        $this->iframeId = env('PAYMOB_IFRAME_ID');
    }

    // 1. Auth Token
    public function auth()
    {
        $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => $this->apiKey
        ]);

        return $response['token'];
    }

    // 2. Create Order
    public function createOrder($token, $amount, $merchantOrderId)
    {
        $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', [
            'auth_token'       => $token,
            'delivery_needed'  => false,
            'amount_cents'     => $amount * 100,
            'currency'         => 'EGP',
            'merchant_order_id' => $merchantOrderId . '_' . time(),
            'items'            => [],
        ]);

        if (!$response->successful()) {
            dd($response->json());
        }

        return $response->json()['id'];
    }

    // 3. Payment Key
    public function paymentKey($token, $orderId, $amount, $billingData)
    {
        $response = Http::post(
            'https://accept.paymob.com/api/acceptance/payment_keys',
            [
                'auth_token'    => $token,
                'amount_cents'  => $amount * 100,
                'order_id'      => $orderId,
                'integration_id' => (int) $this->integrationId,
                'currency'      => 'EGP',
                'billing_data'  => $billingData,
            ]
        );

        if (!$response->successful()) {
            dd($response->json()); // لو فيه خطأ من Paymob هيظهر سببه
        }

        return $response->json()['token'];
    }

    // 4. Generate iframe URL
    public function generateIframeUrl($paymentToken)
    {
        return "https://accept.paymob.com/api/acceptance/iframes/{$this->iframeId}?payment_token={$paymentToken}";
    }
}
