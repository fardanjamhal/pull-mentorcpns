<?php

namespace App\Repositories\Contracts\Exam;

interface GradeInterface
{
    public function all();

    public function find($id);
}
