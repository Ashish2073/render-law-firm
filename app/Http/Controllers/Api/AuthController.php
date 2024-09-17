<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function createToken(Request $request)
    {
        // create token without user login 
        $token = $request->user()->createToken($request->token_name);
    }
}
