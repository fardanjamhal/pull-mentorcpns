<?php

namespace App\Http\Controllers\Admin\Lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Lesson\DetailValueCategoryRepository;
use App\Repositories\Lesson\ValueCategoryRepository;
use App\Http\Requests\Lesson\DetailValueCategoryRequest;

class DetailValueCategoryController extends Controller
{
    protected $detailValueCategoryRepository;

    public function __construct(DetailValueCategoryRepository $detailValueCategoryRepository)
    {
        $this->detailValueCategoryRepository = $detailValueCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($valueCategoryId, Request $request)
    {
        if(!(new ValueCategoryRepository())->find($valueCategoryId)) return abort('404', 'uppss....');

        return inertia('Admin/Lesson/DetailValueCategory/Index', [
            'valueCategory' => (new ValueCategoryRepository())->find($valueCategoryId),
            'detailValueCategories' => $this->detailValueCategoryRepository->getAllByValueCategoryPaginatedWithParams($valueCategoryId, $request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($valueCategoryId)
    {
        if(!(new ValueCategoryRepository())->find($valueCategoryId)) return abort('404', 'uppss....');

        return inertia('Admin/Lesson/DetailValueCategory/Create', [
            'valueCategory' => (new ValueCategoryRepository())->find($valueCategoryId)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($valueCategoryId, DetailValueCategoryRequest $request)
    {
        try {
            if(!(new ValueCategoryRepository())->find($valueCategoryId)) return abort('404', 'uppss....');

            $this->detailValueCategoryRepository->create($request->all());

            return redirect()->route('admin.value-categories.detail-value-categories.index', $valueCategoryId);

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
    public function edit($valueCategoryId, $id)
    {
        if(!(new ValueCategoryRepository())->find($valueCategoryId)) return abort('404', 'uppss....');

        if(!$this->detailValueCategoryRepository->find($id)) return abort('404', 'uppss....');

        return inertia('Admin/Lesson/DetailValueCategory/Edit', [
            'valueCategory' => (new ValueCategoryRepository())->find($valueCategoryId),
            'detailValueCategory' => $this->detailValueCategoryRepository->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($valueCategoryId, DetailValueCategoryRequest $request, $id)
    {
        try {
            if(!(new ValueCategoryRepository())->find($valueCategoryId)) return abort('404', 'uppss....');

            if(!$this->detailValueCategoryRepository->find($id)) return abort('404', 'uppss....');

            $this->detailValueCategoryRepository->update($request->all(), $id);

            return redirect()->route('admin.value-categories.detail-value-categories.index', $valueCategoryId);

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
    public function destroy($valueCategoryId, $id)
    {
        try {
            if(!(new ValueCategoryRepository())->find($valueCategoryId)) return abort('404', 'uppss....');

            if(!$this->detailValueCategoryRepository->find($id)) return abort('404', 'uppss....');

            $this->detailValueCategoryRepository->delete($id);

            return redirect()->route('admin.value-categories.detail-value-categories.index', $valueCategoryId);

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back();
        }
    }
}
