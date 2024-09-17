<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\Models\Lawyer;
use Illuminate\Http\Request;

class LawyerRepository extends BaseRepository
{



    public function __construct(Lawyer $model)
    {
        parent::__construct($model);
    }


   

  


}