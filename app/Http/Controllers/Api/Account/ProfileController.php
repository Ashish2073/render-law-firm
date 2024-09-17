<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => auth()->user(),
        ]);
    }
}
