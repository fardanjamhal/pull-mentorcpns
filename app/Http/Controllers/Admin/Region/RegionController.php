<?php

namespace App\Http\Controllers\Admin\Region;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Region\{ProvinceRepository, CityRepository, DistrictRepository, VillageRepository};

class RegionController extends Controller
{
    public function province()
    {
        return (new ProvinceRepository())->all();
    }

    /**
     * get city order by id provinsi
     *
     * @param $id
     * @return void
     */
    public function city($id)
    {
        return (new CityRepository())->findWhere(['province_id' => $id])->get();
    }

    /**
     * get district order by id city
     *
     * @param $id
     * @return void
     */
    public function district($id)
    {
        return (new DistrictRepository())->findWhere(['city_id' => $id])->get();
    }

    /**
     * get village order by id district
     *
     * @param $id
     * @return void
     */
    public function village($id)
    {
        return (new VillageRepository())->findWhere(['district_id' => $id])->get();
    }
}
