<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<meta name="keywords" content="" />--}}
    {{--<meta name="description" content=""/>--}}
    <!-- Styles -->
    <style></style>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div id="app">

</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
