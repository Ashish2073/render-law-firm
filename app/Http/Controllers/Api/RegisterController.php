<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string',
            'email'             => 'required|email|unique:customers',
            'phone'             => 'nullable|string|unique:customers',
            'password'          => 'required|string|min:6',
            'confirm_password'  => 'required|string|same:password',
        ]);

        $customer = Customer::create($data);

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'customer' => $customer,
            'token' => $token,
        ]);
    }
}
