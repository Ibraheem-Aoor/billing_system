<?php


namespace App\Services\Billar;


use App\Models\Billar\Category\Category;

class CategoryService extends ApplicationBaseService
{
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function setValidation(): self
    {
        $id = $this->model->id ?: '';
        validator(request()->all(), [
            'name' => 'required|max:191|unique:categories,name,' . $id,
        ])->validate();

        return $this;
    }

}