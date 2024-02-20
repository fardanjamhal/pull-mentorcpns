<?php

namespace App\Http\Controllers\User\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\BankRepository;
use App\Http\Requests\Transaction\PaymentConfirmationRequest;

class TransactionController extends Controller
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
        return inertia('User/Transaction/Transaction/Index', [
            'transactions' => $this->transactionRepository->getAllPaginatedWithParamsByUser($request)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = $this->transactionRepository->find($id);
        
        if(!$transaction) return abort('404', 'uppss....');
        
        return inertia('User/Transaction/Transaction/Show', [
            'transaction' => $transaction,
            'banks' => (new BankRepository())->all()
        ]);
    }

    public function paymentConfirmation($transactionId)
    {
        $transaction = $this->transactionRepository->find($transactionId);
        
        if(!$transaction) return abort('404', 'uppss....');

        if($transaction->payment_method != 'manual_transfer' || $transaction->transaction_status == 'paid') {
            session()->flash('failed', 'Anda tidak bisa mengakses halaman tersebut, karena metode tidak sesuai atau anda telah melakukan konfirmasi pembayaran');
            return redirect()->route('user.transactions.show', $transactionId);
        }

        return inertia('User/Transaction/Transaction/PaymentConfirm', [
            'transaction' => $transaction,
            'banks' => (new BankRepository())->all()
        ]);
    }

    public function storePaymentConfirmation(PaymentConfirmationRequest $request, $transactionId)
    {
        try {
            $transaction = $this->transactionRepository->find($transactionId);
            
            if(!$transaction) {
                abort(404, 'uppss....');
            }

            $this->transactionRepository->paymentConfirmation($transactionId, $request);

            session()->flash('success', 'Konfirmasi pembayaran berhasil. Silakan tunggu hingga admin melakukan persetujuan pada transaksi anda dengan kode '. $transaction->code);

            return redirect()->route('user.transactions.show', $transactionId);

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
