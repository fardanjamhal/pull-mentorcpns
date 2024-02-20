<?php

namespace App\Http\Controllers\User\TryOut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Lesson\LessonCategoryRepository;
use App\Repositories\MasterData\CategoryRepository;

class LessonCategoryController extends Controller
{
    protected $lessonCategoryRepository, $categoryService;

    public function __construct(LessonCategoryRepository $lessonCategoryRepository)
    {
        $this->lessonCategoryRepository = $lessonCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId)
    {
        if(!(new CategoryRepository())->find($categoryId)) return abort('404', 'uppss....');

        return inertia('User/TryOut/LessonCategory/Index', [
            'lessonCategories' => $this->lessonCategoryRepository->getAllByCategory($categoryId)
        ]);
    }
}
