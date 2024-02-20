<?php

namespace App\Http\Controllers\User\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Transaction\TransactionRepository;
use Auth;
use App\Models\Transaction\Transaction;
use App\Models\MasterData\Student;
use Carbon\Carbon;

class VoucherActivationController extends Controller
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('User/Transaction/VoucherActivation/Index', [
            'voucherActivations' => $this->transactionRepository->getAllVoucherActivatedPaginatedWithParamsByUser($request)
        ]);
    }

    public function store(Request $request)
    {
        if(empty($request->token)) return redirect()->back()->with('error', '<b>Aktivasi Gagal.</b> Token tidak boleh kosong.');

        $transaction = Transaction::where(['user_id' => Auth::user()->id, 'voucher_token' => $request->token])->first();

        if(!$transaction) return redirect()->back()->with('error', '<b>Aktivasi Gagal.</b> Data voucher dengan token <b>'.$request->token.'</b> tidak ditemukan.');

        if($transaction->voucher_activated == 1) return redirect()->back()->with('error', '<b>Aktivasi Gagal.</b> Data voucher dengan token <b>'.$request->token.'</b> sudah terpakai.');

        $expiredDate = Carbon::now()->addMonths($transaction->voucher_active_period)->format('Y-m-d');

        $transaction->update([
            'voucher_used' => 1,
            'voucher_activated' => 1,
            'voucher_expired_date' => $expiredDate
        ]);

        $student = Student::find(Auth::user()->student->id);
        
        $memberData = [
            'category_id' => $transaction->category_id,
            'access_type' => $transaction->voucher_access_type,
            'expired_date' => $expiredDate,
        ];

        $arrayMemberData = $student->member_access == null ? [] : $student->member_access;
        array_push($arrayMemberData, $memberData);

        $student->update([
            'member_access' => $arrayMemberData,
            'is_member' => 1
        ]);

        return redirect()->back()->with('success', '<b>Aktivasi Berhasil.</b> Data voucher dengan token <b>'.$request->token.'</b> sudah berhasil diaktifkan.');
    }
}
