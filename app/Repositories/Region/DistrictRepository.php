<?php

namespace App\Repositories\Region;

use App\Models\Region\District;
use App\Repositories\Contracts\Region\DistrictInterface;
use App\Repositories\BaseRepository;

class DistrictRepository extends BaseRepository implements DistrictInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new District();
    }
}
