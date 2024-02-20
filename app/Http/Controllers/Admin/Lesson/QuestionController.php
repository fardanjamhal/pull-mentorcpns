<?php

namespace App\Http\Controllers\Admin\Lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Lesson\QuestionRepository;
use App\Repositories\Lesson\QuestionTitleRepository;
use App\Repositories\Lesson\ValueCategoryRepository;
use App\Http\Requests\Lesson\QuestionRequest;
use Ramsey\Uuid\Uuid as Generator;
use App\Models\Lesson\Question;
use App\Models\Lesson\QuestionTitle;
use App\Models\Exam\ExamGroup;
use Carbon\Carbon;
use Excel;
use App\Imports\QuestionImport;
use App\Exports\QuestionExport;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($questionTitleId, Request $request)
    {
        if(!(new QuestionTitleRepository())->find($questionTitleId)) return abort('404', 'uppss....');

        return inertia('Admin/Lesson/Question/Index', [
            'questions' => $this->questionRepository->getByQuestionTitlePaginatedWithParams($request, $questionTitleId),
            'questionTitle' => (new QuestionTitleRepository())->find($questionTitleId)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($questionTitleId)
    {
        if(!(new QuestionTitleRepository())->find($questionTitleId)) return abort('404', 'uppss....');

        $questionTitle = (new QuestionTitleRepository())->find($questionTitleId);
        
        $valueCategories = (new ValueCategoryRepository())->findByField('lesson_id', $questionTitle->lesson_id);

        return inertia('Admin/Lesson/Question/Create', [
            'questionTitle' => $questionTitle,
            'valueCategories' => $valueCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($questionTitleId, QuestionRequest $request)
    {
        try {
            if(!(new QuestionTitleRepository())->find($questionTitleId)) return abort('404', 'uppss....');

            #store
            $this->questionRepository->create($request);

            #Bump....
            return redirect()->route('admin.question-titles.questions.index', $questionTitleId);

        } catch(\Exception $e) {
            #get message
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            #redirect
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($questionTitleId, $id)
    {
        if(!(new QuestionTitleRepository())->find($questionTitleId)) return abort('404', 'uppss....');

        if(!$this->questionRepository->find($id)) return abort('404', 'uppss....');

        $questionTitle = (new QuestionTitleRepository())->find($questionTitleId);

        $valueCategories = (new ValueCategoryRepository())->findByField('lesson_id', $questionTitle->lesson_id);

        return inertia('Admin/Lesson/Question/Edit', [
            'questionTitle' => $questionTitle,
            'question' => $this->questionRepository->find($id),
            'valueCategories' => $valueCategories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($questionTitleId, QuestionRequest $request, $id)
    {
        try {
            if(!(new QuestionTitleRepository())->find($questionTitleId)) return abort('404', 'uppss....');

            if(!$this->questionRepository->find($id)) return abort('404', 'uppss....');

            $this->questionRepository->update($request, $id);

            return redirect()->route('admin.question-titles.questions.index', $questionTitleId);

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
    public function destroy($questionTitleId, $id)
    {
        try {
            if(!(new QuestionTitleRepository())->find($questionTitleId)) return abort('404', 'uppss....');

            if(!$this->questionRepository->find($id)) return abort('404', 'uppss....');

            $this->questionRepository->delete($id);

            return redirect()->route('admin.question-titles.questions.index', $questionTitleId);

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back();
        }
    }

    public function importExcel(Request $request, $questionTitleId)
    {
        try {

            $questionTitle = (new QuestionTitleRepository())->find($questionTitleId);

            $collection = Excel::toCollection(null, $request->file);
            $headingRow = $collection->first()->first();
            $headingArray = $headingRow->toArray();

            $headerFile = array_filter($headingArray, function ($value) {
                return $value !== null;
            });
            $headerFile = array_values($headerFile);

            $headerImport = [
                'NO',
            ];

            if ($questionTitle->assessment_type == 1) {
                $headerImport[] = 'KATEGORI_PENILAIAN';
            }

            $headerImport[] = 'SOAL';

            for ($i = 0; $i < $questionTitle->total_choices; $i++) {
                $headerImport[] = 'PILIHAN_' . chr(65 + $i);
            }

            if ($questionTitle->assessment_type != 4) {
                $headerImport[] = 'JAWABAN';
            }

            if ($questionTitle->assessment_type == 4) {
                for ($i = 0; $i < $questionTitle->total_choices; $i++) {
                    $headerImport[] = 'BOBOT_JAWABAN_' . chr(65 + $i);
                }
            }

            if ($questionTitle->assessment_type == 3) {
                $headerImport[] = 'POIN_JAWABAN_BENAR';
            }

            if ($headerFile === $headerImport) {
                Excel::import(new QuestionImport($questionTitle), $request->file);
                session()->flash('success', 'Proses Import Berhasil Dijalankan.');
                return redirect()->route('admin.question-titles.questions.index', $questionTitleId);
            } else {
                session()->flash('failed', 'Format Import Tidak Sesuai. ');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file: ' . $e->getFile() . ' line: ' . $e->getLine());
            return redirect()->back();
        }
    }

    public function exportExcel($questionTitleId)
    {
        try {
            $questionTitle = (new QuestionTitleRepository())->find($questionTitleId);
            return Excel::download(new QuestionExport($questionTitle), str_replace(' ', '_', $questionTitle->name).'.xlsx');

        } catch(\Exception $e) {
            return $e;
            #get message
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            #redirect
            return redirect()->back();
        }
    }

    public function deleteQuestion($questionTitleId)
    {
        try {
            if(!(new QuestionTitleRepository())->find($questionTitleId)) return abort('404', 'uppss....');
            
            $questionTitle = QuestionTitle::find($questionTitleId);
            foreach($questionTitle->exam as $exam) {
                if(!empty($exam->exam_group_id)) {
                    ExamGroup::find($exam->exam_group_id)->update(['updated_at' => Carbon::now()]);
                }
            }

            Question::where('question_title_id', $questionTitleId)->delete();

            #Bump....
            return redirect()->route('admin.question-titles.questions.index', $questionTitleId);

        } catch(\Exception $e) {
            #get message
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            #redirect
            return redirect()->back();
        }
    }

    public function generateQuestion($questionTitleId, Request $request)
    {
        $number = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $letter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $symbol = ['ℇ', 'ℰ', '₢', '₦', '₥', '℧', '₮', 'ℓ', '₰', '€', '₻', '⅊', '₾', '₫', '℄', '℘', '℣', '℈', '₺', 'ℐ', '₹', 'ℵ', 'Ω', '₽', '₣', '₿', '℺', 'ℨ'];

        if($request->type == "number") {
            $originalArray = $number;
        } elseif($request->type == "letter") {
            $originalArray = $letter;
        } elseif($request->type == "symbol") {
            $originalArray = $symbol;
        } elseif($request->type == "number_letter") {
            $originalArray = array_merge($number, $letter);
        } elseif($request->type == "number_symbol") {
            $originalArray = array_merge($number, $symbol);
        } elseif($request->type == "letter_symbol") {
            $originalArray = array_merge($letter, $symbol);
        } elseif($request->type == "number_letter_symbol") {
            $originalArray = array_merge($number, $letter, $symbol);
        }

        shuffle($originalArray);

        // Jumlah array yang ingin dibuat
        $numberOfArrays = 10;

        // Menginisialisasi array multidimensi
        $dataSoal = array();

        // Membuat array multidimensi dengan angka acak yang berbeda
        for ($i = 0; $i < $numberOfArrays; $i++) {
            $tempArray = $originalArray;
            shuffle($tempArray);
            $dataSoal[] = array_slice($tempArray, 0, 5);
        }

        $questionInsert = [];
        $sectionNomor = 0;
        for($indexSoal = 0; $indexSoal < count($dataSoal); $indexSoal++) {
            $sectionNomor++;
            $arrayAsli = $dataSoal[$indexSoal];
            $arr = $dataSoal[$indexSoal];
            $section = $sectionNomor;

            $questionTitle = 'bd05f3b9-39b7-4beb-9723-d415fd39a3bb';

            $uniqueArray = [];
            for($i = 0; $i < count($arr); $i++) {
                for($i = 1; $i <= 500; $i++) {
                    shuffle($arr);
                    $uniqueArray[] = $arr;
                }
            }

            $generateValue = [];
            $kunciJawaban = [];

            foreach($uniqueArray as $array) {
                $unset = rand(0, 4);
                $indexHilang = array_search($array[$unset], $arrayAsli);
                unset($array[$unset]);
                $generateValue[] = implode(' ', $array)." = ".$this->getOption($indexHilang).$indexHilang + 1;
                $kunciJawaban[] = implode('', $array)." = ".$this->getOption($indexHilang);
            }

            $datagenerate =  array_values(array_unique($generateValue));
            $dataKunciJawaban =  array_values(array_unique($kunciJawaban));

            foreach($datagenerate as $index => $value) {
                if($index >= 0 && $index <= 49) {
                    $question = explode(" ", $value);
                    $answer = $value[strlen($value) - 1];

                    $table = '<p><span style="font-size: 14pt;"><strong>INTERUPSI</strong></span></p>
                            <p style="text-align: center;"><span style="font-size: 18pt;"><strong>KOLOM '.$section.'</strong></span></p>
                            <table style="border-collapse: collapse; width: 100%; height: 46px; border-color: #3598db; border-style: solid; margin-left: auto; margin-right: auto;" border="3">
                            <tbody>
                            <tr style="height: 22.4px;">
                            <td style="width: 20.111%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 36pt;">'.$arrayAsli[0].'</span></strong></td>
                            <td style="width: 20.111%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 36pt;">'.$arrayAsli[1].'</span></strong></td>
                            <td style="width: 20.111%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 36pt;">'.$arrayAsli[2].'</span></strong></td>
                            <td style="width: 20.111%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 36pt;">'.$arrayAsli[3].'</span></strong></td>
                            <td style="width: 19.5908%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 36pt;">'.$arrayAsli[4].'</span></strong></td>
                            </tr>
                            <tr style="height: 22.4px;">
                            <td style="width: 20.111%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 18pt;">a</span></strong></td>
                            <td style="width: 20.111%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 18pt;">b</span></strong></td>
                            <td style="width: 20.111%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 18pt;">c</span></strong></td>
                            <td style="width: 20.111%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 18pt;">d</span></strong></td>
                            <td style="width: 19.5908%; height: 30px; text-align: center; border: 3px solid #000000;"><strong><span style="font-size: 18pt;">e</span></strong></td>
                            </tr>
                            </tbody>
                            </table>
                            <p>&nbsp;</p>
                            <p><span style="font-size: 14pt;"><strong>PERTANYAAN</strong></span></p>
                            <table style="border-collapse: collapse; width: 80.4498%; height: 70px; border-color: #3598db; border-style: solid; float: left;" border="3">
                            <tbody>
                            <tr style="height: 22.4px;">
                            <td style="width: 25.0911%; height: 30px; text-align: center; border: 3px solid #000000;"><span style="font-size: 24pt;"><strong>'.$question[0].'</strong></span></td>
                            <td style="width: 25.0911%; height: 30px; text-align: center; border: 3px solid #000000;"><span style="font-size: 24pt;"><strong>'.$question[1].'</strong></span></td>
                            <td style="width: 25.0911%; height: 30px; text-align: center; border: 3px solid #000000;"><span style="font-size: 24pt;"><strong>'.$question[2].'</strong></span></td>
                            <td style="width: 24.7695%; height: 30px; text-align: center; border: 3px solid #000000;"><span style="font-size: 24pt;"><strong>'.$question[3].'</strong></span></td>
                            </tr>
                            </tbody>
                            </table>
                            <p>&nbsp;</p>';

                        Question::insert([
                            'id' => Generator::uuid4()->toString(),   
                            'question_title_id' => $questionTitleId,    
                            'value_category_id' => null,
                            'question' => $table,
                            'option_1' => $arrayAsli[0],
                            'option_2' => $arrayAsli[1],
                            'option_3' => $arrayAsli[2],
                            'option_4' => $arrayAsli[3],
                            'option_5' => $arrayAsli[4],
                            'answer' => $answer,
                            'section' => $section,
                            'created_at' => Carbon::now()->addMinutes($section * 10),
                            'updated_at' => Carbon::now()->addMinutes($section * 10),
                        ]);
                }
            }
        }

        return redirect()->route('admin.question-titles.questions.index', $questionTitleId);
    }

    public function getOption($number)
    {
        switch ($number) {
            case 0:
                return 'A';
                break;
            case 1:
                return 'B';
                break;
            case 2:
                return 'C';
                break;
            case 3:
                return 'D';
                break;
            default:
                return 'E';
                break;
        }
    }
}
