<?php

namespace App\Repositories\Material;

use App\Models\Material\VideoModule;
use App\Repositories\Contracts\Material\VideoModuleInterface;
use App\Repositories\BaseRepository;

class VideoModuleRepository extends BaseRepository implements VideoModuleInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new VideoModule();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $videoModules = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $videoModules->where('title', 'like', '%' . $params->search . '%');
        $videoModules = $videoModules->with('category')->orderBy('created_at', 'ASC')->paginate($limit);

        $videoModules->appends([
            'search' => $params->search,
        ]);

        return $videoModules;
    }

    public function create($attributes)
    {
        $input = $attributes->all();

        $memberCategories = [];

        if($attributes->member_categories) {
            foreach ($attributes->member_categories as $subCategory) {
                $memberCategories[] = $subCategory['name'];
            }
    
            $input['member_categories'] = $memberCategories;
        } else {
            $input['member_categories'] = null;
        }

        $videoModule = $this->model->create($input);

        return $videoModule;
    }

    public function update($attributes, $id)
    {
        $input = $attributes->except('_token','_method');
        $videoModule = $this->find($id);

        $memberCategories = [];

        if($attributes->member_categories) {
            foreach ($attributes->member_categories as $subCategory) {
                $memberCategories[] = $subCategory['name'];
            }
    
            $input['member_categories'] = $memberCategories;
        } else {
            $input['member_categories'] = null;
        }

        $videoModule->update($input);

        return $videoModule;
    }
}
