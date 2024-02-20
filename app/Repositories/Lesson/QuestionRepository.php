<?php

namespace App\Repositories\Lesson;

use App\Models\Lesson\Question;
use App\Repositories\Contracts\Lesson\QuestionInterface;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Services\UploadService;
use App\Models\Lesson\QuestionTitle;
use App\Models\Exam\ExamGroup;

class QuestionRepository extends BaseRepository implements QuestionInterface
{
    /**
     * @var
     */
    protected $model;

    protected $path = 'upload_files/questions/audio';

    public function __construct()
    {
        $this->model = new Question();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $questions = $this->model;
        if(isset($params->search) && !empty($params->search)) $questions->where('question', 'like', '%' . $params->search . '%');
        $questions = $questions->with(['questionTitle','valueCategory'])->orderBy('created_at', 'ASC')->paginate($limit);
        return $questions;
    }

    public function getByQuestionTitlePaginatedWithParams($params, $questionTitleId, $limit = 10)
    {
        $questions = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $questions->where('question', 'like', '%' . $params->search . '%');
        $questions = $questions->where('question_title_id', $questionTitleId)->with(['questionTitle','valueCategory'])->orderBy('created_at', 'ASC')->paginate($limit);
        
        $questions->appends([
            'search' => $params->search,
        ]);

        return $questions;
    }

    public function create($attributes)
    {
        $input = $attributes->all();

        $questionTitle = QuestionTitle::find($input['question_title_id']);

        foreach($questionTitle->exam as $exam) {
            if(!empty($exam->exam_group_id)) {
                ExamGroup::find($exam->exam_group_id)->update(['updated_at' => Carbon::now()]);
            }
        }
        
        $questionTitle->update(['updated_at' => Carbon::now()]);

        $input['audio_played_limit'] = $attributes->audio_input == 0 ? null : $attributes->audio_played_limit;
        $input['audio_answer_time'] = $attributes->audio_input == 0 ? null : $attributes->audio_answer_time;

        $input['question'] = str_replace("../../../..", "", $attributes->question);
        $input['option_1'] = str_replace("../../../..", "", $attributes->option_1);
        $input['option_2'] = str_replace("../../../..", "", $attributes->option_2);
        $input['option_3'] = str_replace("../../../..", "", $attributes->option_3);
        $input['option_4'] = str_replace("../../../..", "", $attributes->option_4);
        $input['option_5'] = str_replace("../../../..", "", $attributes->option_5);
        $input['created_at'] = Carbon::now();
        $input['updated_at'] = Carbon::now();

        if($attributes->hasFile('audio')){
            $file = $attributes->file('audio')->getClientOriginalName();
            $filename = (new UploadService())->uploadFile($attributes->file('audio'), $this->path);
            $input['audio'] = $filename;
        }

        return $this->model->create($input);
    }

    public function update($attributes, $id)
    {
        $input = $attributes->except('_token','_method');
        $question = $this->find($id);

        $questionTitle = QuestionTitle::find($input['question_title_id']);

        foreach($questionTitle->exam as $exam) {
            if(!empty($exam->exam_group_id)) {
                ExamGroup::find($exam->exam_group_id)->update(['updated_at' => Carbon::now()]);
            }
        }
        
        $questionTitle->update(['updated_at' => Carbon::now()]);

        $input['audio_played_limit'] = $attributes->audio_input == 0 ? null : $attributes->audio_played_limit;
        $input['audio_answer_time'] = $attributes->audio_input == 0 ? null : $attributes->audio_answer_time;

        $input['question'] = str_replace("../../../..", "", $attributes->question);
        $input['option_1'] = str_replace("../../../..", "", $attributes->option_1);
        $input['option_2'] = str_replace("../../../..", "", $attributes->option_2);
        $input['option_3'] = str_replace("../../../..", "", $attributes->option_3);
        $input['option_4'] = str_replace("../../../..", "", $attributes->option_4);
        $input['option_5'] = str_replace("../../../..", "", $attributes->option_5);
        $input['updated_at'] = Carbon::now();

        if($attributes->hasFile('audio')){
            $file = $attributes->file('audio')->getClientOriginalName();
            $filename = (new UploadService())->uploadFile($attributes->file('audio'), $this->path);
            (new UploadService())->deleteFile($question->audio, $this->path);
            $input['audio'] = $filename;
        }

        if($attributes->audio_input == 0) {
            $input['audio'] = null;
            (new UploadService())->deleteFile($question->audio, $this->path);
        }
        
        return $question->update($input);
    }

    public function delete($id)
    {
        $question = $this->model->find($id);

        $questionTitle =  QuestionTitle::find($question->question_title_id);

        foreach($questionTitle->exam as $exam) {
            if(!empty($exam->exam_group_id)) {
                ExamGroup::find($exam->exam_group_id)->update(['updated_at' => Carbon::now()]);
            }
        }
        
        $questionTitle->update(['updated_at' => Carbon::now()]);

        (new UploadService())->deleteFile($question->audio, $this->path);
        return $question->delete();
    }
}
