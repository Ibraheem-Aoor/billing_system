<?php

namespace App\Http\Controllers\Billar\Currency;

use App\Http\Controllers\Controller;
use App\Models\Billar\Currency\Currency;
use App\Services\Billar\Currency\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __construct(CurrencyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service
            ->paginate(request('per_page', 10));
    }


    public function store(Request $request)
    {
        $this->service
            ->setValidation()
            ->setAttributes($request->all())
            ->save();

        return created_responses('currency');
    }


    public function show($id)
    {
        return $this->service->find($id);
    }


    public function update(Request $request, Currency $currency)
    {
        $this->service
            ->setModel($currency)
            ->setValidation()
            ->setAttributes($request->all())
            ->update();

        return updated_responses('currency');
    }


    public function destroy(Currency $currency)
    {
        $this->service
            ->setModel($currency)
            ->delete();

        return deleted_responses('currency');
    }
}
