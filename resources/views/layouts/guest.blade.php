<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Panel - Al-Ruhamaa Background with Overlay -->
            <div class="hidden lg:flex lg:w-1/2 login-bg-panel">
                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-center items-center w-full text-white px-12">
                    <div class="text-center">
                        <div class="mb-8">
                            <x-application-logo class="w-24 h-24 fill-current text-white mx-auto mb-6" />
                        </div>
                        <h1 class="text-5xl font-bold mb-6">Al-Ruhamaa</h1>
                        <p class="text-2xl font-light tracking-wide opacity-90">Melayani Dengan Amanah</p>
                        <div class="mt-8 w-24 h-1 bg-white opacity-60 mx-auto"></div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 py-12 login-form-panel">
                <div class="w-full max-w-md">
                    <!-- Logo for mobile and small screens -->
                    <div class="flex justify-center mb-8 lg:hidden">
                        <a href="/">
                            <x-application-logo class="w-16 h-16 fill-current text-gray-600" />
                        </a>
                    </div>
                    
                    <!-- Welcome Text -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-semibold text-gray-900 mb-2">Welcome Back</h2>
                        <p class="text-gray-600">Please sign in to your account</p>
                    </div>

                    <!-- Login Form Container -->
                    <div class="bg-white rounded-xl shadow-lg p-8 space-y-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
