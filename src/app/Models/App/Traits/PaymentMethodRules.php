<?php


namespace App\Models\App\Traits;


trait PaymentMethodRules
{
    public function createdRules(): array
    {
//        return [
//            'name' => 'required',
//            'type' => 'required',
//            'is_default' => 'required',
//            'client_id' => 'required_if:type,==,paypal',
//            'mode' => 'required_if:type,==,paypal',
//            'public_key' => 'required_if:type,==,stripe',
//            'secret_key' => 'required_if:type,==,paypal,stripe',
//
//        ];

        $rules['name'] = 'required';
        $rules['type'] = 'required';
        $rules['is_default'] = 'required';
        if (request()->get('type') === 'paypal') {
            $rules['client_id'] = 'required';
            $rules['secret_key'] = 'required';
            $rules['mode'] = 'required|in:production,sandbox';
        } elseif (request()->get('type') === 'stripe') {
            $rules['public_key'] = 'required';
            $rules['secret_key'] = 'required';
        }
        return $rules;
    }

    public function updatedRules(): array
    {
        return $this->createdRules();
    }
}