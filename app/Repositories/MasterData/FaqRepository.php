<?php

namespace App\Repositories\MasterData;

use App\Models\MasterData\Faq;
use App\Repositories\Contracts\MasterData\FaqInterface;
use App\Repositories\BaseRepository;

class FaqRepository extends BaseRepository implements FaqInterface
{
    /**
     * @var
     */
    protected $model;
    public function __construct()
    {
        $this->model = new Faq();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $faqs = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $faqs->where('question', 'like', '%' . $params->search . '%');
        $faqs = $faqs->orderBy('created_at', 'ASC')->paginate($limit);

        $faqs->appends([
            'search' => $params->search,
        ]);
        return $faqs;
    }

    public function getAllWithParams($params)
    {
        $faq = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $faq->where('question', 'like', '%' . $params->search . '%');
        $faq = $faq->orderBy('created_at', 'ASC')->get();
        return $faq;
    }
}
