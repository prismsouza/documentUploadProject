<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php $categories = App\Category::all(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Documents Module</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/bulma.css" rel="stylesheet">

    <link href="/css/default.css" rel="stylesheet" />
    <link href="/css/fonts.css" rel="stylesheet" />
    <link href="/css/mystyle.css" rel="stylesheet" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <script>
        $(document).on('click', '.dropdown-menu-button', function (e) {
            e.stopPropagation()
        });</script>
</head>

<body>
<div style="background: #F8F6F7">
@include('header')
@include('navbar')
@include('searchbar')

<div id="wrapper">
    <div id="page" class="container row">

        <div class="col-9">
            @yield('content')
        </div>
        <div class="menu col-3 text-left light lighten-1">
            <ul class="nav nav-tabs flex-column lighten-4 list-group">
                <li style="padding-top: 5px"><h3>Categorias</h3><br></li>
                <li class="nav-item">
                    <a class="list-group-item {{ Request::is('documentos') ? 'active' : ''}}"
                       href="/documentos">
                        <b>Todos</b>
                    </a>
                </li>

                @foreach($categories as $category)
                <li class="nav-item ">
                    <a class="list-group-item {{ Request::is('documentos/categorias/'.$category->name) ? 'active' : ''}}"
                       href={{ $category->path() }}>
                        <b>{{ $category->name }}</b><br>
                        <small>{{ $category->description }}</small>
                    </a>

                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</div>
@include('footer')

</body>
