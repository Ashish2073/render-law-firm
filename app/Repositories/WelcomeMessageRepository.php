<?php

namespace App\Repositories;

use App\Models\WelcomeMessage;

class WelcomeMessageRepository extends BaseRepository
{
    public function __construct(WelcomeMessage $model)
    {
        parent::__construct($model);
    }

    public function all()
    {
        return $this->model->where('status', 1)->get();
    }
}