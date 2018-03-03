<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Scarica gratis GARAGE Template html/css - Web Domus Italia - Web Agency </title>
    <meta name="description" content="Scarica gratis il nostro Template HTML/CSS GARAGE. Se avete bisogno di un design per il vostro sito web GARAGE può fare per voi. Web Domus Italia">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Web Domus Italia">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}js/bootstrap-3.3.6-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}font-awesome-4.5.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}css/slider.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}css/contactstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Gudea" rel="stylesheet">
</head>
<body>
<!-- Header -->
<div class="allcontain">
    <div class="header">
        <ul class="socialicon">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
        </ul>
        <ul class="givusacall">
            <li>Give us a call : +66666666 </li>
        </ul>
        <ul class="logreg">
            @if(session()->has('user'))
                <li><a href="/logout">Logout</a></li>
                @else
                    <li><a href="/login">Login </a> </li>
                    <li><a href="/register"><span class="register">Register</span></a></li>
            @endif
        </ul>
    </div>
    <!-- Navbar Up -->
    @include("components.nav")
</div>
<!--_______________________________________ Carousel__________________________________ -->
    @yield("slider")
<!-- ____________________Featured Section ______________________________-->
    <div id="wrapper">
        @yield("content")
    </div>


    @include("components.footer")

<script type="text/javascript" src="{{asset('/')}}js/bootstrap-3.3.6-dist/js/jquery.js"></script>
<script type="text/javascript" src="{{asset('/')}}js/jquery-ui.js"></script>
<script type="text/javascript" src="{{asset('/')}}js/isotope.js"></script>
<script type="text/javascript" src="{{asset('/')}}js/myscript.js"></script>
<script type="text/javascript" src="{{asset('/')}}js/bootstrap-3.3.6-dist/js/bootstrap.js"></script>
<script type="text/javascript" src="{{asset('/')}}js/auth.js"></script>
</body>
</html>