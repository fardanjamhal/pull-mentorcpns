<?php

namespace App\Http\Controllers\User\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Transaction\VoucherRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Models\Transaction\Transaction;
use App\Http\Requests\User\PaymentMethodRequest;
use Midtrans\Snap;
use Carbon\Carbon;
use DB;
use Auth;
use Str;

class VoucherController extends Controller
{
    protected $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;

        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('User/Transaction/Voucher/Index', [
            'vouchers' => $this->voucherRepository->getAllActivated($request)
        ]);
    }

    public function buy(Request $request, $id)
    {
        $voucher = $this->voucherRepository->find($id);

        if(!$voucher) return abort('404', 'uppss....');
        return inertia('User/Transaction/Voucher/Buy', [
            'voucher' => $voucher
        ]);
    }

    public function buyStore(PaymentMethodRequest $request, $id)
    {
        try {
            $voucher = $this->voucherRepository->find($id);

            if(!$voucher) return abort('404', 'uppss....');

            if($request->payment_method == 'account_balance') {
                if($voucher->price_after_discount > Auth::user()->account_balance) {
                    session()->flash('error', 'Saldo Anda Tidak Cukup Untuk Membeli Latihan Soal, silakan Top Up saldo terlebih dahulu.');
                    return redirect()->back();
                }
            }

            $transaction = Transaction::create([
                'description' => $voucher->name.' Masa Aktif '.$voucher->active_period.' '.($voucher->period_type == 'day' ? 'Hari' : 'Bulan'),
                'user_id' => Auth::user()->id,
                'category_id' => $voucher->category_id,
                'code' => Transaction::generateCode(),
                'payment_method' => $request->payment_method,
                'active_period' => $voucher->active_period,
                'period_type' => $voucher->period_type,
                'total_payment' => $voucher->price_after_discount,
                'member_categories' => $voucher->member_categories,
                'transaction_status' => 'pending'
            ]);

            if($request->payment_method == 'automatic_transfer_midtrans') {
                $snapToken = DB::transaction(function () use($transaction){
                    $payload = [
                        'transaction_details' => [
                            'order_id' => $transaction->code,
                            'gross_amount' => $transaction->total_payment
                        ],
                        'customer_details' => [
                            'first_name' => $transaction->user->name,
                            'email' => $transaction->user->email,
                            'phone' => $transaction->user && $transaction->user->student ? $transaction->user->student->phone_number : '',
                        ],
                        'item_details' => [
                            [
                                'id' => $transaction->id,
                                'price' => $transaction->total_payment,
                                'quantity' => 1,
                                'name' => Str::limit($transaction->description, 40)
                            ]
                        ]
                    ];
        
                    $snapToken = Snap::getSnapToken($payload);
        
                    $transaction->snap_token = $snapToken;
        
                    $transaction->save();
        
                    return $this->response['snapToken'] = $snapToken;
                });
            } else if($request->payment_method == 'account_balance') {
                Auth::user()->update(['account_balance' => Auth::user()->account_balance - $transaction->total_payment]);
                
                $transaction->update([
                    'transaction_status' => 'done',
                    'expired_date' => Carbon::now()->addMonths($transaction->active_period)
                ]);

                session()->flash('success', 'Pembelian Paket Voucher Dengan Saldo Berhasil.');
            } else {
                session()->flash('success', 'Silakan untuk melakukan pembayaran.');
            }

            return redirect()->route('user.transactions.show', $transaction->id);
        } catch (\Exception $e) {
            session()->flash('error', $e);
            return redirect()->back();
        }
    }
}
