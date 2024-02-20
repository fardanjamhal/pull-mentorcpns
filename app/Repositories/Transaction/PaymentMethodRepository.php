<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\PaymentMethod;
use App\Repositories\Contracts\Transaction\PaymentMethodInterface;
use App\Repositories\BaseRepository;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new PaymentMethod();
    }

    public function getAllActivated()
    {
        return $this->model->where('is_active', 1)->get();
    }
}
