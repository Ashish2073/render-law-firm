<?php

namespace App\Repositories;

use App\Models\PracticeArea;

class PracticeAreaRepository extends BaseRepository
{
    public function __construct(PracticeArea $model)
    {
        parent::__construct($model);
    }

    public function getParentPracticeAreas()
    {
        return $this->model->whereNull('parent_id')->get();
    }
}
