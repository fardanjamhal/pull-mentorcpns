<?php

namespace App\Repositories\Contracts\Region;

interface VillageInterface
{
    public function all();

    public function findWhere(array $where);
}
