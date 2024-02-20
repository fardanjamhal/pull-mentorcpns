<?php

namespace App\Repositories\User;

use App\Models\MemberCategory;
use App\Repositories\Contracts\User\MemberCategoryInterface;
use App\Repositories\BaseRepository;
use Auth;

class MemberCategoryRepository extends BaseRepository implements MemberCategoryInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new MemberCategory();
    }

    public function getAllActivated()
    {
        return $this->model->where('status', 1)->orderBy('created_at', 'ASC')->get();
    }
}
