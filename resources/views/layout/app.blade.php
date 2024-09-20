<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

{{--    <link rel="icon" href="{{asset('public/img/favicon.ico')}}" type="image/x-icon">--}}

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <script src="{{asset('public/js/bootstrap.bundle.js')}}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,700&display=swap" rel="stylesheet">
</head>
<body>
<script src="{{asset('public/js/vue.global.js')}}"></script>
@include('layout.navbar')
@yield('main')
@include('layout.footer')
</body>
</html>
