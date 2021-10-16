<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app-build.css') }}" rel="stylesheet">
</head>
<body class="{{ body_class() }}">
    <div id="app"></div>
    @include('index.dataTransfer.backendConfig')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>