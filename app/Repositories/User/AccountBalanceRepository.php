<?php

namespace App\Repositories\User;

use App\Models\AccountBalance;
use App\Models\User;
use App\Models\Setting;
use App\Repositories\Contracts\User\AccountBalanceInterface;
use App\Repositories\BaseRepository;
use Auth;

class AccountBalanceRepository extends BaseRepository implements AccountBalanceInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new AccountBalance();
    }

    public function getAllPaginatedWithParamsByUser($params, $limit = 10)
    {
        $accountBalances = $this->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate($limit);
        return $accountBalances;
    }

    public function find($id)
    {
        return $this->model->with(['user', 'user.student', 'user.student.province', 'user.student.city', 'user.student.district', 'user.student.village',])->find($id);
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $accountBalances = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $accountBalances->where('code', 'like', '%' . $params->search . '%');
        if(isset($params->transaction_status) && !empty($params->transaction_status)) $accountBalances->where('transaction_status', $params->transaction_status);
        $accountBalances = $accountBalances->with('user')->orderBy('created_at', 'DESC')->paginate($limit);

        $accountBalances->appends([
            'search' => $params->search,
            'transaction_status' => $params->transaction_status,
        ]);

        return $accountBalances;
    }

    public function create($attributes)
    {
        $attributes['code'] = AccountBalance::generateCode();
        $attributes['user_id'] = Auth::user()->id;
        $accountBalance = $this->model->create($attributes);

        $user = User::find($accountBalance->user_id);
        $setting = Setting::first();

        $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\n*TOP UP SALDO* \n\nNomor Transaksi: ".$accountBalance->code."\nTotal Pembayaran: *Rp".number_format($accountBalance->top_up_balance, 2, ",", ".")."*\n\n*_Saldo akan bertambah setelah anda membayar ke nomor rekening yang terdaftar. Silakan konfirmasi dan kirim bukti pembayaran ke Whatsapp ini._*\n\nterimakasih.";

        sendWhatsappNotification($user->student->phone_number, $message);

        return $accountBalance;
    }

    public function update($attributes, $id)
    {
        $input = $attributes->except('_token', '_method');
        $setting = Setting::first();

        $accountBalance = $this->find($id);

        if ($attributes->transaction_status == "paid") {
            $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\n*TOP UP SALDO*\n\nNomor Transaksi: ".$accountBalance->code."\ntotal Pembayaran: *Rp".number_format($accountBalance->top_up_balance, 2, ",", ".")."*\n\n*PEMBAYARAN TELAH DITERIMA*\n\nterimakasih.";
        } elseif ($attributes->transaction_status == "failed") {
            $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\n*TOP UP SALDO*\n\nNomor Transaksi: ".$accountBalance->code."\nTotal Pembayaran: *Rp".number_format($accountBalance->top_up_balance, 2, ",", ".")."*\n\n*TRANSAKSI DIBATALKAN, SILAKAN LAKUKAN TRANSAKSI ULANG*\n\nterimakasih.";
        } elseif ($attributes->transaction_status == "done") {
            $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\n*TOP UP SALDO* \n\nNomor Transaksi: ".$accountBalance->code."\nTotal Pembayaran: *Rp".number_format($accountBalance->top_up_balance, 2, ",", ".")."*\n\n*SELAMAT, SALDO ANDA TELAH BERTAMBAH*.\n\nterimakasih.";
            
            $user = User::find($accountBalance->user_id);
            $user->update(['account_balance' => $user->account_balance + $accountBalance->top_up_balance]);
        }
    
        $accountBalance->update($input);

        sendWhatsappNotification($accountBalance->user->student->phone_number, $message);

        return $accountBalance;
    }
}
