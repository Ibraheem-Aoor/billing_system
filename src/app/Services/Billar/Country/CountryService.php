<?php


namespace App\Services\Billar\Country;


use App\Models\Billar\Country\Country;
use App\Services\Billar\ApplicationBaseService;

class CountryService extends ApplicationBaseService
{
    public function __construct(Country $country)
    {
        $this->model = $country;
    }
}