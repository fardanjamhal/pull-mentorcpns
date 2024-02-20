<?php

namespace App\Repositories\Region;

use App\Models\Region\Village;
use App\Repositories\Contracts\Region\VillageInterface;
use App\Repositories\BaseRepository;

class VillageRepository extends BaseRepository implements VillageInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Village;
    }
}
