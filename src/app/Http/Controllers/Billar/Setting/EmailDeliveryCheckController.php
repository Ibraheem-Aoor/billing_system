<?php

namespace App\Http\Controllers\Billar\Setting;

use App\Http\Controllers\Controller;
use App\Services\Billar\Setting\EmailDeliveryCheckService;
use Illuminate\Http\Request;

class EmailDeliveryCheckController extends Controller
{
    public function __construct(EmailDeliveryCheckService $service)
    {
        $this->service = $service;
    }

    public function isExists(): int
    {
        return count($this->service->getCachedMailSettings()) ? 1 : 0;
    }

}
