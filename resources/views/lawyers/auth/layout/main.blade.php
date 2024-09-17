<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | Login</title>
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

    @yield('lawyer-auth-section')


    @yield('lawyer-page-script')

</body> 
</html>


