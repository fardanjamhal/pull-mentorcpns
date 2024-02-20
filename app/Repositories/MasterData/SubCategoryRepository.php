<?php

namespace App\Repositories\MasterData;

use App\Models\MasterData\SubCategory;
use App\Repositories\Contracts\MasterData\SubCategoryInterface;
use App\Repositories\BaseRepository;

class SubCategoryRepository extends BaseRepository implements SubCategoryInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new SubCategory();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $subCategories = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $subCategories->where('name', 'like', '%' . $params->search . '%');
        $subCategories = $subCategories->with('category')->orderBy('created_at', 'ASC')->paginate($limit);

        $subCategories->appends([
            'search' => $params->search,
        ]);

        return $subCategories;
    }
}
