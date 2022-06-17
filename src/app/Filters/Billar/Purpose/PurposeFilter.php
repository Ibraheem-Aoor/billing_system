<?php

namespace App\Filters\Billar\Purpose;

use App\Filters\Billar\Traits\DateRangeFilter;
use App\Filters\Billar\Traits\NameFilterTrait;
use App\Filters\FilterBuilder;

class PurposeFilter extends FilterBuilder
{
    use NameFilterTrait, DateRangeFilter;
}