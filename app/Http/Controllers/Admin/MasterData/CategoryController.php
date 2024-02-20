<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MasterData\CategoryRepository;
use App\Repositories\Lesson\LessonCategoryRepository;
use App\Http\Requests\MasterData\CategoryRequest;
use App\Models\MasterData\SubCategory;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Admin/MasterData/Category/Index', [
            'categories' => $this->categoryRepository->getAllPaginatedWithParams($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/MasterData/Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $this->categoryRepository->create($request);

            return redirect()->route('admin.categories.index');

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
        if(!$this->categoryRepository->find($id)) return abort('404', 'uppss....');

        return inertia('Admin/MasterData/Category/Edit', [
            'category' => $this->categoryRepository->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            if(!$this->categoryRepository->find($id)) return abort('404', 'uppss....');

            $this->categoryRepository->update($request, $id);

            return redirect()->route('admin.categories.index');

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
            $this->categoryRepository->delete($id);

            return redirect()->route('admin.categories.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());
            
            return redirect()->back()->withInput($request->all());
        }
    }

    public function getLessonCategory($categoryId)
    {
        return (new LessonCategoryRepository())->getAllByCategory($categoryId);
    }

    public function getSubCategory($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)->select('id', 'name')->get();

       return $subCategories;
    }

}
