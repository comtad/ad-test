<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title','PAST & PLAY')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
@includeIf('partials.header')

@yield('content')

<script src="{{ mix('js/app.js') }}" defer></script>
@stack('scripts')
</body>
</html>
