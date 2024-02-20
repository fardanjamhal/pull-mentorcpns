<?php

namespace App\Http\Controllers\Admin\Lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Lesson\LessonCategoryRepository;
use App\Repositories\MasterData\CategoryRepository;
use App\Repositories\Lesson\LessonRepository;
use App\Http\Requests\Lesson\LessonCategoryRequest;

class LessonCategoryController extends Controller
{
    protected $lessonCategoryRepository;

    public function __construct(LessonCategoryRepository $lessonCategoryRepository)
    {
        $this->lessonCategoryRepository = $lessonCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Admin/Lesson/LessonCategory/Index', [
            'lessonCategories' => $this->lessonCategoryRepository->getAllPaginatedWithParams($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Lesson/LessonCategory/Create', [
            'categories' => (new CategoryRepository())->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonCategoryRequest $request)
    {
        try {
            $this->lessonCategoryRepository->create($request);

            return redirect()->route('admin.lesson-categories.index');

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
        if(!$this->lessonCategoryRepository->find($id)) return abort('404', 'uppss....');

        return inertia('Admin/Lesson/LessonCategory/Edit', [
            'lessonCategory' => $this->lessonCategoryRepository->find($id),
            'categories' => (new CategoryRepository())->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LessonCategoryRequest $request, $id)
    {
        try {
            if(!$this->lessonCategoryRepository->find($id)) return abort('404', 'uppss....');

            $this->lessonCategoryRepository->update($request, $id);

            return redirect()->route('admin.lesson-categories.index');

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
            $this->lessonCategoryRepository->delete($id);
            
            return redirect()->route('admin.lesson-categories.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    public function getLesson($lessonCategoryId)
    {
        return (new LessonRepository())->getAllByLessonCategory($lessonCategoryId);
    }
}
