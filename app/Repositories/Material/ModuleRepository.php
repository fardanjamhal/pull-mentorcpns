<?php

namespace App\Repositories\Material;

use App\Models\Material\Module;
use App\Repositories\Contracts\Material\ModuleInterface;
use App\Repositories\BaseRepository;

class ModuleRepository extends BaseRepository implements ModuleInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Module();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $modules = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $modules->where('title', 'like', '%' . $params->search . '%');
        $modules = $modules->with('category')->orderBy('created_at', 'ASC')->paginate($limit);

        $modules->appends([
            'search' => $params->search,
        ]);

        return $modules;
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

        $module = $this->model->create($input);

        return $module;
    }

    public function update($attributes, $id)
    {
        $input = $attributes->except('_token','_method');
        $module = $this->find($id);

        $memberCategories = [];

        if($attributes->member_categories) {
            foreach ($attributes->member_categories as $subCategory) {
                $memberCategories[] = $subCategory['name'];
            }
    
            $input['member_categories'] = $memberCategories;
        } else {
            $input['member_categories'] = null;
        }

        $module->update($input);

        return $module;
    }
}
