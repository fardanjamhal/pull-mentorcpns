<?php

namespace App\Repositories\Lesson;

use App\Models\Lesson\Lesson;
use App\Repositories\Contracts\Lesson\LessonInterface;
use App\Repositories\BaseRepository;
use App\Services\UploadService;

class LessonRepository extends BaseRepository implements LessonInterface
{
    /**
     * @var
     */
    protected $model;

    protected $image_path = 'upload_files/lessons';

    public function __construct()
    {
        $this->model = new Lesson();
    }

    public function all($columns =  ['*'])
    {
        return $this->model->with(['lessonCategory', 'lessonCategory.category'])->orderBy('created_at', 'ASC')->get($columns);
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $lessons = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $lessons->where('name', 'like', '%' . $params->search . '%');
        $lessons = $lessons->with(['lessonCategory', 'lessonCategory.category'])->orderBy('created_at', 'ASC')->paginate($limit);

        $lessons->appends([
            'search' => $params->search,
        ]);

        return $lessons;
    }

    public function getAllByLessonCategory($lessonCategoryId)
    {
        return $this->model->with('lessonCategory', 'lessonCategory.category')->where('lesson_category_id', $lessonCategoryId)->orderBy('created_at', 'ASC')->get();
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
        $lesson = $this->model->find($id);
        $input = $attributes->all();

        if($attributes->hasFile('thumbnail')){
            $file = $attributes->file('thumbnail')->getClientOriginalName();
            $filename = (new UploadService())->uploadFile($attributes->file('thumbnail'), $this->image_path);
            (new UploadService())->deleteFile($lesson->thumbnail, $this->image_path);
            $input['thumbnail'] = $filename;
        } else {
            $input['thumbnail'] = $lesson->thumbnail;
        }

        return $lesson->update($input);
    }

    public function delete($id)
    {
        $lesson = $this->model->find($id);
        (new UploadService())->deleteFile($lesson->thumbnail, $this->image_path);
        return $lesson->delete();
    }
}
