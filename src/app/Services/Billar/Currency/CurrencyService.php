<?php


namespace App\Services\Billar\Currency;


use App\Models\Billar\Currency\Currency;
use App\Services\Billar\ApplicationBaseService;

class CurrencyService extends ApplicationBaseService
{
    public function __construct(Currency $currency)
    {
        $this->model = $currency;
    }

    public function setValidation(): self
    {
        validator(request()->all(), [
            'name' => 'required|max:191',
            'code' => 'required|max:191'
        ])->validate();

        return $this;
    }
}