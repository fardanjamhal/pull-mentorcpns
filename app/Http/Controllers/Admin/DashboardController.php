<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\User\UserRepository;
use ArielMejiaDev\LarapexCharts\LarapexChart;
// use App\Charts\VisitorCounterChart;

class DashboardController extends Controller
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $chart = new VisitorCounterChart(new LarapexChart);

        return inertia('Admin/Dashboard/Index', [
            'totalStudent' => number_format((new UserRepository())->getTotalStudent()),
            'totalStudentActive' => number_format((new UserRepository())->getTotalStudentActive()),
            'totalStudentNonActive' => number_format((new UserRepository())->getTotalStudentNonActive()),
            'totalStudentMember' => number_format((new UserRepository())->getTotalStudentMember()),

            'totalTransactionToday' => number_format($this->transactionRepository->getTotalTransactionToday()),
            'totalTransactionMonthly' => number_format($this->transactionRepository->getTotalTransactionMonthly()),
            'totalTransactionYearly' => number_format($this->transactionRepository->getTotalTransactionYearly()),

            'totalTransactionPending' => number_format($this->transactionRepository->getTotalTransactionPending()),
            'totalTransactionPaid' => number_format($this->transactionRepository->getTotalTransactionPaid()),
            'totalTransactionDone' => number_format($this->transactionRepository->getTotalTransactionDone()),
            'totalTransactionFailed' => number_format($this->transactionRepository->getTotalTransactionFailed()),

            'transactions' => $this->transactionRepository->getTransactionMonthly(),
            // 'chart' => $chart->build()
        ]);
    }

    public function upload(Request $request)
    {
        $fileName = Carbon::now()->format('Ymdhis').$request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs('/upload_files/questions', $fileName, 'public');
        return response()->json(['location' => "/storage/$path"]);
    }

    public function uploadAnnouncement(Request $request)
    {
        $fileName = Carbon::now()->format('Ymdhis').$request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs('/upload_files/announcements', $fileName, 'public');
        return response()->json(['location' => "/storage/$path"]);
    }
}
