<?php

namespace App\Repositories\Exam;

use App\Models\Exam\ExamGroup;
use App\Models\Exam\Exam;
use App\Repositories\Contracts\Exam\ExamGroupInterface;
use App\Repositories\BaseRepository;
use Auth;

class ExamGroupRepository extends BaseRepository implements ExamGroupInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new ExamGroup();
    }

    public function all($columns = ['*'])
    {
        return $this->model->orderBy('created_at', 'ASC')->get($columns);
    }

    public function getAllSimplePaginatedWithParams($params, $limit = 10)
    {
        $examgroups = $this->model;
        if(isset($params->search) && !empty($params->search)) $examgroups->where('title', 'like', '%' . $params->search . '%');
        $examgroups = $examgroups->orderBy('created_at', 'ASC')->simplePaginate($limit);
        return $examgroups;
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $examGroups = $this->model;
        if(isset($params->search) && !empty($params->search)) $examGroups->where('title', 'like', '%' . $params->search . '%');
        $examGroups = $examGroups
            ->withCount(['exam', 'examGroupUser'])
            ->with(['category', 'lessonCategory'])
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
        return $examGroups;
    }

    public function find($id)
    {
        return $this->model->with(['category', 'subCategories', 'lessonCategory', 'exam.questionTitle', 'exam' => function($query) {
            $query->orderBy('created_at', 'ASC');
            $query->with(['grade' => function ($gradeQuery) {
                $gradeQuery->where('user_id', Auth::user()->id);
            }]);
        }])
        ->find($id);
    }

    public function getByLessonCategory($lessonCategory, $limit = 10)
    {
        return $this->model
            ->with(['lessonCategory', 'transaction'])
            ->where('lesson_category_id', $lessonCategory)
            // ->where('exam_status', 'active')
            ->orderBy('created_at', 'ASC')->paginate($limit);
    }

    public function create($attributes)
    {
        $input = $attributes->all();
        $input['duration'] = $attributes->exam_group_type == 1 ? $attributes->duration : null;
        $input['random_question'] = $attributes->exam_group_type == 1 ? $attributes->random_question : null;
        $input['random_answer'] = $attributes->exam_group_type == 1 ? $attributes->random_answer : null;
        $input['show_answer'] = $attributes->exam_group_type == 1 ? $attributes->show_answer : null;
        $input['show_question_number_navigation'] = $attributes->exam_group_type == 1 ? $attributes->show_question_number_navigation : null;
        $input['show_question_number'] = $attributes->exam_group_type == 1 ? $attributes->show_question_number : null;
        $input['next_question_automatically'] = $attributes->exam_group_type == 1 ? $attributes->next_question_automatically : null;
        $input['show_prev_next_button'] = $attributes->exam_group_type == 1 ? $attributes->show_prev_next_button : null;
        $input['type_option'] = $attributes->exam_group_type == 1 ? $attributes->type_option : null;
        $input['button_type_finish'] = $attributes->exam_group_type == 1 ? $attributes->button_type_finish : null;
        $input['repeat_the_exam'] = $attributes->exam_group_type == 1 ? $attributes->repeat_the_exam : null;
        $input['total_tolerance'] = $attributes->exam_group_type == 1 ? $attributes->total_tolerance : null;
        $input['unblock_token'] = $attributes->exam_group_type == 1 ? ($attributes->total_tolerance == null ? null : $this->generateRandomCode(6)) : null;
        $input['minimal_grade'] = $attributes->minimal_grade_type == 2 ? $attributes->minimal_grade : null;
        $input['description_grade_less_than_minimal'] = $attributes->minimal_grade_type != 0 ? $attributes->description_grade_less_than_minimal : null;
        $input['description_grade_more_than_minimal'] = $attributes->minimal_grade_type != 0 ? $attributes->description_grade_more_than_minimal : null;
        
        $memberCategories = [];

        if($attributes->member_categories) {
            foreach ($attributes->member_categories as $subCategory) {
                $memberCategories[] = $subCategory['name'];
            }
    
            $input['member_categories'] = $memberCategories;
        } else {
            $input['member_categories'] = null;
        }

        $examGroup = $this->model->create($input);

        $subCategoryIds = [];

        foreach ($attributes->sub_category_ids as $subCategory) {
            $subCategoryIds[] = $subCategory['id'];
        }
        
        $examGroup->subCategories()->sync($subCategoryIds);

        return $examGroup;
    }

    public function update($attributes, $id)
    {
        $examGroup = $this->model->find($id);

        $input = $attributes->except('_token','_method');
        $input['duration'] = $attributes->exam_group_type == 1 ? $attributes->duration : null;
        $input['random_question'] = $attributes->exam_group_type == 1 ? $attributes->random_question : null;
        $input['random_answer'] = $attributes->exam_group_type == 1 ? $attributes->random_answer : null;
        $input['show_answer'] = $attributes->exam_group_type == 1 ? $attributes->show_answer : null;
        $input['show_question_number_navigation'] = $attributes->exam_group_type == 1 ? $attributes->show_question_number_navigation : null;
        $input['show_question_number'] = $attributes->exam_group_type == 1 ? $attributes->show_question_number : null;
        $input['next_question_automatically'] = $attributes->exam_group_type == 1 ? $attributes->next_question_automatically : null;
        $input['show_prev_next_button'] = $attributes->exam_group_type == 1 ? $attributes->show_prev_next_button : null;
        $input['type_option'] = $attributes->exam_group_type == 1 ? $attributes->type_option : null;
        $input['button_type_finish'] = $attributes->exam_group_type == 1 ? $attributes->button_type_finish : null;
        $input['repeat_the_exam'] = $attributes->exam_group_type == 1 ? $attributes->repeat_the_exam : null;
        $input['total_tolerance'] = $attributes->exam_group_type == 1 ? $attributes->total_tolerance : null;
        $input['unblock_token'] = $attributes->exam_group_type == 1 ? ($attributes->total_tolerance == null ? null : $this->generateRandomCode(6)) : null;
        $input['minimal_grade'] = $attributes->minimal_grade_type == 2 ? $attributes->minimal_grade : null;
        $input['description_grade_less_than_minimal'] = $attributes->minimal_grade_type != 0 ? $attributes->description_grade_less_than_minimal : null;
        $input['description_grade_more_than_minimal'] = $attributes->minimal_grade_type != 0 ? $attributes->description_grade_more_than_minimal : null;

        $memberCategories = [];

        if($attributes->member_categories) {
            foreach ($attributes->member_categories as $subCategory) {
                $memberCategories[] = $subCategory['name'];
            }
    
            $input['member_categories'] = $memberCategories;
        } else {
            $input['member_categories'] = null;
        }
        
        $examGroup->update($input);

        $subCategoryIds = [];

        foreach ($attributes->sub_category_ids as $subCategory) {
            $subCategoryIds[] = $subCategory['id'];
        }
        
        $examGroup->subCategories()->sync($subCategoryIds);

        return $examGroup;
    }

    public function regenerateToken($id)
    {
        $examGroup = $this->find($id);
        $examGroup->update(['unblock_token' => $this->generateRandomCode()]);

        return $examGroup;
    }

    function generateRandomCode($length = 8) 
    {
        $bytes = random_bytes($length);
        return strtoupper(substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $length));
    }
}
