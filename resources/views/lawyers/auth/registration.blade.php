@extends('lawyers.auth.layout.main')
@section('lawyer-auth-section')


    <div class="w-full max-w-md p-4 fade-in">
        <div class="bg-white shadow-lg rounded-lg px-8 pt-8 pb-8 mb-4">
            <div class="flex justify-center mb-2">
                <img src="{{ asset('logo.webp') }}" alt="{{ env('APP_NAME') }}" class="h-24 w-36 animate-bounce">
            </div>
            <h1 class="text-2xl text-center text-gray-700 font-bold mb-6">Lawyer Registration</h1>

            <form action="{{ route('lawyer.registration') }}" method="POST">
                @csrf
                <div class="floating-label-group">
                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder=" " required>
                    <label for="name" class="text-gray-600">Name</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder=" " required>
                    <label for="email" class="text-gray-600">Email</label>
                </div>
                <div class="floating-label-group mb-6">
                    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder=" " required>
                    <label for="password" class="text-gray-600">Password</label>
                </div>
                <div class="floating-label-group mb-6">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder=" " required>
                    <label for="password_confirmation" class="text-gray-600">Confirm Password</label>
                </div>
                @if ($errors->has('error'))
                    <p class="text-center text-red-500 font-semibold text-md my-2">{{ $errors->first('error') }}</p>
                @endif
                <div class="flex items-center justify-between mb-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200 transform hover:scale-105" type="submit">
                        Sign Up
                    </button>
                  
                </div>
                <div class="text-center">
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800 transition duration-200" href="{{url('lawyer')}}">
                        I have an account? Sign Login
                    </a>
                </div>
            </form>
        </div>
        <p class="text-center text-white text-xs">
            &copy;2024 {{ env('APP_NAME') }}. All rights reserved.
        </p>
    </div>

@endsection    

