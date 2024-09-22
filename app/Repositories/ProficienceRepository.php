<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\Models\Proficience;
use Illuminate\Http\Request;

class ProficienceRepository extends BaseRepository
{



    public function __construct(Proficience $model)
    {
        parent::__construct($model);
    }







}