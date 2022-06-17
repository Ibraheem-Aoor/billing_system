<?php


namespace App\Filters\Billar\Category;


use App\Filters\Billar\Traits\DateRangeFilter;
use App\Filters\Billar\Traits\NameFilterTrait;
use App\Filters\FilterBuilder;

class CategoryFilter extends FilterBuilder
{
    use NameFilterTrait, DateRangeFilter;
}