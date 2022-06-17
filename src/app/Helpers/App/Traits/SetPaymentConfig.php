<?php

namespace App\Helpers\App\Traits;

use App\Helpers\Core\Traits\InstanceCreator;
use App\Models\App\PaymentMethods\PaymentMethod;
use Illuminate\Support\Facades\Artisan;

class SetPaymentConfig
{
    use InstanceCreator;

    public function clear(): self
    {
        Artisan::call('config:clear');
        return $this;
    }

    public function set()
    {


        if (config()->get('services.stripe.payment_method')) {

            $stripe = PaymentMethod::query()
                ->select('alias', 'client_key', 'secret_key')
                ->firstWhere('alias', config()->get('services.stripe.payment_method'));
            config()->set('services.stripe.public_key', $stripe ? $stripe['client_key'] : '');
            config()->set('services.stripe.secret_key', $stripe ? $stripe['secret_key'] : '');
        }

        if (config()->get('services.paypal.payment_method')) {

            $paypal = PaymentMethod::query()
                ->select('alias', 'client_key', 'secret_key', 'mode')
                ->firstWhere('alias', config()->get('services.paypal.payment_method'));
            config()->set('services.paypal.client_id', $paypal ? $paypal['client_key'] : '');
            config()->set('services.paypal.client_secret', $paypal ? $paypal['secret_key'] : '');
            config()->set('services.paypal.mode', $paypal ? $paypal['mode'] : '');

        }

    }
}