<?php

namespace App\Http\Controllers\Billar\Country;

use App\Http\Controllers\Controller;
use App\Services\Billar\Country\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(CountryService $countryService)
    {
        $this->service = $countryService;
    }

    public function index()
    {
        return $this->service->select('id', 'code', 'name')->get();
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
