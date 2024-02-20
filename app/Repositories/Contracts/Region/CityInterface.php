<?php

namespace App\Repositories\Contracts\Region;

interface CityInterface
{
    public function all();

    public function findWhere(array $where);
}
