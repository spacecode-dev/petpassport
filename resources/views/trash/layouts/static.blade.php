<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">

        <title>Title</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
        <link rel="manifest" href="/icons/site.webmanifest">
        <link rel="mask-icon" href="/icons/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </head>

    <body style="/*overflow: hidden; opacity: 0*/">
        <root>
            @yield('content')
        </root>

        <script src="{{ mix('/js/template.js') }}"></script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
