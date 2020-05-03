<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php $themes = App\Theme::all(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Documents Module</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/bulma.css" rel="stylesheet">

    <link href="/css/default.css" rel="stylesheet" />
    <link href="/css/fonts.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />
</head>

<body>

@include('header')

<div id="wrapper">
    <div id="page" class="container row">

        <div class="col-10">
            @yield('content')
        </div>
        <div class="menu col-2 text-center light lighten-1">

            <ul class="nav nav-tabs flex-column lighten-4 py-4 list-group">
                <li><h3>Categorias</h3></li>
                <li class=" nav-item">
                    <a class="list-group-item {{ Request::is('documentos') ? 'active' : ''}}" href="/documentos">Todos</a>
                </li>

                @foreach($themes as $theme)
                <li class="nav-item ">
                    <a class="list-group-item {{ Request::is('documentos/categorias/'.$theme->name) ? 'active' : ''}}" href={{ $theme->path() }}>{{ $theme->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@include('footer')

</body>
