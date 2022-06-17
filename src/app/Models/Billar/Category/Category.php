<?php

namespace App\Models\Billar\Category;

use App\Models\Billar\Product\Product;
use App\Models\Core\BaseModel;
use App\Models\Core\Traits\BootTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseModel
{
    use HasFactory, BootTrait;

    protected $fillable = ['name', 'created_by'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
