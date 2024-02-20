<?php

namespace App\Repositories\Region;

use App\Models\Region\Province;
use App\Repositories\Contracts\Region\ProvinceInterface;
use App\Repositories\BaseRepository;

class ProvinceRepository extends BaseRepository implements ProvinceInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Province();
    }
}
