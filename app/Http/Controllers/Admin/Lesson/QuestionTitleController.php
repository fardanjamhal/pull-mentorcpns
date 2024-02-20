<?php

namespace App\Http\Controllers\Admin\Lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Lesson\QuestionTitleRepository;
use App\Http\Requests\Lesson\QuestionTitleRequest;
use App\Exports\QuestionTemplateImport;
use App\Repositories\MasterData\CategoryRepository;
use Excel;

class QuestionTitleController extends Controller
{
    protected $questionTitleRepository;

    public function __construct(QuestionTitleRepository $questionTitleRepository)
    {
        $this->questionTitleRepository = $questionTitleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Admin/Lesson/QuestionTitle/Index', [
            'questionTitles' => $this->questionTitleRepository->getAllPaginatedWithParams($request),
            'categories' => (new CategoryRepository())->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Lesson/QuestionTitle/Create', [
            'categories' => (new CategoryRepository())->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionTitleRequest $request)
    {
        try {
            $this->questionTitleRepository->create($request);

            return redirect()->route('admin.question-titles.index');

        } catch(\Exception $e) {
            return $e;
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
        if(!$this->questionTitleRepository->find($id)) return abort('404', 'uppss....');

        return inertia('Admin/Lesson/QuestionTitle/Edit', [
            'questionTitle' => $this->questionTitleRepository->find($id),
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
    public function update(QuestionTitleRequest $request, $id)
    {
        try {
            if(!$this->questionTitleRepository->find($id)) return abort('404', 'uppss....');

            $this->questionTitleRepository->update($request, $id);

            return redirect()->route('admin.question-titles.index');

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
            $this->questionTitleRepository->delete($id);

            return redirect()->route('admin.question-titles.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    public function importExcelFormat($questionTitleId)
    {
        if(!$this->questionTitleRepository->find($questionTitleId)) return abort('404', 'uppss....');

        $questionTitle = $this->questionTitleRepository->find($questionTitleId);

        return Excel::download(new QuestionTemplateImport($questionTitle), str_replace(" ", "_", strtolower($questionTitle->name).'_template_import').'.xlsx');
    }
}
