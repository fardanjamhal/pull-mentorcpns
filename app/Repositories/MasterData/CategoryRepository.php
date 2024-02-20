<?php

namespace App\Repositories\MasterData;

use App\Models\MasterData\Category;
use App\Repositories\Contracts\MasterData\CategoryInterface;
use App\Repositories\BaseRepository;
use App\Services\UploadService;

class CategoryRepository extends BaseRepository implements CategoryInterface
{
    /**
     * @var
     */
    protected $model;

    protected $image_path = 'upload_files/categories';

    public function __construct()
    {
        $this->model = new Category();
    }

    public function all($columns = ['*'])
    {
        return $this->model->orderBy('created_at', 'ASC')->get($columns);
    }

    public function getAllProduction()
    {
        return $this->model->where('development_status', 'production')->orderBy('created_at', 'ASC')->get();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $categories = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $categories->where('name', 'like', '%' . $params->search . '%');
        $categories = $categories->orderBy('created_at', 'ASC')->paginate($limit);

        $categories->appends([
            'search' => $params->search,
        ]);

        return $categories;
    }

    public function create($attributes)
    {
        $input = $attributes->all();

        if($attributes->hasFile('thumbnail')){
            $file = $attributes->file('thumbnail')->getClientOriginalName();
            $filename = (new UploadService())->uploadFile($attributes->file('thumbnail'), $this->image_path);
            $input['thumbnail'] = $filename;
        }

        return $this->model->create($input);
    }

    public function update($attributes, $id)
    {
        $category = $this->model->find($id);
        $input = $attributes->all();

        if($attributes->hasFile('thumbnail')){
            $file = $attributes->file('thumbnail')->getClientOriginalName();
            $filename = (new UploadService())->uploadFile($attributes->file('thumbnail'), $this->image_path);
            (new UploadService())->deleteFile($category->thumbnail, $this->image_path);
            $input['thumbnail'] = $filename;
        } else {
            $input['thumbnail'] = $category->thumbnail;
        }

        return $category->update($input);
    }

    public function delete($id)
    {
        $category = $this->model->find($id);
        (new UploadService())->deleteFile($category->thumbnail, $this->image_path);
        return $category->delete();
    }

    public function getCategoryModules()
    {
        return $this->model->with(['module' => function($query) {
            $query->orderBy('created_at', 'ASC');
        }])
        ->whereHas('module')
        ->where('development_status', 'production')
        ->orderBy('created_at', 'ASC')
        ->get();
    }

    public function getCategoryVideoModules()
    {
        return $this->model->with(['videoModule' => function($query) {
            $query->orderBy('created_at', 'ASC');
        }])
        ->whereHas('videoModule')
        ->where('development_status', 'production')
        ->orderBy('created_at', 'ASC')
        ->get();
    }
}
