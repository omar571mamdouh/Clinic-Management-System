<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}

    public function handle(Request $request)
    {
        Log::info('Webhook received', $request->all());

        $secret = config('services.paymob.hmac_secret');

        // HMAC القادم من Paymob
        $receivedHmac = $request->query('hmac') ?? $request->input('hmac');

        $obj = $request->input('obj');

        // حساب HMAC بالطريقة المطلوبة من Paymob
        $hmacString =
            $obj['amount_cents'] .
            $obj['created_at'] .
            ($obj['currency'] ?? '') .
            ($obj['error_occured'] ? 'true' : 'false') .
            ($obj['has_parent_transaction'] ? 'true' : 'false') .
            $obj['id'] .
            $obj['integration_id'] .
            ($obj['is_3d_secure'] ? 'true' : 'false') .
            ($obj['is_auth'] ? 'true' : 'false') .
            ($obj['is_capture'] ? 'true' : 'false') .
            ($obj['is_refunded'] ? 'true' : 'false') .
            ($obj['is_standalone_payment'] ? 'true' : 'false') .
            ($obj['is_voided'] ? 'true' : 'false') .
            $obj['order']['id'] .
            $obj['owner'] .
            ($obj['pending'] ? 'true' : 'false') .
            $obj['source_data']['pan'] .
            $obj['source_data']['sub_type'] .
            $obj['source_data']['type'] .
            ($obj['success'] ? 'true' : 'false');

        $calculatedHmac = hash_hmac('sha512', $hmacString, $secret);

        if (!$receivedHmac || !hash_equals($calculatedHmac, $receivedHmac)) {

            Log::error('Invalid HMAC', [
                'received'   => $receivedHmac,
                'calculated' => $calculatedHmac,
            ]);

            return response()->json([
                'error' => 'Invalid signature'
            ], 401);
        }

        $merchantOrderId = data_get($obj, 'order.merchant_order_id');

        $payment = Payment::find($merchantOrderId);

        if (!$payment) {
            return response()->json([
                'error' => 'Payment not found'
            ], 404);
        }

        if ($payment->status === 'paid') {
            return response()->json([
                'message' => 'Already processed'
            ]);
        }

        $this->paymentService->markAsPaid($payment);

        return response()->json([
            'success' => true
        ]);
    }
}
