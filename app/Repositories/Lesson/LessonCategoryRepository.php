<?php

namespace App\Repositories\Lesson;

use App\Models\Lesson\LessonCategory;
use App\Repositories\Contracts\Lesson\LessonCategoryInterface;
use App\Repositories\BaseRepository;
use App\Services\UploadService;

class LessonCategoryRepository extends BaseRepository implements LessonCategoryInterface
{
    /**
     * @var
     */
    protected $model;

    protected $image_path = 'upload_files/lesson_categories';

    public function __construct()
    {
        $this->model = new LessonCategory();
    }

    public function all($columns =  ['*'])
    {
        return $this->model->with(['category'])->orderBy('created_at', 'ASC')->get($columns);
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $lessonCategories = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $lessonCategories->where('name', 'like', '%' . $params->search . '%');
        $lessonCategories = $lessonCategories->with('category')->orderBy('created_at', 'ASC')->paginate($limit);

        $lessonCategories->appends([
            'search' => $params->search,
        ]);

        return $lessonCategories;
    }

    public function getLessonData($id)
    {
        return $this->model->with(['lesson'])->find($id);
    }

    public function getAllByCategory($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->orderBy('created_at', 'ASC')->get();
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
        $lessonCategory = $this->model->find($id);
        $input = $attributes->all();

        if($attributes->hasFile('thumbnail')){
            $file = $attributes->file('thumbnail')->getClientOriginalName();
            $filename = (new UploadService())->uploadFile($attributes->file('thumbnail'), $this->image_path);
            (new UploadService())->deleteFile($lessonCategory->thumbnail, $this->image_path);
            $input['thumbnail'] = $filename;
        } else {
            $input['thumbnail'] = $lessonCategory->thumbnail;
        }

        return $lessonCategory->update($input);
    }

    public function delete($id)
    {
        $lessonCategory = $this->model->find($id);
        (new UploadService())->deleteFile($lessonCategory->thumbnail, $this->image_path);
        return $lessonCategory->delete();
    }
}
