<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Classic oldtimers | Rent</title>
    <meta name="description" content="Scarica gratis il nostro Template HTML/CSS GARAGE. Se avete bisogno di un design per il vostro sito web GARAGE può fare per voi. Web Domus Italia">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Stefan Jevtic">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/')}}images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}js/bootstrap-3.3.6-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}font-awesome-4.5.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}css/slider.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}css/style.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/')}}css/contactstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Gudea" rel="stylesheet">
</head>
<body>
<!-- Header -->
<div class="allcontain">
    @include("components.top")
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
<script type="text/javascript" src="{{asset('/')}}js/cars.js"></script>
<script type="text/javascript" src="{{asset('/')}}js/adminpanel.js"></script>
<script type="text/javascript" src="{{asset('/')}}js/contact.js"></script>
</body>
</html>