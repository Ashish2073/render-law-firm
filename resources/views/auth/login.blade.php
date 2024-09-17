<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}|Login</title>
    <link rel="icon" href="{{ asset('favicon2.png') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for animations */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Floating label effect */
        .floating-label-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .floating-label-group input {
            width: 100%;
            padding: 0.75rem 0.75rem 0.75rem 0.75rem;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            transition: all 0.2s ease-in-out;
        }

        .floating-label-group input:focus {
            outline: none;
            border-color: #4299e1;
        }

        .floating-label-group label {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            font-size: 1rem;
            color: #aaa;
            transition: all 0.2s ease-in-out;
        }

        .floating-label-group input:focus + label,
        .floating-label-group input:not(:placeholder-shown) + label {
            top: -0.75rem;
            left: 0.75rem;
            font-size: 0.75rem;
            color: #4299e1;
            background: white;
            padding: 0 0.25rem;
        }
    </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-4 fade-in">
        <div class="bg-white shadow-lg rounded-lg px-8 pt-8 pb-8 mb-4">
            <div class="flex justify-center mb-2">
                <img src="{{ asset('logo.webp') }}" alt="{{ env('APP_NAME') }}" class="h-24 w-36 animate-bounce">
            </div>
            <h1 class="text-2xl text-center text-gray-700 font-bold mb-6">Login to Admin Portal</h1>

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="floating-label-group">
                    <input type="text" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder=" " required>
                    <label for="email" class="text-gray-600">Email</label>
                </div>
                <div class="floating-label-group mb-6">
                    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder=" " required>
                    <label for="password" class="text-gray-600">Password</label>
                </div>
                @if ($errors->has('error'))
                    <p class="text-center text-red-500 font-semibold text-md my-2">{{ $errors->first('error') }}</p>
                @endif
                <div class="flex items-center justify-between mb-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200 transform hover:scale-105" type="submit">
                        Sign In
                    </button>
                    {{-- <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800 transition duration-200" href="#">
                        Forgot Password?
                    </a> --}}
                </div>
            </form>
        </div>
        <p class="text-center text-white text-xs">
            &copy;2024 {{ env('APP_NAME') }}. All rights reserved.
        </p>
    </div>
</body>
</html>
