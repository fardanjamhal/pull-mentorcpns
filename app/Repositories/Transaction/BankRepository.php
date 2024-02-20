<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\Bank;
use App\Repositories\Contracts\Transaction\BankInterface;
use App\Repositories\BaseRepository;
use App\Services\UploadService;

class BankRepository extends BaseRepository implements BankInterface
{
    /**
     * @var
     */
    protected $model;

    protected $image_path = 'upload_files/banks';

    public function __construct()
    {
        $this->model = new Bank();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $banks = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $banks->where('bank_name', 'like', '%' . $params->search . '%');
        $banks = $banks->orderBy('created_at', 'ASC')->paginate($limit);

        $banks->appends([
            'search' => $params->search,
        ]);

        return $banks;
    }

    public function all($columns = ['*'])
    {
        return $this->model->orderBy('created_at', 'ASC')->get($columns);
    }

    public function create($attributes)
    {
        $input = $attributes->all();

        if($attributes->hasFile('image')){
            $file = $attributes->file('image')->getClientOriginalName();
            $filename = (new UploadService())->uploadFile($attributes->file('image'), $this->image_path);
            $input['image'] = $filename;
        }

        return $this->model->create($input);
    }

    public function update($attributes, $id)
    {
        $bank = $this->model->find($id);
        $input = $attributes->all();

        if($attributes->hasFile('image')){
            $file = $attributes->file('image')->getClientOriginalName();
            $filename = (new UploadService())->uploadFile($attributes->file('image'), $this->image_path);
            (new UploadService())->deleteFile($bank->image, $this->image_path);
            $input['image'] = $filename;
        } else {
            $input['image'] = $bank->image;
        }

        return $bank->update($input);
    }

    public function delete($id)
    {
        $bank = $this->model->find($id);
        (new UploadService())->deleteFile($bank->image, $this->image_path);
        return $bank->delete();
    }
}
