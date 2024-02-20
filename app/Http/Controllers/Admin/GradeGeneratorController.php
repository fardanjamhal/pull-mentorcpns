<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GradeGenerator;
use Excel;
use App\Imports\GradeGeneratorImport;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class GradeGeneratorController extends Controller
{
    public function index()
    {
        $grades = GradeGenerator::orderBy('id', 'ASC')->paginate(10);

        return inertia('Admin/GradeGenerator/Index', [
            'grades' => $grades
        ]);
    }

    public function store(Request $request)
    {
        try {
            $collection = Excel::toCollection(null, $request->file);

            $headingRow = $collection->first()->first();
            $headingArray = $headingRow->toArray();

            $headerFile = array_filter($headingArray, function ($value) {
                return $value !== null;
            });

            $headerFile = array_values($headerFile);

            $headerImport = [
                'NO',
                'NAMA',
                'GENDER',

                'WAWASAN_KEBANGSAAN',
                'TWK_TO_KE',
    
                'PENGETAHUAN_UMUM',
                'PU_TO_KE',

                'MATEMATIKA',
                'MTK_TO_KE',
    
                'BAHASA_INGGRIS',
                'EN_TO_KE',
    
                'NILAI_AKHIR',
            ];  

            if ($headerFile === $headerImport) {
                Excel::import(new GradeGeneratorImport, $request->file);
                session()->flash('success', 'Proses Import Berhasil Dijalankan.');
                return redirect()->route('admin.grade-generators.index');
            } else {
                session()->flash('failed', 'Format Import Tidak Sesuai. ');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file: ' . $e->getFile() . ' line: ' . $e->getLine());
            return redirect()->back();
        }
    }

    public function deleteAll()
    {
        try {
            GradeGenerator::where('id', '<>', 0)->delete();
            return redirect()->route('admin.grade-generators.index');

        } catch (\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file: ' . $e->getFile() . ' line: ' . $e->getLine());
            return redirect()->back();
        }
    }

    public function exportPdf($id)
    {
        $grade = GradeGenerator::find($id);

        $pdf = Pdf::loadView('report.pdf.exam_academic', [
            'grade' => $grade,
            'setting' => Setting::first() ?? [],
        ]);

        $filename = str_replace("", "_",$grade->nama.'.pdf');
        return $pdf->stream($filename);
    }
}
