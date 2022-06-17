<?php

namespace App\Http\Controllers\Billar;

use App\Filters\Billar\Category\CategoryFilter;
use App\Http\Controllers\Controller;
use App\Models\Billar\Category\Category;
use App\Services\Billar\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(CategoryService $service, CategoryFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }

    public function index()
    {
        return $this->service
            ->filters($this->filter)
            ->orderBy('id', request()->get('orderBy'))
            ->paginate(request('per_page', 10));
    }

    public function store(Request $request)
    {
        $this->service
            ->setValidation()
            ->setAttributes($request->only('name'))
            ->save();
        return created_responses('categories');
    }

    public function show($id)
    {
        return $this->service->find($id);
    }

    public function update(Request $request, Category $category)
    {
        $this->service
            ->setModel($category)
            ->setValidation()
            ->setAttributes($request->only('name'))
            ->update();

        return updated_responses('categories');
    }

    public function destroy(Category $category)
    {
        $this->service
            ->setModel($category)
            ->delete();
        return deleted_responses('categories');
    }
}
