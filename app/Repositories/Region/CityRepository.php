<?php

namespace App\Repositories\Region;

use App\Models\Region\City;
use App\Repositories\Contracts\Region\CityInterface;
use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository implements CityInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new City();
    }
}
