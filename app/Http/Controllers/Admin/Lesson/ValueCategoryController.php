<?php

namespace App\Http\Controllers\Admin\Lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Lesson\ValueCategoryRepository;
use App\Repositories\Lesson\LessonRepository;
use App\Http\Requests\Lesson\ValueCategoryRequest;

class ValueCategoryController extends Controller
{
    protected $valueCategoryRepository;

    public function __construct(ValueCategoryRepository $valueCategoryRepository)
    {
        $this->valueCategoryRepository = $valueCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Admin/Lesson/ValueCategory/Index', [
            'valueCategories' => $this->valueCategoryRepository->getAllPaginatedWithParams($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Lesson/ValueCategory/Create', [
            'lessons' => (new LessonRepository())->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValueCategoryRequest $request)
    {
        try {
            $this->valueCategoryRepository->create($request->all());
            
            return redirect()->route('admin.value-categories.index');

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
        if(!$this->valueCategoryRepository->find($id)) return abort('404', 'uppss....');

        return inertia('Admin/Lesson/ValueCategory/Edit', [
            'valueCategory' => $this->valueCategoryRepository->find($id),
            'lessons' => (new LessonRepository())->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValueCategoryRequest $request, $id)
    {
        try {
            if(!$this->valueCategoryRepository->find($id)) return abort('404', 'uppss....');

            $this->valueCategoryRepository->update($request->all(), $id);
            
            return redirect()->route('admin.value-categories.index');

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
            $this->valueCategoryRepository->delete($id);

            return redirect()->route('admin.value-categories.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }
}
