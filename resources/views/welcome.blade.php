<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" />

    <title>{{ config('app.name', 'Qr Code') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/21f9eb4e12.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <style>
        .buttonSizeAll {
            width: 200px;
        }    
    </style>    
    {{-- <div id="app">
        <login-component/>
    </div> --}}
    <div id="app">
        <router-view/>
        {{-- <base-component></base-component> --}}
    </div>
</body>
<script type="text/javascript">
</script>
</html>

