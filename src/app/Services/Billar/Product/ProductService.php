<?php


namespace App\Services\Billar\Product;


use App\Helpers\Core\Traits\FileHandler;
use App\Helpers\Core\Traits\HasWhen;
use App\Models\Billar\Product\Product;
use App\Services\Billar\ApplicationBaseService;


class ProductService extends ApplicationBaseService
{
    use HasWhen, FileHandler;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function setValidation(): self
    {
        $id = $this->model->id ?: '';
        validator(request()->all(), [
            'name' => 'required|max:191',
            'code' => 'required|max:191|unique:products,code,' . $id,
            'unit_price' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            //'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|size:2048|dimensions:min_width=200,min_height=200,max_width=200,max_height=200',
        ])->validate();

        return $this;
    }

    public function image($request): self
    {
        $this->unlinkImage();

        $file_path = $this->uploadImage(
            $request,
            'product'
        );
        $this->model->file()->updateOrCreate([
            'type' => 'product',
        ], [
            'path' => $file_path
        ]);

        return $this;
    }

    public function unlinkImage(): self
    {
        $this->deleteImage(optional($this->model->file)->path);

        return $this;
    }

    public function deleteFileDatabase(): self
    {
        $this->model->file()->delete();

        return $this;
    }

}