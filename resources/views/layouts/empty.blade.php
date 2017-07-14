<!DOCTYPE html>
<html>

<head lang="ru">
    <title> @yield('title') | Сервис Агромаркет</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    @include('layouts.icons')
    <!-- <script type="text/javascript" src="https://getfirebug.com/firebug-lite-debug.js"></script>  -->

    @section('head')
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="{{asset('js/app.js')}}"></script>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap-table.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap-table-reorder-rows.css')}}">
        <link rel="stylesheet" href="{{asset('css/jquery.typeahead.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    @show
</head>
<body>
    @yield('page')
    <div class="loader">
        <div class="loader__content">
            <img src="/img/ajax-loader.gif" />
        </div>
    </div>
</body>
</html>
