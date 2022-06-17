<?php

namespace App\Http\Controllers\Billar\Product;

use App\Filters\Billar\Product\ProductFilter;
use App\Http\Controllers\Controller;
use App\Models\Billar\Product\Product;
use App\Services\Billar\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(ProductService $service, ProductFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }

    public function index()
    {
        if (\Request::exists('all')) {
            return $this->service->select('id', 'name', 'unit_price')->get();
        }
        return $this->service
            ->with('category:id,name', 'file', 'invoiceDetails:id,product_id')
            ->filters($this->filter)
            ->orderBy('id', request()->get('orderBy'))
            ->paginate(request('per_page', 10));
    }

    public function store(Request $request)
    {
        $this->service
            ->setValidation()
            ->setAttributes($request->all())
            ->save();
        $this->service->when($request->has('image'), fn(ProductService $service) => $service->image($request->image));

        return created_responses('products');
    }

    public function show($id)
    {
        return $this->service->with('category', 'file')->find($id);
    }

    public function update(Request $request, Product $product)
    {
        $this->service
            ->setModel($product)
            ->setValidation()
            ->setAttributes($request->only('name', 'code', 'category_id', 'unit_price', 'description'))
            ->update();
        $this->service->when($request->has('image'), fn(ProductService $service) => $service->image($request->image));

        return updated_responses('products');
    }

    public function destroy(Product $product)
    {
        $this->service
            ->setModel($product)
            ->unlinkImage()
            ->deleteFileDatabase()
            ->delete();
        return deleted_responses('products');
    }
}
