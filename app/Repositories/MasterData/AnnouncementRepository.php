<?php

namespace App\Repositories\MasterData;

use App\Models\MasterData\Announcement;
use App\Repositories\Contracts\MasterData\AnnouncementInterface;
use App\Repositories\BaseRepository;

class AnnouncementRepository extends BaseRepository implements AnnouncementInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Announcement();
    }

    public function getAllPaginatedWithParams($params, $limit = 10)
    {
        $announcements = $this->model->query();
        if(isset($params->search) && !empty($params->search)) $announcements->where('title', 'like', '%' . $params->search . '%');
        $announcements = $announcements->paginate($limit);

        $announcements->appends([
            'search' => $params->search,
        ]);

        return $announcements;
    }

    public function getAnnouncementSummaries($limit = 10)
    {
        $announcements = $this->model->orderBy('created_at', 'DESC')->limit($limit)->get();
        return $announcements;
    }
}
