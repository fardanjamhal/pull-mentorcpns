<?php

namespace App\Http\Controllers\User\Material;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Material\VideoModuleRepository;
use App\Repositories\MasterData\CategoryRepository;
use App\Models\UserMemberCategory;
use Auth;
use Carbon\Carbon;

class VideoModuleController extends Controller
{
    protected $videoModuleRepository;

    public function __construct(VideoModuleRepository $videoModuleRepository)
    {
        $this->videoModuleRepository = $videoModuleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('User/Material/VideoModule/Index', [
            'categoryVideoModules' => (new CategoryRepository())->getCategoryVideoModules(),
            'userMemberCategories' => UserMemberCategory::where('user_id', Auth::user()->id)->where('expired_date', '>', Carbon::now())->get()
        ]);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module = $this->videoModuleRepository->find($id);

        if(!$module) {
            return abort('404');
        }

        return redirect()->away($module->link);
        
    }
}
