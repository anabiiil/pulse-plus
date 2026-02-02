<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pulse')</title>

    @vite(['resources/js/website.js', 'resources/css/app.css'])
</head>
<body>
    <div id="website-app">
        <website-layout>
            @yield('content')
        </website-layout>
    </div>
</body>
</html>
