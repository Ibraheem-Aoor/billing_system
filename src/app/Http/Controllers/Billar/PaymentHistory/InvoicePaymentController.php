<?php

namespace App\Http\Controllers\Billar\PaymentHistory;

use App\Http\Controllers\Controller;
use App\Services\Billar\PaymentHistory\InvoicePaymentService;
use Illuminate\Http\Request;

class InvoicePaymentController extends Controller
{
    public function __construct(InvoicePaymentService $service)
    {
        $this->service = $service;
    }

    public function checkout()
    {
        $paymentType = request('payment_type');

        if ($paymentType == 'stripe') {
            try {
                $this->service->stripePayment();
                return created_responses('payment');

            } catch (\Exception $exception) {
                return [
                    'status' => 500,
                    'error' => $exception->getMessage()
                ];
            }

        } elseif ($paymentType == 'paypal') {
            try {
                $this->service->paypalPayment();
                return created_responses('payment');
            }catch (\Exception $exception){
                return [
                    'status' => 500,
                    'error' => $exception->getMessage()
                ];
            }
        }
    }
}
