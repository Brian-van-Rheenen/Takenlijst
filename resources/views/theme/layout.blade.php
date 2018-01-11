<!DOCTYPE html>
<html lang="nl">
<head>
    <title>{{ $meta_title }}</title>
    <meta charset="utf-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('img/favicon/clipboard16x16.png') }}" sizes="16x16">
    <link rel="icon" href="{{ asset('img/favicon/clipboard32x32.png') }}" sizes="32x32">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

    <main id="main">

        @yield('content')

    </main>

    @yield('scripts')

</body>
</html>