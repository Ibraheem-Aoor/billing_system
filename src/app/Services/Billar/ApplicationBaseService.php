<?php


namespace App\Services\Billar;


use App\Services\Core\BaseService;

class ApplicationBaseService extends BaseService
{
    public function update(): self
    {
        $this->model->fill($this->getAttributes())->save();

        return $this;
    }
}