<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MasterData\AnnouncementRepository;

class AnnouncementController extends Controller
{
    protected $announcementRepository;

    public function __construct(AnnouncementRepository $announcementRepository)
    {
        $this->announcementRepository = $announcementRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('User/Announcement/Index', [
            'announcements' => $this->announcementRepository->getAllPaginatedWithParams($request)

        ]);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return inertia('User/Announcement/Show', [
            'announcement' => $this->announcementRepository->find($id),
        ]);
    }
}
