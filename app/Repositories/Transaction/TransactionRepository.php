<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\Transaction;
use App\Repositories\Contracts\Transaction\TransactionInterface;
use App\Repositories\BaseRepository;
use Auth;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\UserMemberCategory;
use App\Models\User;
use App\Models\Transaction\PaymentConfirmation;
use App\Repositories\Exam\ExamRepository;
use App\Repositories\Exam\ExamGroupRepository;
use Illuminate\Support\Str;
use App\Services\UploadService;

class TransactionRepository extends BaseRepository implements TransactionInterface
{
    /**
     * @var
     */
    protected $model;

    protected $image_path = 'upload_files/payment_confirmation';


    public function __construct()
    {
        $this->model = new Transaction();
    }

    public function getAllSimplePaginatedWithParams($params, $limit = 10)
    {
        $transactions = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        $transactions = $transactions->orderBy('created_at', 'DESC')->simplePaginate($limit);
        return $transactions;
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $transactions = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        if(isset($params->transaction_status) && !empty($params->transaction_status)) $transactions->where('transaction_status', $params->transaction_status);
        if(isset($params->start_date) && !empty($params->start_date) && isset($params->end_date) && !empty($params->end_date)) $transactions->whereBetween('created_at', [$params->start_date, $params->end_date]);
        $transactions = $transactions->with(['user', 'exam', 'examGroup'])->orderBy('created_at', 'DESC')->paginate($limit);

        $transactions->appends([
            'search' => $params->search,
            'transaction_status' => $params->transaction_status,
            'start_date' => $params->start_date,
            'end_date' => $params->end_date,
        ]);

        return $transactions;
    }

    public function getTransactionMonthly($limit = 10)
    {
        $transactions = $this->model->whereMonth('created_at', Carbon::now()->format('m'))->whereYear('created_at', Carbon::now()->format('Y'))->with(['user', 'exam', 'examGroup'])->orderBy('created_at', 'DESC')->paginate($limit);
        return $transactions;
    }

    public function find($id)
    {
        return $this->model->with([
            'paymentConfirmation', 
            'paymentConfirmation.bank', 
            'category', 
            'user', 
            'user.student', 
            'user.student.province', 
            'user.student.city', 
            'user.student.district', 
            'user.student.village', 
            'exam', 
            'examGroup', 
            'lessonCategory'
        ])->find($id);
    }

    public function getAllPaginatedWithParamsByUser($params, $limit = 10)
    {
        $transactions = $this->model;
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        $transactions = $transactions->with(['examGroup', 'exam'])->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate($limit);
        return $transactions;
    }

    public function getAllVoucherActivatedPaginatedWithParamsByUser($params, $limit = 10)
    {
        $transactions = $this->model;
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        $transactions = $transactions->where('voucher_activated', 1)->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate($limit);
        return $transactions;
    }

    public function getSummaryTransactionByUser($limit = 5)
    {
        $transactions = $this->model;
        $transactions = $transactions->with(['examGroup', 'exam'])->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate($limit);
        return $transactions;
    }

    public function getTotalTransactionToday()
    {
        return $this->model->whereDate('created_at', Carbon::now())->count();
    }

    public function getTotalTransactionMonthly()
    {
        return $this->model->whereMonth('created_at', Carbon::now()->format('m'))->whereYear('created_at', Carbon::now()->format('Y'))->count();
    }

    public function getTotalTransactionYearly()
    {
        return $this->model->whereYear('created_at', Carbon::now()->format('Y'))->count();
    }

    public function getTotalTransactionPending()
    {
        return $this->model->where('transaction_status', 'pending')->count();
    }

    public function getTotalTransactionPaid()
    {
        return $this->model->where('transaction_status', 'paid')->count();
    }

    public function getTotalTransactionDone()
    {
        return $this->model->where('transaction_status', 'done')->count();
    }

    public function getTotalTransactionFailed()
    {
        return $this->model->where('transaction_status', 'failed')->count();
    }

    public function checkTransactionPendingByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'pending'])->first();
    }

    public function getTotalTransactionPendingByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'pending'])->count();
    }

    public function getTotalTransactionPaidByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'paid'])->count();
    }

    public function getTotalTransactionDoneByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'done'])->count();
    }

    public function getTotalTransactionFailedByUser()
    {
        return $this->model->where(['user_id' => Auth::user()->id, 'transaction_status' => 'failed'])->count();
    }

    public function getAllWithParams($params)
    {
        $transactions = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $transactions->where('code', 'like', '%' . $params->search . '%');
        if(isset($params->transaction_status) && !empty($params->transaction_status)) $transactions->where('transaction_status', $params->transaction_status);
        if(isset($params->start_date) && !empty($params->start_date) && isset($params->end_date) && !empty($params->end_date)) $transactions->whereBetween('created_at', [$params->start_date, $params->end_date]);
        $transactions = $transactions->with(['user', 'exam', 'examGroup', 'category'])->orderBy('created_at', 'DESC')->get();
        return $transactions;
    }

    public function formatPrice($price)
    {
        return "Rp".number_format($price, 0, ",", ".");
    }

    public function update($attributes, $id)
    {
        $input = $attributes->except('_token', '_method');
        $setting = Setting::first();
    
        $transaction = $this->find($id);

        $input['expired_date'] = $transaction->period_type == 'day' ? Carbon::now()->addDays($transaction->active_period) : Carbon::now()->addMonths($transaction->active_period);

        $transaction->update($input);

        if ($attributes->transaction_status == "paid") {
            $message = "*[TRANSAKSI ".$setting->app_name."]*\n\nKode Transaksi: ".$transaction->code."\ntotal Pembayaran: Rp".number_format($transaction->total_payment, 2, ",", ".")."\nketerangan: ".$transaction->description."\n\n*STATUS: PEMBAYARAN DITERIMA*\n\nterimakasih.";
        } elseif ($attributes->transaction_status == "failed") {
            $message = "*[TRANSAKSI ".$setting->app_name."]*\n\nKode Transaksi: ".$transaction->code."\nTotal Pembayaran: Rp".number_format($transaction->total_payment, 2, ",", ".")."\nketerangan: ".$transaction->description."\n\n*STATUS: DIBATALKAN/GAGAL, SILAKAN LAKUKAN TRANSAKSI ULANG*\n\nterimakasih.";
        } elseif ($attributes->transaction_status == "done") {
            $message = "*[TRANSAKSI ".$setting->app_name."]*\n\nKode Transaksi: ".$transaction->code."\nTotal Pembayaran: Rp".number_format($transaction->total_payment, 2, ",", ".")."\nketerangan: ".$transaction->description."\n\n*TRANSAKSI BERHASIL DAN SUDAH AKTIF*\n\nterimakasih.";

            UserMemberCategory::create([
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'category_id' => $transaction->category_id,
                'description' => $transaction->description,
                'member_categories' => $transaction->member_categories,
                'expired_date' => $transaction->expired_date,
            ]);

            UserMemberCategory::where('expired_date', '<', Carbon::now())->delete();
        }
    
        sendWhatsappNotification($transaction->user->student->phone_number, $message);

        return $transaction;
    }

    public function createTransaction($id, $type)
    {
        if($type == 'exam') {
            $exam = (new ExamRepository())->find($id);
        } else {
            $exam = (new ExamGroupRepository())->find($id);
        }

        $transaction = [
            'description' => 'Pembelian '.$exam->title,
            'user_id' => Auth::user()->id,
            'category_id' => $exam->category_id,
            'lesson_category_id' => $exam->lesson_category_id,
            'code' => Transaction::generateCode(),
            'payment_method' => 'account_balance',
            'total_payment' => $exam->price_after_discount ?? 0,
            'transaction_status' => 'done'
        ];

        $transaction[$type == 'exam' ? 'exam_id' : 'exam_group_id'] = $exam->id;

        $transaction = $this->model->create($transaction);

        $user = User::find($transaction->user_id);

        $user->update(['account_balance' => $user->account_balance - $transaction->total_payment]);

        $setting = Setting::first();

        $message = "*[TRANSAKSI ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu"))."]*\n\nNomor Transaksi: ".$transaction->code."\nTotal Pembayaran: *Rp".number_format($transaction->total_payment, 2, ",", ".")."*\n\n*_Proses Pembelian ".$exam->title." berhasil._*\n\nterimakasih.";
        
        sendWhatsappNotification($user->student->phone_number, $message);

        return $transaction;
    }

    public function paymentConfirmation($transactionId, $attributes)
    {
        $input = $attributes->validated();
        $input['transaction_id'] = $transactionId;

        if($attributes->hasFile('file')){
            $file = $attributes->file('file')->getClientOriginalName();
            $filename = (new UploadService())->uploadFile($attributes->file('file'), $this->image_path);
            $input['file'] = $filename;
        }

        $this->model->find($transactionId)->update(['transaction_status' => 'paid']);

        return PaymentConfirmation::create($input);
    }

    public function delete($id)
    {
        $transaction = $this->model->find($id);
        if($transaction->paymentConfirmation) {
            (new UploadService())->deleteFile($transaction->paymentConfirmation->file, $this->image_path);
        }
        return $transaction->delete();
    }
}
