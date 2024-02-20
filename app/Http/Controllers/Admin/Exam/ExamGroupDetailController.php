<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Exam\ExamRepository;
use App\Repositories\Exam\ExamGroupRepository;
use App\Repositories\Exam\GradeRepository;
use App\Http\Requests\Exam\ExamGroupDetailRequest;
use Ramsey\Uuid\Uuid as Generator;
use App\Models\Exam\Exam;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Excel;
use App\Models\Setting;
use App\Exports\ExamExport;

class ExamGroupDetailController extends Controller
{
    protected $ExamGroupRepository;

    public function __construct(ExamGroupRepository $examGroupRepository)
    {
        $this->examGroupRepository = $examGroupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($examGroupId, Request $request)
    {
        if(!$this->examGroupRepository->find($examGroupId)) return abort('404', 'uppss....');

        return inertia('Admin/Exam/ExamGroupDetail/Index', [
            'exams' => (new ExamRepository())->getByExamGroupPaginatedWithParams($request, $examGroupId),
            'examGroup' => $this->examGroupRepository->find($examGroupId)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($examGroupId)
    {
        if(!$this->examGroupRepository->find($examGroupId)) return abort('404', 'uppss....');

        $examGroup = $this->examGroupRepository->find($examGroupId);

        return inertia('Admin/Exam/ExamGroupDetail/Create', [
            'examGroup' => $examGroup,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($examGroupId, ExamGroupDetailRequest $request)
    {
        try {
            if(!$this->examGroupRepository->find($examGroupId)) return abort('404', 'uppss....');

            (new ExamRepository())->create($request);

            return redirect()->route('admin.exam-groups.exam-group-details.index', $examGroupId);

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
    public function show($examGroupId, $id)
    {
        if(!$this->examGroupRepository->find($examGroupId)) return abort('404', 'uppss....');

        if(!(new ExamRepository())->find($id)) return abort('404', 'uppss....');

        $exam = (new ExamRepository())->find($id);

        $rankingExams = (new GradeRepository())->getRankingByExam($exam->id);

        return inertia('Admin/Exam/ExamGroupDetail/Show', [
            'exam' => (new ExamRepository())->find($id),
            'rankingExams' => $rankingExams,
            'examGroup' => $this->examGroupRepository->find($examGroupId),
        ]);
    }

    public function exportPdf($examGroupId, $id)
    {
        if(!$this->examGroupRepository->find($examGroupId)) return abort('404', 'uppss....');

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

    public function exportExcel($examGroupId, $id)
    {
        if(!$this->examGroupRepository->find($examGroupId)) return abort('404', 'uppss....');

        if(!(new ExamRepository())->find($id)) return abort('404', 'uppss....');

        $exam = (new ExamRepository())->find($id);

        return Excel::download(new ExamExport($id), 'Rekapitulasi Nilai '.$exam->title.'.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($examGroupId, $id)
    {
        if(!$this->examGroupRepository->find($examGroupId)) return abort('404', 'uppss....');

        if(!(new ExamRepository())->find($id)) return abort('404', 'uppss....');

        $examGroup = $this->examGroupRepository->find($examGroupId);

        return inertia('Admin/Exam/ExamGroupDetail/Edit', [
            'examGroup' => $examGroup,
            'exam' => (new ExamRepository())->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($examGroupId, ExamGroupDetailRequest $request, $id)
    {
        try {
            if(!$this->examGroupRepository->find($examGroupId)) return abort('404', 'uppss....');

            if(!(new ExamRepository())->find($id)) return abort('404', 'uppss....');

            (new ExamRepository())->update($request, $id);

            return redirect()->route('admin.exam-groups.exam-group-details.index', $examGroupId);

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
    public function destroy($examGroupId, $id)
    {
        try {
            if(!$this->examGroupRepository->find($examGroupId)) return abort('404', 'uppss....');

            if(!(new ExamRepository())->find($id)) return abort('404', 'uppss....');

            (new ExamRepository())->delete($id);

            return redirect()->route('admin.exam-groups.exam-group-details.index', $examGroupId);

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back();
        }
    }
}
