<!DOCTYPE html>
<html>
<head lang="ru">
    <title> @yield('title') | Сервис Агромаркет</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    @include('layouts.icons')
    
    @section('head')
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <script src="{{asset('js/app.js')}}"></script>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @show

</head>
<body>

<div class="page-center">
    <div class="page-center-in">
        <div class="container-fluid">
            @yield('error-box')
        </div>
    </div>
</div><!--.page-center-->

</body>
</html>