<?php

namespace App\Http\Controllers\Admin\Material;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Material\VideoModuleRepository;
use App\Http\Requests\Material\VideoModuleRequest;
use App\Repositories\MasterData\CategoryRepository;
use App\Repositories\User\MemberCategoryRepository;

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
    public function index(Request $request)
    {
        return inertia('Admin/Material/VideoModule/Index', [
            'videoModules' => $this->videoModuleRepository->getAllPaginatedWithParams($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Material/VideoModule/Create', [
            'categories' => (new CategoryRepository())->all(),
            'memberCategories' => (new MemberCategoryRepository())->getAllActivated()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoModuleRequest $request)
    {
        try {
            $this->videoModuleRepository->create($request);

            return redirect()->route('admin.video-modules.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$this->videoModuleRepository->find($id)) return abort('404', 'uppss....');

        return inertia('Admin/Material/VideoModule/Edit', [
            'videoModule' => $this->videoModuleRepository->find($id),
            'categories' => (new CategoryRepository())->all(),
            'memberCategories' => (new MemberCategoryRepository())->getAllActivated(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoModuleRequest $request, $id)
    {
        try {
            if(!$this->videoModuleRepository->find($id)) return abort('404', 'uppss....');

            $this->videoModuleRepository->update($request, $id);

            return redirect()->route('admin.video-modules.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->videoModuleRepository->delete($id);
            
            return redirect()->route('admin.video-modules.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }
}
