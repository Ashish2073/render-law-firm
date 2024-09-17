<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerRepository extends BaseRepository
{



    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }


   

  


}