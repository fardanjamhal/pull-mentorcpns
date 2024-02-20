<?php

namespace App\Repositories\Contracts\Region;

interface ProvinceInterface
{
    public function all();

    public function findWhere(array $where);
}
