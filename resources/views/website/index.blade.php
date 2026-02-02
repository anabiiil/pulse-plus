<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pulse</title>

    @vite(['resources/js/website.js', 'resources/css/app.css'])

    <!-- Pass auth user to JavaScript -->
    <script>
        window.authUser = @json(auth('web')->user());
    </script>
</head>
<body>
    <div id="website-app">
        <router-view></router-view>
    </div>
</body>
</html>
