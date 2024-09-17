<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Http\Controllers\Base\SingleInputFieldController;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class SubscriptionController extends SingleInputFieldController
{

    public function __construct()
    {
        $this->model = Feature::class;
        $this->viewPath = 'subscription.feature.index'; 
    }
   

}
