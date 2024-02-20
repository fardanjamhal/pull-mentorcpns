<?php

namespace App\Repositories\Contracts\Region;

interface DistrictInterface
{
    public function all();

    public function findWhere(array $where);
}
