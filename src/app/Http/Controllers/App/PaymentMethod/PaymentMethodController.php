<?php

namespace App\Http\Controllers\App\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\PaymentMethodRequest;
use App\Models\App\PaymentMethods\PaymentMethod;
use App\Repositories\Core\Status\StatusRepository;
use App\Services\App\PaymentMethod\PaymentMethodService;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    public function __construct(PaymentMethodService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service
            ->latest()
            ->with(['status'])
            ->paginate(
                request()->get('per_page', 10)
            );
    }

    public function store(PaymentMethodRequest $request)
    {
        $status = resolve(StatusRepository::class)->payment_methodActive();

        $attributes = array_merge($request->only('name', 'type', 'is_default', 'mode'), [
            'status_id' => $status,
            'alias' => $request->type,
            'client_key' => $request->type == 'stripe' ? $request->public_key : $request->client_id,
            'secret_key' => $request->secret_key,
            'created_by' => auth()->id(),
        ]);

        $paymentMethod = $this->service
            ->setAttributes($attributes)
            ->save();

        return created_responses('payment_method', ['payment_method' => $paymentMethod]);

    }


    public function show(PaymentMethod $paymentMethod)
    {
        return $this->service
            ->getDataWithFormattedSetting($paymentMethod);
    }

    public function update(PaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $request['client_key'] = $request->type == 'stripe' ? $request->public_key : $request->client_id;
        $this->service
            ->setModel($paymentMethod)
            ->save($request->all());

        return updated_responses('payment_method', ['payment_method' => $paymentMethod]);

    }


    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->settings()->delete();
        $paymentMethod->delete();

        return deleted_responses('payment_method');
    }

    public function paymentMethodStatus()
    {
        return $this->service
            ->getPaymentMethodStatus();
    }
}
