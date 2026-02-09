<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pulse</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    @vite(['resources/js/website.js', 'resources/css/app.css'])

    <!-- Pass auth user to JavaScript -->
    <script>
        window.authUser = @json(auth('web')->user());
    </script>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body>
    <div id="website-app">
        <router-view></router-view>
    </div>
</body>
</html>
