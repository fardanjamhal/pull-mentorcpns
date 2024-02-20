<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\Voucher;
use App\Repositories\Contracts\Transaction\VoucherInterface;
use App\Repositories\BaseRepository;

class VoucherRepository extends BaseRepository implements VoucherInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Voucher();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $vouchers = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $vouchers->where('name', 'like', '%' . $params->search . '%');
        $vouchers = $vouchers->with(['category'])->orderBy('created_at', 'ASC')->paginate($limit);
        
        $vouchers->appends([
            'search' => $params->search,
        ]);

        return $vouchers;
    }

    public function find($id)
    {
        return $this->model->with(['category', 'subCategories'])->find($id);
    }

    public function getAllActivated($params)
    {
        return $this->model->with(['category', 'subCategories'])->where('is_active', 1)->where('category_id', $params->category_id)->orderBy('created_at', 'ASC')->get();
    }

    public function create($attributes)
    {
        $input = $attributes->all();

        if($attributes->member_categories) {
            foreach ($attributes->member_categories as $subCategory) {
                $memberCategories[] = $subCategory['name'];
            }
    
            $input['member_categories'] = $memberCategories;
        } else {
            $input['member_categories'] = null;
        }

        $voucher = $this->model->create($input);

        $subCategoryIds = [];

        foreach ($attributes->sub_category_ids as $subCategory) {
            $subCategoryIds[] = $subCategory['id'];
        }
        
        $voucher->subCategories()->sync($subCategoryIds);

        return $voucher;
    }

    public function update($attributes, $id)
    {
        $input = $attributes->except('_token','_method');
        $voucher = $this->model->find($id);

        if($attributes->member_categories) {
            foreach ($attributes->member_categories as $subCategory) {
                $memberCategories[] = $subCategory['name'];
            }
    
            $input['member_categories'] = $memberCategories;
        } else {
            $input['member_categories'] = null;
        }

        $voucher->update($input);
        $subCategoryIds = [];

        foreach ($attributes->sub_category_ids as $subCategory) {
            $subCategoryIds[] = $subCategory['id'];
        }
        
        $voucher->subCategories()->sync($subCategoryIds);

        return $voucher;
    }
}
