<?php

namespace App\Http\Controllers\User\Material;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Material\ModuleRepository;
use App\Repositories\MasterData\CategoryRepository;
use App\Models\UserMemberCategory;
use Auth;
use Carbon\Carbon;

class ModuleController extends Controller
{
    protected $moduleRepository;

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return UserMemberCategory::where('user_id', Auth::user()->id)->where('expired_date', '>', Carbon::now())->get();

        return inertia('User/Material/Module/Index', [
            'categoryModules' => (new CategoryRepository())->getCategoryModules(),
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
        $module = $this->moduleRepository->find($id);

        if(!$module) {
            return abort('404');
        }

        return redirect()->away($module->link);
        
    }
}
