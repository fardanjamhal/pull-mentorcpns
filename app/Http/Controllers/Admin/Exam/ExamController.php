<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Exam\ExamRepository;
use App\Repositories\MasterData\CategoryRepository;
use App\Repositories\Exam\GradeRepository;
use App\Http\Requests\Exam\ExamRequest;
use App\Models\MasterData\SubCategory;
use App\Models\Exam\Exam;
use App\Models\Exam\ExamGroupUser;
use App\Models\Setting;
use App\Exports\ExamExport;
use Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Repositories\User\MemberCategoryRepository;

class ExamController extends Controller
{
    protected $examRepository;

    public function __construct(ExamRepository $examRepository)
    {
        $this->examRepository = $examRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Admin/Exam/Exam/Index', [
            'exams' => $this->examRepository->getAllPaginatedWithParams($request),
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
        return inertia('Admin/Exam/Exam/Create')->with([
            'categories' => (new CategoryRepository())->all(),
            'memberCategories' => (new MemberCategoryRepository())->getAllActivated()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamRequest $request)
    {
        try {
            $this->examRepository->create($request);

            return redirect()->route('admin.exams.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$this->examRepository->find($id)) return abort('404', 'uppss....');

        $exam = $this->examRepository->find($id);

        $rankingExams = (new GradeRepository())->getRankingByExam($exam->id, 10, 1);

        return inertia('Admin/Exam/Exam/Show', [
            'exam' => $this->examRepository->find($id),
            'rankingExams' => $rankingExams,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$this->examRepository->find($id)) return abort('404', 'uppss....');

        $exam = Exam::with(['subCategories' => function ($query) {
            $query->select('sub_categories.id', 'sub_categories.name');
        }])->find($id);

        $subCategories = $exam->subCategories;

        return inertia('Admin/Exam/Exam/Edit', [
            'exam' => $this->examRepository->find($id),
            'categories' => (new CategoryRepository())->all(),
            'subCategories' => $subCategories,
            'memberCategories' => (new MemberCategoryRepository())->getAllActivated()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExamRequest $request, $id)
    {
        try {
            if(!$this->examRepository->find($id)) return abort('404', 'uppss....');

            $this->examRepository->update($request, $id);

            return redirect()->route('admin.exams.index');

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
            $this->examRepository->delete($id);

            return redirect()->route('admin.exams.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    public function exportPdf($id)
    {
        if(!(new ExamRepository())->find($id)) return abort('404', 'uppss....');

        $exam = (new ExamRepository())->find($id);

        $rankingExams = (new GradeRepository())->getGradeByExam($exam->id, 1);

        $pdf = Pdf::loadView('report.pdf.exam', [
            'exam' => $exam,
            'rankingExams' => $rankingExams,
            'setting' => Setting::first() ?? [],
        ]);

        $filename = str_replace("", "_", 'Rekapitulasi Nilai '.$exam->title.'.pdf');
        return $pdf->stream($filename);
    }

    public function exportExcel($id)
    {
        if(!(new ExamRepository())->find($id)) return abort('404', 'uppss....');

        $exam = (new ExamRepository())->find($id);

        return Excel::download(new ExamExport($id), 'Rekapitulasi Nilai '.$exam->title.'.xlsx');
    }

    public function deleteExam($id)
    {
        try {
            $grade = (new GradeRepository())->find($id);

            if($grade->exam_group_id) {
                ExamGroupUser::where(['user_id' => $grade->user_id, 'exam_group_id' => $grade->exam_group_id])->update([
                    'grade' => 0,
                    'is_finished' => 0, 
                    'description' => null
                ]);
            }

            $grade->delete();

            return redirect()->back();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function regenerateBlockToken($id)
    {
        try {
            $this->examRepository->regenerateToken($id);

            return redirect()->back();

        } catch (\Throwable $th) {
            return $th;
        }
    }
}
