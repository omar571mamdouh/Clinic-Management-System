<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePaymentRequest;
use App\Models\Appointment;
use App\Services\PaymentService;
use App\Services\PaymobService;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $payments = Payment::with(['appointment.patient', 'appointment.doctor'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('appointment.patient', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('appointment.doctor', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function store(CreatePaymentRequest $request)
    {
        $data = $request->validated();

        $appointment = Appointment::findOrFail($data['appointment_id']);

        $this->paymentService->createForAppointment(
            $appointment,
            $data['amount']
        );

        return redirect()->back()->with('success', 'Payment created');
    }

    public function pay(Payment $payment, PaymobService $paymob)
    {
        // ✅ load العلاقات
        $payment->load('appointment.patient');

        $patient = $payment->appointment->patient;

        $authToken = $paymob->auth();

        $orderId = $paymob->createOrder(
            $authToken,
            $payment->amount,
            $payment->id
        );

        $payment->update(['transaction_id' => $orderId]);

        $billingData = [
            "first_name"   => $patient->name,
            "last_name"    => "Patient",
            "email"        => $patient->email ?? 'no-email@example.com',
            "phone_number" => $patient->phone ?? '0000000000',
            "apartment"    => "NA",
            "floor"        => "NA",
            "street"       => "NA",
            "building"     => "NA",
            "city"         => "Cairo",
            "country"      => "EG",
            "state"        => "Cairo",
        ];

        $paymentToken = $paymob->paymentKey(
            $authToken,
            $orderId,
            $payment->amount,
            $billingData
        );

        $url = $paymob->generateIframeUrl($paymentToken);

        return redirect($url);
    }
}
