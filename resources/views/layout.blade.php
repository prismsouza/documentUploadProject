<!DOCTYPE html>
<?php
    $categories = App\Category::all();
    $tags = App\Tag::all();
    $user = "admin";
?>

@include('includes')

<body>
    @include('header')
    <div class="container">
    <!-- @ include('navbar') -->
    @if ($user == "admin")
        @include('navbar_admin')
    @endif

    @include('searchbar')



<div id="wrapper">
    <div id="page" class="container row py-3">

        <div class="col-9">
            @yield('content')
        </div>
        <div class="menu col-3 text-left light lighten-1">
            <ul class="nav nav-tabs flex-column lighten-4 list-group">
                <li style="padding-top: 5px">
                    <h3>
                        @if ($user=="admin") <a href={{route('categories.index')}}> Categorias </a>
                        @else Categorias @endif
                    </h3><br>
                </li>
                <li class="nav-item">
                    <a class="list-group-item {{ (Request::is('documentos') || Request::is('/')) ? 'active' : ''}}"
                       href="{{ route('documents.index') }}">
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


