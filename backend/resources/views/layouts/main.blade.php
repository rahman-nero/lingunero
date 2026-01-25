<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    @vite([
        'resources/sass/main.sass',
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/main.js',
    ])

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col bg-gray-100">
@include('components.site.navigation')

<main id="root" class="@yield('root-classes') flex-1">
    @include('components.site.errors')
    @include('components.site.info')

    @yield('content')
</main>


<!-- Scripts -->
@stack('js')

</body>
</html>
