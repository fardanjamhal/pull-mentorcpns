<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\AccountBalanceRepository;
use App\Http\Requests\User\AccountBalanceRequest;
use App\Repositories\Transaction\BankRepository;
use App\Repositories\Exam\ExamRepository;
use App\Repositories\Exam\ExamGroupRepository;
use App\Repositories\Transaction\TransactionRepository;
use Auth;
use App\Models\User;

class AccountBalanceController extends Controller
{
    protected $accountBalanceRepository;

    public function __construct(AccountBalanceRepository $accountBalanceRepository)
    {
        $this->accountBalanceRepository = $accountBalanceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('User/AccountBalance/Index', [
            'accountBalances' => $this->accountBalanceRepository->getAllPaginatedWithParamsByUser($request),
            'banks' => (new BankRepository())->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountBalanceRequest $request)
    {
        try {
            $this->accountBalanceRepository->create($request->all());

            return redirect()->route('user.account-balances.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    public function buyExam($examId, Request $request)
    {
        try {
            if($request->type == 'exam') {
                $exam = (new ExamRepository())->find($examId);
            } else {
                $exam = (new ExamGroupRepository())->find($examId);
            }

            if(!$exam) {
                return abort('404');
            }

            if($exam->price_after_discount > Auth::user()->account_balance) {
                session()->flash('error', 'Saldo Anda Tidak Cukup Untuk Membeli Latihan Soal, silakan Top Up saldo terlebih dahulu.');
                return redirect()->back();
            }

            (new TransactionRepository())->createTransaction($examId, $request->type);

            session()->flash('success', 'Pembelian '.($request->type == 'exam' ? 'Latihan Soal' : 'Try Out'). ' berhasil.');
            return redirect()->back();

        } catch (\Throwable $e) {
            return $e;
            session()->flash('error', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());
            return redirect()->back();
        }
    }

}
