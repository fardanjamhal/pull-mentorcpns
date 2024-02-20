<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\BankRepository;
use App\Exports\TransactionExport;
use Excel;

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
        return inertia('Admin/Transaction/Transaction/Index', [
            'transactions' => $this->transactionRepository->getAllPaginatedWithParams($request)
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
        if(!$this->transactionRepository->find($id)) return abort('404', 'uppss....');

        return inertia('Admin/Transaction/Transaction/Show', [
            'transaction' => $this->transactionRepository->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if(!$this->transactionRepository->find($id)) return abort('404', 'uppss....');
            
            #update
            $this->transactionRepository->update($request, $id);

            #Bump....
            return redirect()->route('admin.transactions.show', $transaction->id);

        } catch(\Exception $e) {
            #get message
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            #redirect
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
            $this->transactionRepository->delete($id);

            return redirect()->route('admin.transactions.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());
            
            return redirect()->back()->withInput($request->all());
        }
    }

    public function invoice($id)
    {
        if(!$this->transactionRepository->find($id)) return abort('404', 'uppss....');

        return inertia('Admin/Transaction/Transaction/Invoice', [
            'transaction' => $this->transactionRepository->find($id),
            'banks' => (new BankRepository())->all()
        ]);
    }

    public function export(Request $request)
    {
        $transactions = $this->transactionRepository->getAllWithParams($request);
        return Excel::download(new TransactionExport($transactions), 'transactions.xlsx');
    }
}
