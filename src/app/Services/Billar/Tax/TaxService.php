<?php


namespace App\Services\Billar\Tax;


use App\Models\Billar\Tax\Tax;
use App\Services\Billar\ApplicationBaseService;
use App\Services\Core\BaseService;

class TaxService extends ApplicationBaseService
{
    public function __construct(Tax $tax)
    {
        $this->model = $tax;
    }

    public function setValidation(): self
    {
        validator(request()->all(), [
            'name' => 'required|max:191',
            'value' => 'required|max:191',
        ])->validate();

        return $this;
    }
}