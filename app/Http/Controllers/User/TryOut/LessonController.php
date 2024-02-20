<?php

namespace App\Http\Controllers\User\TryOut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Lesson\LessonCategoryRepository;
use App\Repositories\Lesson\LessonRepository;

class LessonController extends Controller
{
    protected $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId, $lessonCategoryId)
    {
        return inertia('User/TryOut/Lesson/Index', [
            'lessons' => $this->lessonRepository->getAllByLessonCategory($lessonCategoryId),
            'categoryId' => $categoryId
        ]);
    }
}
