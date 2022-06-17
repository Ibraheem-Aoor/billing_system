<?php

namespace App\Http\Controllers\Billar\Tax;

use App\Filters\Billar\Tax\TaxFilter;
use App\Http\Controllers\Controller;
use App\Models\Billar\Tax\Tax;
use App\Services\Billar\Tax\TaxService;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function __construct(TaxService $service, TaxFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }
    public function index()
    {
        return $this->service
            ->filters($this->filter)
            ->paginate(request('per_page', 10));
    }

    public function store(Request $request)
    {
        $this->service
            ->setValidation()
            ->setAttributes($request->all())
            ->save();
        return created_responses('tax');
    }

    public function show($id)
    {
        return $this->service->find($id);
    }

    public function update(Request $request, Tax $tax)
    {
        $this->service
            ->setModel($tax)
            ->setValidation()
            ->setAttributes($request->all())
            ->update();

        return updated_responses('tax');
    }

    public function destroy(Tax $tax)
    {
        $this->service
            ->setModel($tax)
            ->delete();
        return deleted_responses('tax');
    }
}
