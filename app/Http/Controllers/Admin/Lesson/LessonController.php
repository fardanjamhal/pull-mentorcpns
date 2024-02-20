<?php

namespace App\Http\Controllers\Admin\Lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Lesson\LessonRepository;
use App\Repositories\Lesson\LessonCategoryRepository;
use App\Repositories\Lesson\QuestionTitleRepository;
use App\Http\Requests\Lesson\LessonRequest;

class LessonController extends Controller
{
    protected $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Admin/Lesson/Lesson/Index', [
            'lessons' => $this->lessonRepository->getAllPaginatedWithParams($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Lesson/Lesson/Create', [
            'lessonCategories' => (new LessonCategoryRepository())->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request)
    {
        try {
            $this->lessonRepository->create($request);

            return redirect()->route('admin.lessons.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$this->lessonRepository->find($id)) return abort('404', 'uppss....');

        return inertia('Admin/Lesson/Lesson/Edit', [
            'lesson' => $this->lessonRepository->find($id),
            'lessonCategories' => (new LessonCategoryRepository())->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request, $id)
    {
        try {
            if(!$this->lessonRepository->find($id)) return abort('404', 'uppss....');

            $this->lessonRepository->update($request, $id);

            return redirect()->route('admin.lessons.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->lessonRepository->delete($id);

            return redirect()->route('admin.lessons.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());
            
            return redirect()->back()->withInput($request->all());
        }
    }

    public function getQuestionTitle($lessonId)
    {
        return (new QuestionTitleRepository())->getAllByLesson($lessonId);
    }
}
