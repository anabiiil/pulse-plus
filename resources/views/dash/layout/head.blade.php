<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="Description" content="Main Dashboard">
    <meta name="Author" content="{{ config('app.name') }}">
    <meta name="keywords" content="Dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('dash/assets') }}/images/brand-logos/favicon.ico" type="image/x-icon">

    <!-- Choices JS -->
    <script src="{{ asset('dash/assets') }}/libs/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- Main Theme Js -->
    <script src="{{ asset('dash/assets') }}/js/main.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('dash/assets') }}/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @livewireStyles
    <!-- Style Css -->
    <link href="{{ asset('dash/assets') }}/css/styles.min.css" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="{{ asset('dash/assets') }}/css/icons.css" rel="stylesheet" >

    <!-- Node Waves Css -->
    <link href="{{ asset('dash/assets') }}/libs/node-waves/waves.min.css" rel="stylesheet" >

    <!-- Simplebar Css -->
    <link href="{{ asset('dash/assets') }}/libs/simplebar/simplebar.min.css" rel="stylesheet" >

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('dash/assets') }}/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('dash/assets') }}/libs/@simonwep/pickr/themes/nano.min.css">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('dash/assets') }}/libs/choices.js/public/assets/styles/choices.min.css">
    @vite('resources/css/app.css')

</head>
