<?php

namespace App\Repositories\Lesson;

use App\Models\Lesson\ValueCategory;
use App\Repositories\Contracts\Lesson\ValueCategoryInterface;
use App\Repositories\BaseRepository;

class ValueCategoryRepository extends BaseRepository implements ValueCategoryInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new ValueCategory();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $valueCategories = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $valueCategories->where('name', 'like', '%' . $params->search . '%');
        $valueCategories = $valueCategories->with(['lesson','lesson.lessonCategory', 'lesson.lessonCategory.category'])->orderBy('created_at', 'ASC')->paginate($limit);
       
        $valueCategories->appends([
            'search' => $params->search,
        ]);
        
        return $valueCategories;
    }
}
